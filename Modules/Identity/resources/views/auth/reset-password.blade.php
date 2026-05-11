<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('identity::messages.reset_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container py-5" style="max-width: 480px;">
    <h1 class="h3 mb-3">{{ __('identity::messages.reset_title') }}</h1>
    <form method="POST" action="{{ route('identity.reset-password.post') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
        <div class="mb-3"><label class="form-label">{{ __('messages.password') }}</label><input type="password" class="form-control" name="password" required></div>
        <div class="mb-3"><label class="form-label">{{ __('messages.password') }} (confirmation)</label><input type="password" class="form-control" name="password_confirmation" required></div>
        <button class="btn btn-primary w-100">{{ __('messages.reset_password') }}</button>
    </form>
</div>
</body>
</html>
