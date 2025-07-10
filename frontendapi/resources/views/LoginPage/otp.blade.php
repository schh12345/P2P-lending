<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
</head>
<body>
    <h1>Verify Your Email</h1>

    @if (session('message'))
        <p style="color: green;">{{ session('message') }}</p>
    @endif

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if (session('info'))
        <p style="color: blue;">{{ session('info') }}</p>
    @endif

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <p>An OTP has been sent to your email: <strong>{{ $email ?? Auth::user()->email }}</strong></p>

    <form method="POST" action="{{ route('otp.verify') }}">
        @csrf
        {{-- No email input needed here, as we get it from Auth::user() --}}
        <div>
            <label for="otp">Enter OTP:</label>
            <input type="text" id="otp" name="otp" required maxlength="6">
        </div>
        <div>
            <button type="submit">Verify</button>
        </div>
    </form>

    <p>Didn't receive the OTP?</p>
    <form method="POST" action="{{ route('otp.resend') }}">
        @csrf
        {{-- No hidden email input needed if we rely on Auth::user() --}}
        <button type="submit">Resend OTP</button>
    </form>
</body>
</html>
