@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify OTP') }}</div>

                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="alert alert-warning" role="alert">
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <p>{{ __('We have sent a verification code to your phone number:') }} <strong>{{ $phone }}</strong></p>
                    <p>{{ __('Please enter the code below to login to your account.') }}</p>

                    <form method="POST" action="{{ route('login.otp.verify.submit') }}" id="otpForm">
                        @csrf

                        <div class="form-group row mb-3">
                            <label for="otp" class="col-md-4 col-form-label text-md-right">{{ __('Verification Code') }}</label>

                            <div class="col-md-6">
                                <div class="otp-input-container d-flex justify-content-between">
                                    <input type="text" class="form-control otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                    <input type="text" class="form-control otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                    <input type="text" class="form-control otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                    <input type="text" class="form-control otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                    <input type="text" class="form-control otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                    <input type="text" class="form-control otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" required>
                                </div>
                                <input id="otp" type="hidden" class="@error('otp') is-invalid @enderror" name="otp" required>
                                <small class="form-text text-muted">Enter the 6-digit code sent to your phone</small>

                                @error('otp')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                <a href="{{ route('login.otp.resend') }}" class="btn btn-link resend-otp" id="resendBtn">
                                    {{ __('Resend Code') }}
                                </a>
                                <span class="text-muted ms-2" id="timer" style="display: none;">Resend in <span id="countdown">60</span>s</span>
                            </div>
                        </div>
                    </form>

                    <style>
                        .otp-input-container {
                            gap: 8px;
                        }
                        .otp-digit {
                            width: 40px;
                            height: 45px;
                            text-align: center;
                            font-size: 1.2rem;
                        }
                    </style>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Handle OTP input fields
                            const otpDigits = document.querySelectorAll('.otp-digit');
                            const otpInput = document.getElementById('otp');
                            const form = document.getElementById('otpForm');
                            
                            // Focus the first input on page load
                            otpDigits[0].focus();
                            
                            // Auto-focus next input and handle backspace
                            otpDigits.forEach((digit, index) => {
                                digit.addEventListener('keydown', (e) => {
                                    // Handle backspace
                                    if (e.key === 'Backspace') {
                                        if (digit.value === '') {
                                            if (index > 0) {
                                                otpDigits[index - 1].focus();
                                                otpDigits[index - 1].select();
                                            }
                                        } else {
                                            digit.value = '';
                                        }
                                    }
                                });
                                
                                digit.addEventListener('input', (e) => {
                                    // Only allow numbers
                                    digit.value = digit.value.replace(/[^0-9]/g, '');
                                    
                                    // Auto-focus next input
                                    if (digit.value && index < otpDigits.length - 1) {
                                        otpDigits[index + 1].focus();
                                    }
                                    
                                    // Combine all digits into the hidden input
                                    updateOtpValue();
                                });
                                
                                // Handle paste event
                                digit.addEventListener('paste', (e) => {
                                    e.preventDefault();
                                    const pastedData = e.clipboardData.getData('text');
                                    const numericData = pastedData.replace(/[^0-9]/g, '');
                                    
                                    if (numericData.length === 6) {
                                        // Fill all inputs
                                        for (let i = 0; i < 6; i++) {
                                            otpDigits[i].value = numericData[i] || '';
                                        }
                                        updateOtpValue();
                                    }
                                });
                            });
                            
                            function updateOtpValue() {
                                otpInput.value = Array.from(otpDigits).map(d => d.value).join('');
                                
                                // Auto-submit when all digits are filled
                                if (otpInput.value.length === 6) {
                                    setTimeout(() => {
                                        form.submit();
                                    }, 300);
                                }
                            }
                            
                            // Handle resend timer
                            const resendBtn = document.getElementById('resendBtn');
                            const timer = document.getElementById('timer');
                            const countdown = document.getElementById('countdown');
                            
                            // Start timer on page load
                            startResendTimer();
                            
                            resendBtn.addEventListener('click', function(e) {
                                if (resendBtn.classList.contains('disabled')) {
                                    e.preventDefault();
                                } else {
                                    startResendTimer();
                                }
                            });
                            
                            function startResendTimer() {
                                let seconds = 60;
                                resendBtn.classList.add('disabled');
                                timer.style.display = 'inline';
                                countdown.textContent = seconds;
                                
                                const interval = setInterval(() => {
                                    seconds--;
                                    countdown.textContent = seconds;
                                    
                                    if (seconds <= 0) {
                                        clearInterval(interval);
                                        resendBtn.classList.remove('disabled');
                                        timer.style.display = 'none';
                                    }
                                }, 1000);
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
