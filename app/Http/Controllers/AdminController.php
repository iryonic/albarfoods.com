<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\InventoryLog;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Category;
use App\Models\Coupon;

class AdminController extends Controller
{
    public function dashboard()
    {
        // 1. Core KPIs
        $totalRevenue = Order::whereNotIn('status', ['Cancelled', 'Refunded'])->sum('grand_total');
        $totalOrders = Order::count();
        $totalCustomers = User::where('role_id', 4)->orWhereNull('role_id')->count();
        if ($totalCustomers == 0) {
            $totalCustomers = User::count();
        }
        $averageOrderValue = $totalOrders > 0 ? ($totalRevenue / $totalOrders) : 0;

        // 2. Inventory Stats
        $lowStockVariants = ProductVariant::with('product')
            ->where('stock', '<=', 10)
            ->get();
        $totalProductsCount = Product::count();

        // 3. Order Breakdown
        $ordersCountByStatus = Order::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // 4. Recent Orders & Activities
        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();
        $recentActivities = InventoryLog::with('variant.product')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 5. Chart Data: Daily Sales (Last 7 days)
        $dailySalesData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $sales = Order::whereNotIn('status', ['Cancelled', 'Refunded'])
                ->whereDate('created_at', $date)
                ->sum('grand_total');
            $dailySalesData[now()->subDays($i)->format('D, M d')] = (float)$sales;
        }

