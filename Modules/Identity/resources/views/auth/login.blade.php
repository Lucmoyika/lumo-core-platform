<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('identity::messages.login_title') }} — {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container py-5" style="max-width: 480px;">
    <h1 class="h3 mb-3">{{ __('identity::messages.login_title') }}</h1>
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('identity.login.post') }}">
        @csrf
        <div class="mb-3"><label class="form-label">{{ __('messages.email') }}</label><input class="form-control" name="email" value="{{ old('email') }}" required></div>
        <div class="mb-3"><label class="form-label">{{ __('messages.password') }}</label><input type="password" class="form-control" name="password" required></div>
        <div class="mb-3 form-check"><input type="checkbox" class="form-check-input" name="remember" id="remember"><label class="form-check-label" for="remember">{{ __('messages.remember_me') }}</label></div>
        <button class="btn btn-primary w-100">{{ __('messages.login') }}</button>
    </form>
    <div class="mt-3"><a href="{{ route('identity.forgot-password') }}">{{ __('messages.forgot_password') }}</a></div>
    <div class="mt-2">{{ __('identity::messages.no_account') }} <a href="{{ route('identity.register') }}">{{ __('messages.register') }}</a></div>
</div>
</body>
</html>
