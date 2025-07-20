<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscribe;
use App\Mail\Newsletter;
use Illuminate\Support\Facades\Mail;

class NewsletterController extends Controller
{
   public function index()
    {
        $subscribers = Subscribe::where('is_verified', true)->get();
        return view('admin.subscribers', compact('subscribers'));
    }
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $subscribers = Subscribe::where('is_verified', true)->get();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)
                ->send(new Newsletter($request->subject, $request->message));
        }

        return back()->with('success', 'Newsletter sent successfully to all subscribers.');
    }
}
