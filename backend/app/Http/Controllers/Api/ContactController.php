<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    /**
     * POST /api/contact
     * Receive contact form submissions from the frontend.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:120'],
            'email'   => ['required', 'email:rfc', 'max:160'],
            'phone'   => ['nullable', 'string', 'max:30'],
            'topic'   => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'min:5', 'max:5000'],
        ]);

        $message = ContactMessage::create([
            ...$validated,
            'topic'      => $validated['topic'] ?? 'General Inquiry',
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Thanks! We\'ll get back to you within one business day.',
            'id'      => $message->id,
        ], 201);
    }
}
