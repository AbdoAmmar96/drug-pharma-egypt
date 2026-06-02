<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New contact form submission</title>
</head>
<body style="margin:0;padding:0;background:#f4f5f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Arial,sans-serif;color:#1F1F2E;">
  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4f5f8;padding:24px 0;">
    <tr>
      <td align="center">
        <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 1px 4px rgba(0,0,0,0.04);">
          <tr>
            <td style="background:#1B2360;padding:24px 32px;">
              <h1 style="margin:0;color:#ffffff;font-size:20px;font-weight:700;">Drug Pharma Egypt — Website Contact</h1>
              <p style="margin:6px 0 0;color:rgba(255,255,255,0.75);font-size:13px;">A visitor submitted the contact form on drugpharmaeg.com</p>
            </td>
          </tr>

          <tr>
            <td style="padding:28px 32px 8px;">
              <h2 style="margin:0 0 4px;font-size:18px;color:#1B2360;">{{ $contact->topic ?: 'General Inquiry' }}</h2>
              <p style="margin:0;color:#6B6B7A;font-size:13px;">Submitted {{ $contact->created_at->format('M d, Y \a\t H:i') }} UTC</p>
            </td>
          </tr>

          <tr>
            <td style="padding:16px 32px 24px;">
              <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:14.5px;line-height:1.55;">
                <tr>
                  <td style="padding:8px 0;width:110px;color:#6B6B7A;vertical-align:top;">Name</td>
                  <td style="padding:8px 0;color:#1F1F2E;font-weight:600;">{{ $contact->name }}</td>
                </tr>
                <tr>
                  <td style="padding:8px 0;color:#6B6B7A;vertical-align:top;">Email</td>
                  <td style="padding:8px 0;"><a href="mailto:{{ $contact->email }}" style="color:#E87330;text-decoration:none;">{{ $contact->email }}</a></td>
                </tr>
                @if($contact->phone)
                <tr>
                  <td style="padding:8px 0;color:#6B6B7A;vertical-align:top;">Phone</td>
                  <td style="padding:8px 0;"><a href="tel:{{ $contact->phone }}" style="color:#1B2360;text-decoration:none;">{{ $contact->phone }}</a></td>
                </tr>
                @endif
                <tr>
                  <td style="padding:8px 0;color:#6B6B7A;vertical-align:top;">Topic</td>
                  <td style="padding:8px 0;color:#1F1F2E;">{{ $contact->topic ?: 'General Inquiry' }}</td>
                </tr>
              </table>

              <div style="margin-top:18px;padding:18px 20px;background:#FBE3D2;border-radius:8px;color:#1F1F2E;font-size:14.5px;line-height:1.6;white-space:pre-wrap;">{{ $contact->message }}</div>

              <p style="margin:24px 0 0;color:#6B6B7A;font-size:12.5px;">
                You can reply directly to this email — it will go straight to {{ $contact->name }} at {{ $contact->email }}.
              </p>
            </td>
          </tr>

          <tr>
            <td style="padding:14px 32px 24px;background:#FAFAFC;color:#9A9AA6;font-size:12px;text-align:center;">
              Sent from drugpharmaeg.com · IP {{ $contact->ip_address ?: 'unknown' }}
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
