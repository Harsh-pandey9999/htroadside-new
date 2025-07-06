<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    /**
     * Store a newly created feedback in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'email' => 'nullable|email',
            'reason' => 'nullable|string',
            'comments' => 'nullable|string|max:1000',
        ]);

        $feedback = new Feedback();
        $feedback->type = $request->type;
        $feedback->email = $request->email;
        $feedback->reason = $request->reason;
        $feedback->comments = $request->comments;
        $feedback->ip_address = $request->ip();
        $feedback->user_agent = $request->userAgent();
        $feedback->save();

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
}
