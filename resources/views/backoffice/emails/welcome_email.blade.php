<!DOCTYPE html>
<html>
<head>
    <title>{{ __('email.welcome_subject') }}</title>
</head>
<body>
    <h1>{{ __('email.welcome_title', ['name' => $user->pseudo]) }}</h1>
    <p>{{ __('email.welcome_message') }}</p>
</body>
</html>