        // 6. Chart Data: Monthly Sales (Current Year)
        $monthlySalesData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1));
            $sales = Order::whereNotIn('status', ['Cancelled', 'Refunded'])
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', $m)
                ->sum('grand_total');
            $monthlySalesData[$monthName] = (float)$sales;
        }

        // 7. Top Products sold
        $topProducts = OrderItem::selectRaw('title, weight, sum(quantity) as total_qty, sum(price * quantity) as total_revenue')
            ->groupBy('title', 'weight')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        // 8. Top Categories sold
        $topCategories = DB::table('order_items')
            ->join('product_variants', 'order_items.product_variant_id', '=', 'product_variants.id')
            ->join('products', 'product_variants.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->selectRaw('categories.name, sum(order_items.quantity) as total_qty')
            ->groupBy('categories.name')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalCustomers', 'averageOrderValue',
            'lowStockVariants', 'totalProductsCount', 'ordersCountByStatus',
            'recentOrders', 'recentActivities', 'dailySalesData', 'monthlySalesData',
            'topProducts', 'topCategories'
        ));
    }

    public function products()
    {
        $products = Product::with(['variants.inventoryLogs', 'category'])->get();
        $categories = DB::table('categories')->get();
        return view('admin.products', compact('products', 'categories'));
    }

    public function inventory()
    {
        $variants = ProductVariant::with(['product', 'inventoryLogs' => function($q) {
            $q->orderBy('created_at', 'desc')->take(3);
        }])->get();

        $totalSkus        = $variants->count();
        $totalStock       = $variants->sum('stock');
        $lowStockCount    = $variants->where('stock', '>', 0)->where('stock', '<=', 10)->count();
        $outOfStockCount  = $variants->where('stock', '<=', 0)->count();

        $recentLogs = InventoryLog::with('variant.product')
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get();

        return view('admin.inventory', compact(
            'variants', 'totalSkus', 'totalStock', 'lowStockCount', 'outOfStockCount', 'recentLogs'
        ));
    }

    public function customers()
    {
        $customers = User::where(function($q) {
                $q->where('role_id', 4)->orWhereNull('role_id');
            })
            ->withCount('orders')
            ->withSum('orders', 'grand_total')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalCustomers   = $customers->count();
        $newThisMonth     = User::where(function($q) {
            $q->where('role_id', 4)->orWhereNull('role_id');
        })->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        $activeCustomers  = $customers->where('status', 'active')->count();
        $totalOrdersAll   = $customers->sum('orders_count');

        return view('admin.customers', compact(
            'customers', 'totalCustomers', 'newThisMonth', 'activeCustomers', 'totalOrdersAll'
        ));
    }

    public function toggleCustomerStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = ($user->status === 'active') ? 'inactive' : 'active';
        $user->save();
        return back()->with('success', "Customer {$user->name} status updated to {$user->status}.");
    }


    public function orders()
    {
        $orders = Order::with('items')->orderBy('created_at', 'desc')->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateStock(Request $request)
    {
        $request->validate([
            'variant_id' => 'required|integer',
            'stock_change' => 'required|integer',
            'type' => 'required|string|in:Stock In,Stock Out,Adjustment'
        ]);

        $variant = ProductVariant::findOrFail($request->variant_id);
        $variant->increment('stock', $request->stock_change);

        DB::table('inventory_logs')->insert([
            'product_variant_id' => $variant->id,
            'quantity_change' => $request->stock_change,
            'type' => $request->type,
            'log_message' => 'Admin manual adjustment',
            'created_at' => now()
        ]);

        return back()->with('success', 'Stock updated successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Confirmed,Processing,Packed,Shipped,Delivered,Cancelled,Returned,Refunded',
            'payment_status' => 'required|string|in:Pending,Completed,Failed,Refunded'
        ]);

        $order = Order::with('items.variant')->findOrFail($id);
        $oldStatus = $order->status;
        $newStatus = $request->status;

        $cancelledOrRefunded = ['cancelled', 'refunded'];

        try {
            DB::beginTransaction();

            // 1. Transitioning to Cancelled/Refunded from active status
            if (in_array(strtolower($newStatus), $cancelledOrRefunded) && !in_array(strtolower($oldStatus), $cancelledOrRefunded)) {
                // Restore Stock
                foreach ($order->items as $item) {
                    $variant = $item->variant;
                    if ($variant) {
                        $variant->increment('stock', $item->quantity);
                        DB::table('inventory_logs')->insert([
                            'product_variant_id' => $variant->id,
                            'quantity_change' => $item->quantity,
                            'type' => 'Stock In',
                            'log_message' => "Order #{$order->order_number} cancelled/refunded by Admin",
                            'created_at' => now()
                        ]);
                    }
                }
            }
            // 2. Transitioning from Cancelled/Refunded back to active status
            elseif (!in_array(strtolower($newStatus), $cancelledOrRefunded) && in_array(strtolower($oldStatus), $cancelledOrRefunded)) {
                // Deduct Stock
                foreach ($order->items as $item) {
                    $variant = $item->variant;
                    if ($variant) {
                        $variant->decrement('stock', $item->quantity);
                        DB::table('inventory_logs')->insert([
                            'product_variant_id' => $variant->id,
                            'quantity_change' => -$item->quantity,
                            'type' => 'Stock Out',
                            'log_message' => "Order #{$order->order_number} re-opened by Admin",
                            'created_at' => now()
                        ]);
                    }
                }
            }

            // Update Order
            $order->status = $newStatus;
            $order->payment_status = $request->payment_status;
            $order->save();

            DB::commit();
            return back()->with('success', "Order #{$order->order_number} status updated successfully!");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', "Failed to update order status: " . $e->getMessage());
        }
    }

    public function returns()
    {
        $returns = \App\Models\ReturnRequest::with(['order.items', 'user', 'refund'])->orderBy('created_at', 'desc')->get();
        return view('admin.returns', compact('returns'));
    }

    public function approveReturn($id)
    {
        $return = \App\Models\ReturnRequest::findOrFail($id);
        $return->status = 'Approved';
        $return->save();

        // Update order status to Returned
        $order = $return->order;
        $order->status = 'Returned';
        $order->save();

        // Create pending refund record
        \App\Models\Refund::updateOrCreate(
            ['return_id' => $return->id],
            [
                'amount' => $order->grand_total,
                'status' => 'Pending'
            ]
        );

        return back()->with('success', 'Return request approved successfully! Refund record created.');
    }

    public function rejectReturn($id)
    {
        $return = \App\Models\ReturnRequest::findOrFail($id);
        $return->status = 'Rejected';
        $return->save();

        return back()->with('success', 'Return request rejected successfully.');
    }

    public function processRefund(Request $request, $id)
    {
        $request->validate([
            'transaction_reference' => 'required|string|max:255'
        ]);

        $return = \App\Models\ReturnRequest::findOrFail($id);
        $refund = \App\Models\Refund::where('return_id', $return->id)->firstOrFail();

        $refund->status = 'Processed';
        $refund->transaction_reference = $request->transaction_reference;
        $refund->save();

        $return->status = 'Completed';
        $return->save();

        $order = $return->order;
        $order->status = 'Refunded';
        $order->payment_status = 'Refunded';
        $order->save();

        return back()->with('success', 'Refund processed successfully! Order status set to Refunded.');
    }

    public function tickets()
    {
        $tickets = \App\Models\SupportTicket::with(['user', 'assignedAgent'])->orderBy('created_at', 'desc')->get();
        return view('admin.tickets', compact('tickets'));
    }

    public function ticketShow($id)
    {
        $ticket = \App\Models\SupportTicket::with(['user', 'replies.user', 'assignedAgent'])->findOrFail($id);
        return view('admin.ticket-show', compact('ticket'));
    }

    public function ticketReply(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|min:2',
            'status' => 'required|string|in:Open,In Progress,Resolved,Closed'
        ]);

        $ticket = \App\Models\SupportTicket::findOrFail($id);
        
        \App\Models\TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'message' => $request->message
        ]);

        $ticket->status = $request->status;
        $ticket->save();

        return back()->with('success', 'Your reply has been posted successfully!');
    }

    public function ticketClose($id)
    {
        $ticket = \App\Models\SupportTicket::findOrFail($id);
        $ticket->status = 'Closed';
        $ticket->save();

        return back()->with('success', 'Ticket closed successfully.');
    }

    public function ticketAssign($id)
    {
        $ticket = \App\Models\SupportTicket::findOrFail($id);
        $ticket->assigned_to = \Illuminate\Support\Facades\Auth::id();
        $ticket->status = 'In Progress';
        $ticket->save();

        return back()->with('success', 'Ticket assigned to you successfully!');
    }

    public function reviews()
    {
        $reviews = \App\Models\Review::with(['product', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function approveReview($id)
    {
        $review = \App\Models\Review::findOrFail($id);
        $review->status = 'Approved';
        $review->save();

        return back()->with('success', 'Review approved successfully and is now live!');
    }

    public function rejectReview($id)
    {
        $review = \App\Models\Review::findOrFail($id);
        $review->status = 'Rejected';
        $review->save();

        return back()->with('success', 'Review has been rejected.');
    }

    public function settings()
    {
        $settings = \App\Models\Setting::all()->groupBy('group');
        return view('admin.settings', compact('settings'));
    }

    public function updateSettings(Request $request)
    {
        $settingsData = $request->except('_token');
        
        foreach ($settingsData as $key => $value) {
            $setting = \App\Models\Setting::where('key', $key)->first();
            if ($setting) {
                $setting->value = $value ?? '';
                $setting->save();
            } else {
                $group = 'site';
                if (str_starts_with($key, 'smtp_')) { $group = 'smtp'; }
                elseif (str_starts_with($key, 'bank_')) { $group = 'bank'; }
                elseif (str_ends_with($key, '_link')) { $group = 'social'; }
                elseif (str_starts_with($key, 'meta_') || str_starts_with($key, 'seo_')) { $group = 'seo'; }
                
                \App\Models\Setting::create([
                    'group' => $group,
                    'key' => $key,
                    'value' => $value ?? ''
                ]);
            }
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:255',
            'description' => 'required|string',
            'origin' => 'required|string|max:255',
            'nutrition' => 'nullable|string',
            'storage' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'variants' => 'nullable|array',
            'variants.*.weight' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.orig_price' => 'required|numeric|min:0',
            'variants.*.sku' => 'required|string|unique:product_variants,sku',
            'variants.*.stock' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $slug = \Illuminate\Support\Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $product = Product::create([
                'category_id' => $request->category_id,
                'brand_id' => 1,
                'title' => $request->title,
                'slug' => $slug,
                'badge' => $request->badge,
                'description' => $request->description,
                'origin' => $request->origin,
                'nutrition' => $request->nutrition,
                'storage' => $request->storage,
                'image' => $request->image ?? 'assets/img/logoalbar.png',
                'is_active' => $request->is_active
            ]);

            if ($request->filled('variants')) {
                foreach ($request->variants as $v) {
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'weight' => $v['weight'],
                        'price' => $v['price'],
                        'orig_price' => $v['orig_price'],
                        'sku' => $v['sku'],
                        'stock' => $v['stock']
                    ]);

                    DB::table('inventory_logs')->insert([
                        'product_variant_id' => $variant->id,
                        'quantity_change' => $v['stock'],
                        'type' => 'Stock In',
                        'log_message' => 'Initial stock on creation',
                        'created_at' => now()
                    ]);
                }
            }

            DB::commit();
            return back()->with('success', 'Product and variants created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to create product: ' . $e->getMessage());
        }
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'badge' => 'nullable|string|max:255',
            'description' => 'required|string',
            'origin' => 'required|string|max:255',
            'nutrition' => 'nullable|string',
            'storage' => 'nullable|string',
            'image' => 'nullable|string|max:255',
            'is_active' => 'required|boolean'
        ]);

        $product = Product::findOrFail($id);
        
        $slug = \Illuminate\Support\Str::slug($request->title);
        if ($product->title !== $request->title) {
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $product->slug = $slug;
        }

        $product->category_id = $request->category_id;
        $product->title = $request->title;
        $product->badge = $request->badge;
        $product->description = $request->description;
        $product->origin = $request->origin;
        $product->nutrition = $request->nutrition;
        $product->storage = $request->storage;
        if ($request->filled('image')) {
            $product->image = $request->image;
        }
        $product->is_active = $request->is_active;
        $product->save();

        return back()->with('success', 'Product details updated successfully!');
    }

    public function deleteProduct($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);
            foreach ($product->variants as $variant) {
                DB::table('inventory_logs')->where('product_variant_id', $variant->id)->delete();
                $variant->delete();
            }
            $product->delete();
            DB::commit();
            return back()->with('success', 'Product and all its variants deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }

    public function storeVariant(Request $request, $productId)
    {
        $request->validate([
            'weight' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'orig_price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:product_variants,sku',
            'stock' => 'required|integer|min:0'
        ]);

        $variant = ProductVariant::create([
            'product_id' => $productId,
            'weight' => $request->weight,
            'price' => $request->price,
            'orig_price' => $request->orig_price,
            'sku' => $request->sku,
            'stock' => $request->stock
        ]);

        DB::table('inventory_logs')->insert([
            'product_variant_id' => $variant->id,
            'quantity_change' => $request->stock,
            'type' => 'Stock In',
            'log_message' => 'Initial stock on variant addition',
            'created_at' => now()
        ]);

        return back()->with('success', 'Variant added successfully!');
    }

    public function updateVariant(Request $request, $id)
    {
        $request->validate([
            'weight' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'orig_price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:product_variants,sku,' . $id,
            'stock' => 'required|integer|min:0'
        ]);

        $variant = ProductVariant::findOrFail($id);
        $oldStock = $variant->stock;
        
        $variant->update($request->only('weight', 'price', 'orig_price', 'sku', 'stock'));

        if ($oldStock !== (int)$request->stock) {
            $diff = (int)$request->stock - $oldStock;
            DB::table('inventory_logs')->insert([
                'product_variant_id' => $variant->id,
                'quantity_change' => $diff,
                'type' => $diff > 0 ? 'Stock In' : 'Stock Out',
                'log_message' => 'Stock updated via variant edit',
                'created_at' => now()
            ]);
        }

        return back()->with('success', 'Variant details updated successfully!');
    }

    public function deleteVariant($id)
    {
        try {
            DB::beginTransaction();
            $variant = ProductVariant::findOrFail($id);
            DB::table('inventory_logs')->where('product_variant_id', $variant->id)->delete();
            $variant->delete();
            DB::commit();
            return back()->with('success', 'Variant deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to delete variant: ' . $e->getMessage());
        }
    }
}
