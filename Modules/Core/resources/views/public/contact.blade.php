@extends('core::components.layouts.public')

@section('title', __('core::messages.contact_title'))

@section('content')
<section class="py-5" style="min-height:70vh;background:#0f172a;padding-top:5rem!important;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 style="font-family:'Poppins',sans-serif;font-weight:800;color:white;margin-bottom:0.5rem;">{{ __('core::messages.contact_title') }}</h1>
                <p style="color:#64748b;margin-bottom:2rem;">{{ __('core::messages.contact_desc') }}</p>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                
                <form action="{{ route('core.contact.send') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label style="color:#94a3b8;font-size:0.9rem;">Nom complet</label>
                        <input type="text" name="name" class="form-control" style="background:#1e293b;border-color:#334155;color:white;" required>
                        @error('name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label style="color:#94a3b8;font-size:0.9rem;">E-mail</label>
                        <input type="email" name="email" class="form-control" style="background:#1e293b;border-color:#334155;color:white;" required>
                        @error('email')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label style="color:#94a3b8;font-size:0.9rem;">Sujet</label>
                        <input type="text" name="subject" class="form-control" style="background:#1e293b;border-color:#334155;color:white;" required>
                        @error('subject')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-4">
                        <label style="color:#94a3b8;font-size:0.9rem;">Message</label>
                        <textarea name="message" rows="5" class="form-control" style="background:#1e293b;border-color:#334155;color:white;" required></textarea>
                        @error('message')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn w-100" style="background:#6366f1;color:white;padding:0.75rem;border-radius:0.75rem;font-weight:600;">
                        Envoyer le message
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
