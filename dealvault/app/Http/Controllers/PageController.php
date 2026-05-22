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
        // Spam check 1: Honeypot field (bots fill hidden fields)
        if ($request->filled('website')) {
            return redirect()->route('contact')
                ->with('contact_success', true); // Fake success to fool bots
        }

        // Spam check 2: Form submitted too fast (< 3 seconds = bot)
        $formTime = $request->input('form_time', 0);
        if ($formTime && (time() - $formTime) < 3) {
            return redirect()->route('contact')
                ->with('contact_success', true);
        }

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|in:broken_coupon,suggest_store,general,partnership,other',
            'message' => 'required|string|max:5000',
        ]);

        // Spam check 3: Block common spam patterns
        $spamPatterns = [
            '/\b(viagra|cialis|casino|lottery|winner|crypto.*invest|earn.*money|click.*here)\b/i',
            '/(http[s]?:\/\/.*){3,}/i', // More than 2 URLs
            '/(.)\1{10,}/', // Same character repeated 10+ times
        ];

        $content = $validated['first_name'] . ' ' . $validated['message'];
        foreach ($spamPatterns as $pattern) {
            if (preg_match($pattern, $content)) {
                return redirect()->route('contact')
                    ->with('contact_success', true);
            }
        }

        Mail::to('contactvaltwise@gmail.com')->send(new ContactMail(
            firstName: $validated['first_name'],
            lastName: $validated['last_name'] ?? '',
            email: $validated['email'],
            subjectType: $validated['subject'],
            userMessage: $validated['message']
        ));

        return redirect()->route('contact')
            ->with('contact_success', true);
    }

}
