<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'otp',
        'token',
        'type',
        'expires_at',
        'verified_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active OTPs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now())
                     ->whereNull('verified_at');
    }

    /**
     * Check if the OTP is expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        return $this->expires_at <= now();
    }

    /**
     * Check if the OTP is verified.
     *
     * @return bool
     */
    public function isVerified()
    {
        return $this->verified_at !== null;
    }

    /**
     * Mark the OTP as verified.
     *
     * @return bool
     */
    public function markAsVerified()
    {
        $this->verified_at = now();
        return $this->save();
    }

    /**
     * Generate a new OTP for a phone number.
     *
     * @param string $phone
     * @param string $type
     * @param int $length
     * @param int $expiryMinutes
     * @return Otp
     */
    public static function generateForPhone($phone, $type = 'registration', $length = 6, $expiryMinutes = 10)
    {
        // Invalidate any existing active OTPs for this phone and type
        self::where('phone', $phone)
            ->where('type', $type)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        // Generate a new OTP
        $otp = new self();
        $otp->phone = $phone;
        $otp->type = $type;
        $otp->otp = self::generateOtpCode($length);
        $otp->token = Str::random(64);
        $otp->expires_at = now()->addMinutes($expiryMinutes);
        $otp->save();

        return $otp;
    }

    /**
     * Generate a new OTP for an email.
     *
     * @param string $email
     * @param string $type
     * @param int $length
     * @param int $expiryMinutes
     * @return Otp
     */
    public static function generateForEmail($email, $type = 'registration', $length = 6, $expiryMinutes = 10)
    {
        // Invalidate any existing active OTPs for this email and type
        self::where('email', $email)
            ->where('type', $type)
            ->whereNull('verified_at')
            ->update(['expires_at' => now()]);

        // Generate a new OTP
        $otp = new self();
        $otp->email = $email;
        $otp->type = $type;
        $otp->otp = self::generateOtpCode($length);
        $otp->token = Str::random(64);
        $otp->expires_at = now()->addMinutes($expiryMinutes);
        $otp->save();

        return $otp;
    }

    /**
     * Verify an OTP for a phone number.
     *
     * @param string $phone
     * @param string $otp
     * @param string $type
     * @return bool|Otp
     */
    public static function verifyPhoneOtp($phone, $otp, $type = 'registration')
    {
        $otpRecord = self::where('phone', $phone)
                         ->where('otp', $otp)
                         ->where('type', $type)
                         ->active()
                         ->first();

        if (!$otpRecord) {
            return false;
        }

        $otpRecord->markAsVerified();
        return $otpRecord;
    }

    /**
     * Verify an OTP for an email.
     *
     * @param string $email
     * @param string $otp
     * @param string $type
     * @return bool|Otp
     */
    public static function verifyEmailOtp($email, $otp, $type = 'registration')
    {
        $otpRecord = self::where('email', $email)
                         ->where('otp', $otp)
                         ->where('type', $type)
                         ->active()
                         ->first();

        if (!$otpRecord) {
            return false;
        }

        $otpRecord->markAsVerified();
        return $otpRecord;
    }

    /**
     * Verify an OTP using a token.
     *
     * @param string $token
     * @return bool|Otp
     */
    public static function verifyToken($token)
    {
        $otpRecord = self::where('token', $token)
                         ->active()
                         ->first();

        if (!$otpRecord) {
            return false;
        }

        $otpRecord->markAsVerified();
        return $otpRecord;
    }

    /**
     * Generate a random OTP code.
     *
     * @param int $length
     * @return string
     */
    protected static function generateOtpCode($length = 6)
    {
        if ($length <= 0) {
            $length = 6;
        }

        return str_pad(random_int(0, pow(10, $length) - 1), $length, '0', STR_PAD_LEFT);
    }
}
