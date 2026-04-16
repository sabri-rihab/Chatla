<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'request_type' => 'required|string|in:Bug/Error,false information,feature request,missing content,other',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Report::create($validated);

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
