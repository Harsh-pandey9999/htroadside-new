<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Store a newly created subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if this email is already subscribed
        $existingSubscription = NewsletterSubscription::where('email', $request->email)->first();

        if ($existingSubscription) {
            // If already subscribed but inactive, reactivate it
            if (!$existingSubscription->is_active) {
                $existingSubscription->resubscribe();
                return redirect()->back()->with('success', 'You have been resubscribed to our newsletter!');
            }
            
            // Already subscribed and active
            return redirect()->back()->with('info', 'You are already subscribed to our newsletter.');
        }

        // Create new subscription
        $subscription = new NewsletterSubscription();
        $subscription->email = $request->email;
        $subscription->name = $request->name ?? null;
        $subscription->user_id = Auth::id();
        $subscription->is_active = true;
        $subscription->subscribed_at = now();
        $subscription->ip_address = $request->ip();
        $subscription->user_agent = $request->userAgent();
        $subscription->save();

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }

    /**
     * Unsubscribe from the newsletter.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe($token)
    {
        // Decode the token to get the email
        try {
            $email = decrypt($token);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid unsubscribe link.');
        }

        $subscription = NewsletterSubscription::where('email', $email)->first();

        if (!$subscription) {
            return redirect()->route('home')->with('error', 'Subscription not found.');
        }

        $subscription->unsubscribe();

        return view('newsletter.unsubscribed', compact('email'));
    }

    /**
     * Show the confirmation page for unsubscribing.
     *
     * @param  string  $token
     * @return \Illuminate\Http\Response
     */
    public function confirmUnsubscribe($token)
    {
        try {
            $email = decrypt($token);
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Invalid unsubscribe link.');
        }

        return view('newsletter.confirm-unsubscribe', compact('token', 'email'));
    }
}
