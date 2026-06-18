<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = CmsPage::where('slug', 'about-us')->first();
        return view('about', compact('page'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        // Mock mail/saving contact messages logic
        return response()->json([
            'success' => 'Thank you for reaching out! Our team will get back to you shortly.'
        ]);
    }

    public function terms()
    {
        $page = CmsPage::where('slug', 'terms-conditions')->first();
        return view('terms', compact('page'));
    }

    public function privacy()
    {
        $page = CmsPage::where('slug', 'privacy-policy')->first();
        return view('privacy', compact('page'));
    }

    public function offline()
    {
        return view('offline');
    }
}
