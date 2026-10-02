<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New enquiry</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f7f3ef; font-family: Arial, sans-serif; color: #1f2937;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f7f3ef; padding: 32px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border: 1px solid #e7ddd2; border-radius: 12px; overflow: hidden;">
                    <tr>
                        <td style="padding: 28px 32px; background-color: #4a2a16; color: #ffffff; font-size: 24px; font-weight: bold;">
                            New enquiry from Crumbs & Crown
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 28px 32px;">
                            <p style="margin: 0 0 12px; font-size: 16px; line-height: 1.6;">
                                A customer has submitted a new enquiry through the contact form.
                            </p>

                            <table role="presentation" width="100%" cellpadding="8" cellspacing="0" style="border-collapse: collapse; margin-top: 20px; font-size: 14px; line-height: 1.6;">
                                <tr>
                                    <td style="font-weight: bold; width: 160px; border-bottom: 1px solid #f1e7df;">Full name</td>
                                    <td style="border-bottom: 1px solid #f1e7df;">{{ $payload['fullName'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width: 160px; border-bottom: 1px solid #f1e7df;">Email</td>
                                    <td style="border-bottom: 1px solid #f1e7df;">{{ $payload['email'] }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width: 160px; border-bottom: 1px solid #f1e7df;">Phone</td>
                                    <td style="border-bottom: 1px solid #f1e7df;">{{ $payload['phone'] ?: 'Not provided' }}</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold; width: 160px; border-bottom: 1px solid #f1e7df;">Enquiry type</td>
                                    <td style="border-bottom: 1px solid #f1e7df;">{{ ucfirst(str_replace(['-', '_'], ' ', (string) ($payload['enquiryType'] ?? 'General enquiry'))) }}</td>
                                </tr>
                            </table>

                            <p style="margin: 24px 0 8px; font-size: 15px; font-weight: bold;">Message</p>
                            <div style="background: #f7f3ef; border: 1px solid #eee3d7; border-radius: 8px; padding: 16px; color: #374151; line-height: 1.7; white-space: pre-wrap;">
                                {{ $payload['message'] }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
