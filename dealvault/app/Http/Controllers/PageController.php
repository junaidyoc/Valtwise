<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function terms()
    {
        return view('pages.terms');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function howToUse()
    {
        return view('pages.how-to-use');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|in:broken_coupon,suggest_store,general,partnership,other',
            'message' => 'required|string|max:5000',
        ]);

        Mail::to('contactvaltwise@gmail.com')->send(new ContactMail(
            firstName: $validated['first_name'],
            lastName: $validated['last_name'] ?? '',
            email: $validated['email'],
            subject: $validated['subject'],
            userMessage: $validated['message']
        ));

        return redirect()->route('contact')
            ->with('contact_success', true);
    }

}
