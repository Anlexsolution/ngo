<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Crypt;

class MailHelper
{
    /**
     * Send an activation email to the user.
     *
     * @param string $email User's email address
     * @param string $firstName User's first name
     * @param string $lastName User's last name
     * @return bool|string Returns true if the email was sent, or an error message.
     */


     public static function sendOtpEmail($email, $fullName, $otpCode)
{
    try {
        $otp = $otpCode; // Generate 6-digit OTP

        // Store OTP securely (example using session or DB is recommended)
        // Session::put('user_otp_' . $email, $otp);
        // or save to `user_otps` table

        // HTML email content with OTP
        $htmlContent = '
     <div style="font-family: Arial, sans-serif; background-color: #f4f7fa; padding: 30px; border-radius: 8px; text-align: center;">
            <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <h2 style="color: #4CAF50;">Hello ' . $fullName . '!</h2>
                <p style="font-size: 16px; color: #333333;">Thank you for registering with our NGO System.</p>
                
                <p style="font-size: 16px; color: #333333; margin-top: 20px;">Please use the following One-Time Password (OTP) to verify your email address:</p>
                
                <div style="font-size: 28px; font-weight: bold; color: #28a745; margin: 20px 0;">' . $otp . '</div>

                <p style="font-size: 14px; color: #777777;">. Do not share it with anyone.</p>

                <div style="margin-top: 30px; text-align: center; border-top: 2px solid #f4f7fa; padding-top: 20px;">
                    <p style="font-size: 12px; color: #999999;">Need help? Contact <a href="mailto:support@example.com" style="color: #28a745;">support@example.com</a></p>
                    <p style="font-size: 12px; color: #999999;">&copy; ' . date('Y') . 'NGO Team. All rights reserved.</p>
                </div>
            </div>
        </div>';

        // Send email
        Mail::html($htmlContent, function ($message) use ($email) {
            $message->to($email)
                ->subject('Your OTP Code - NGO System');
        });

        return $otp; // You can return the OTP if needed (e.g., for debugging or storing)

    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
}


}
