<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('identity::messages.forgot_title') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container py-5" style="max-width: 480px;">
    <h1 class="h3 mb-3">{{ __('identity::messages.forgot_title') }}</h1>
    @if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
    <form method="POST" action="{{ route('identity.forgot-password.post') }}">
        @csrf
        <div class="mb-3"><label class="form-label">{{ __('messages.email') }}</label><input type="email" class="form-control" name="email" required></div>
        <button class="btn btn-primary w-100">{{ __('identity::messages.send_reset_link') }}</button>
    </form>
</div>
</body>
</html>
