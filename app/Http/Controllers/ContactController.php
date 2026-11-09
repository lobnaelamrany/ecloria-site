<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('contact');
    }

    public function send(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // هنا يمكن إرسال إيميل (Mail::to(...)->send(...))
        // فـ v1، كنخليوها غير رسالة نجاح.

        return back()->with('success', 'Merci ! Votre message a été envoyé.');
    }
}
