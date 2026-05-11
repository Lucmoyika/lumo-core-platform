<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('identity::messages.register_title') }} — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container py-5" style="max-width: 520px;">
    <h1 class="h3 mb-3">{{ __('identity::messages.register_title') }}</h1>
    <form method="POST" action="{{ route('identity.register.post') }}">
        @csrf
        <div class="mb-3"><label class="form-label">{{ __('messages.name') }}</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
        <div class="mb-3"><label class="form-label">{{ __('messages.email') }}</label><input type="email" class="form-control" name="email" value="{{ old('email') }}" required></div>
        <div class="mb-3"><label class="form-label">{{ __('messages.password') }}</label><input type="password" class="form-control" name="password" required></div>
        <div class="mb-3"><label class="form-label">{{ __('messages.password') }} (confirmation)</label><input type="password" class="form-control" name="password_confirmation" required></div>
        <button class="btn btn-primary w-100">{{ __('messages.register') }}</button>
    </form>
    <div class="mt-2">{{ __('identity::messages.have_account') }} <a href="{{ route('identity.login') }}">{{ __('messages.login') }}</a></div>
</div>
</body>
</html>
