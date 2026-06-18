<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('created_at', 'desc')->get();

        $totalCoupons  = $coupons->count();
        $activeCoupons = $coupons->where('is_active', 1)->count();
        $expiredCoupons = $coupons->filter(function($c) {
            return $c->expires_at && $c->expires_at < now()->toDateString();
        })->count();
        $totalRedemptions = $coupons->sum('used_count');

        return view('admin.coupons', compact(
            'coupons', 'totalCoupons', 'activeCoupons', 'expiredCoupons', 'totalRedemptions'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code'             => 'required|string|max:50|unique:coupons,code',
            'type'             => 'required|in:percent,flat',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|date|after_or_equal:today',
            'is_active'        => 'required|in:0,1',
        ]);

        Coupon::create([
            'code'             => strtoupper(trim($request->code)),
            'type'             => $request->type,
            'value'            => $request->value,
            'min_order_amount' => $request->min_order_amount ?: 0,
            'usage_limit'      => $request->usage_limit,
            'used_count'       => 0,
            'expires_at'       => $request->expires_at,
            'is_active'        => $request->is_active,
        ]);

        return back()->with('success', "Coupon \"{$request->code}\" created successfully!");
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code'             => 'required|string|max:50|unique:coupons,code,' . $id,
            'type'             => 'required|in:percent,flat',
            'value'            => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit'      => 'nullable|integer|min:1',
            'expires_at'       => 'nullable|date',
            'is_active'        => 'required|in:0,1',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code'             => strtoupper(trim($request->code)),
            'type'             => $request->type,
            'value'            => $request->value,
            'min_order_amount' => $request->min_order_amount ?: 0,
            'usage_limit'      => $request->usage_limit,
            'expires_at'       => $request->expires_at,
            'is_active'        => $request->is_active,
        ]);

        return back()->with('success', "Coupon \"{$coupon->code}\" updated successfully!");
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();
        return back()->with('success', "Coupon \"{$coupon->code}\" deleted.");
    }

    public function toggle($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();
        $state = $coupon->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Coupon \"{$coupon->code}\" {$state} successfully.");
    }
}
