<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function index()
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $files = File::files($backupDir);
        $backups = [];

        foreach ($files as $file) {
            if ($file->getExtension() === 'sql') {
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'size' => $file->getSize(),
                    'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            }
        }

        // Sort backups by date descending
        usort($backups, function($a, $b) {
            return strcmp($b['created_at'], $a['created_at']);
        });

        return view('admin.backups', compact('backups'));
    }

    public function create()
    {
        try {
            $backupDir = storage_path('app/backups');
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }

            $sqlContent = $this->generateBackupSql();
            $filename = 'backup-' . date('Y-m-d-H-i-s') . '.sql';
            File::put($backupDir . '/' . $filename, $sqlContent);

            return back()->with('success', "Database backup '{$filename}' created successfully!");
        } catch (\Exception $e) {
            return back()->with('error', "Backup generation failed: " . $e->getMessage());
        }
    }

    public function download($filename)
    {
        $filename = basename($filename);
        $path = storage_path('app/backups/' . $filename);

        if (!File::exists($path)) {
            abort(404, "Backup file not found.");
        }

        return response()->download($path);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'filename' => 'required|string'
        ]);

        try {
            $filename = basename($request->filename);
            $path = storage_path('app/backups/' . $filename);

            if (!File::exists($path)) {
                return back()->with('error', "Selected backup file does not exist.");
            }

            DB::beginTransaction();
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            
            $sql = File::get($path);
            DB::unprepared($sql);
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            DB::commit();

            return back()->with('success', "Database successfully restored from backup '{$filename}'!");
        } catch (\Exception $e) {
            DB::rollBack();
            // Ensure foreign key checks are restored even on error
            try {
                DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            } catch (\Exception $ex) {}
            return back()->with('error', "Database restoration failed: " . $e->getMessage());
        }
    }

    public function delete($filename)
    {
        try {
            $filename = basename($filename);
            $path = storage_path('app/backups/' . $filename);

            if (File::exists($path)) {
                File::delete($path);
                return back()->with('success', "Backup file '{$filename}' deleted successfully.");
            }

            return back()->with('error', "Backup file not found.");
        } catch (\Exception $e) {
            return back()->with('error', "Failed to delete backup: " . $e->getMessage());
        }
    }

    private function generateBackupSql()
    {
        $databaseName = DB::connection()->getDatabaseName();
        $dbTables = DB::select('SHOW TABLES');
        $keyName = 'Tables_in_' . $databaseName;

        $sql = "-- Al Barr Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n";
        $sql .= "-- Database: " . $databaseName . "\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($dbTables as $tableObj) {
            $tableName = $tableObj->$keyName;
            
            // Get create table sql statement
            $createTableResult = DB::select("SHOW CREATE TABLE `$tableName`")[0];
            $createTableSql = $createTableResult->{'Create Table'} ?? $createTableResult->{'Create Text'};
            
            $sql .= "-- Table structure for table `{$tableName}`\n";
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            $sql .= $createTableSql . ";\n\n";
            
            // Dump data
            $rows = DB::table($tableName)->get();
            if ($rows->count() > 0) {
                $sql .= "-- Dumping data for table `{$tableName}`\n";
                foreach ($rows as $row) {
                    $rowArray = (array)$row;
                    $columns = array_keys($rowArray);
                    $escapedValues = array_map(function($value) {
                        if (is_null($value)) {
                            return 'NULL';
                        }
                        return DB::connection()->getPdo()->quote($value);
                    }, array_values($rowArray));
                    
                    $sql .= "INSERT INTO `{$tableName}` (`" . implode("`, `", $columns) . "`) VALUES (" . implode(", ", $escapedValues) . ");\n";
                }
                $sql .= "\n";
            }
        }
        
        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        return $sql;
    }
}
