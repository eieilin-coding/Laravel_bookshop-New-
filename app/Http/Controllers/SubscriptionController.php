<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Mail\SubscriptionVerification;
use Illuminate\Support\Facades\Mail;

class SubscriptionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email'
        ]);

        $subscriber = Subscribe::create([
            'email' => $request->email
        ]);

        // Send verification email
        Mail::to($subscriber->email)->send(new SubscriptionVerification($subscriber));

        return back()->with('success', 'Please check your email to verify your subscription.');
    }
    public function verify($token)
    {
        $subscriber = Subscribe::where('verification_token', $token)->firstOrFail();

        $subscriber->update([
            'is_verified' => true,
            'verified_at' => now(),
            'verification_token' => null
        ]);

        return redirect('/')->with('success', 'Your email has been verified! You will now receive updates.');
    }
}
