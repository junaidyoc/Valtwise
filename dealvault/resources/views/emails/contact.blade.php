<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Form Submission</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #10b981; padding: 20px; border-radius: 8px 8px 0 0;">
        <h1 style="color: white; margin: 0; font-size: 24px;">New Contact Form Submission</h1>
    </div>

    <div style="background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; border-top: none; border-radius: 0 0 8px 8px;">
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold; width: 120px;">Name:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">{{ $firstName }} {{ $lastName }}</td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Email:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    <a href="mailto:{{ $email }}" style="color: #10b981;">{{ $email }}</a>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb; font-weight: bold;">Subject:</td>
                <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                    @php
                        $subjects = [
                            'broken_coupon' => 'Report a broken coupon',
                            'suggest_store' => 'Suggest a store',
                            'general' => 'General question',
                            'partnership' => 'Partnership inquiry',
                            'other' => 'Other',
                        ];
                    @endphp
                    {{ $subjects[$subjectType] ?? $subjectType }}
                </td>
            </tr>
        </table>

        <div style="margin-top: 20px;">
            <strong>Message:</strong>
            <div style="background: white; padding: 15px; border-radius: 6px; margin-top: 8px; border: 1px solid #e5e7eb;">
                {!! nl2br(e($userMessage)) !!}
            </div>
        </div>
    </div>

    <p style="color: #6b7280; font-size: 12px; margin-top: 20px; text-align: center;">
        This email was sent from the Valtwise contact form.
    </p>
</body>
</html>
