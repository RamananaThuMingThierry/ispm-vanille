<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('email.password_reset_title') }}</title>
    <style>
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 20px;
            border-radius: 100%;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #000000;
            background-color: #e9be00;
            text-decoration: none;
            border-radius: 2px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://images.wakelet.com/resize?id=bTPWLcE1XYXJU0QLPFeJR&h=705&w=768&q=85" alt="Logo" class="logo">
        <p>{{ __('email.greeting') }}</p>
        <p>{{ __('email.reset_request_message') }}</p>
        <p><a href="{{ $resetUrl }}" class="button">{{ __('email.reset_button') }}</a></p>
        <p>{{ __('email.expiration_notice', ['count' => 60]) }}</p>
        <p>{{ __('email.ignore_notice') }}</p>
        <div class="footer">
            <p>{{ __('email.signature_closing') }}</p>
            <p>Ricki Cardo</p>
            <p>+261 38 09 137 03</p>
        </div>
    </div>
</body>
</html>
