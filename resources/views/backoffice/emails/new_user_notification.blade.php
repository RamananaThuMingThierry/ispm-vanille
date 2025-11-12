<!DOCTYPE html>
<html>
<head>
    <title>{{ __('email.new_user_subject') }}</title>
</head>
<body>
    <h1>{{ __('email.new_user_title') }}</h1>
    <p><strong>{{ __('email.pseudo') }}:</strong> {{ $user->pseudo }}</p>
    <p><strong>{{ __('email.email') }}:</strong> {{ $user->email }}</p>
    <p><strong>{{ __('email.contact') }}:</strong> {{ $user->contact }}</p>
    <p><strong>{{ __('email.address') }}:</strong> {{ $user->adresse }}</p>
    <p>{{ __('email.new_user_check_app') }}</p>
    <p>{{ __('email.thank_you_using_app') }}</p>
</body>
</html>
