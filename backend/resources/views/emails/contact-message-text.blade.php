New contact form submission — drugpharmaeg.com
================================================

Topic:   {{ $contact->topic ?: 'General Inquiry' }}
Name:    {{ $contact->name }}
Email:   {{ $contact->email }}
@if($contact->phone)Phone:   {{ $contact->phone }}
@endif
Sent:    {{ $contact->created_at->format('M d, Y \a\t H:i') }} UTC
IP:      {{ $contact->ip_address ?: 'unknown' }}

------------------------------------------------
{{ $contact->message }}
------------------------------------------------

Reply directly to this email to respond to the visitor.
