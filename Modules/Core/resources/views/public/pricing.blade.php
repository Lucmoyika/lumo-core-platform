@extends('core::components.layouts.public')

@section('title', 'Tarification')

@section('content')
<section class="py-5" style="min-height:70vh;background:#0f172a;padding-top:5rem!important;">
    <div class="container">
        <h1 style="font-family:'Poppins',sans-serif;font-weight:800;color:white;text-align:center;margin-bottom:1rem;">Tarification</h1>
        <p style="color:#64748b;text-align:center;margin-bottom:3rem;">Des plans adaptés à toutes les tailles d'organisations.</p>
        
        <div class="row g-4 justify-content-center">
            @foreach([
                ['Starter','0','0','Pour commencer',['1 module','5 utilisateurs','Support communauté','Mises à jour gratuites'],false],
                ['Pro','49','49/mois','Pour les PME',['5 modules','50 utilisateurs','Support prioritaire','API accès complet','Analytics avancés'],true],
                ['Enterprise','devis','devis','Pour les grandes org.',['Modules illimités','Utilisateurs illimités','Support dédié 24/7','Déploiement on-premise','SLA garanti'],false],
            ] as $p)
            <div class="col-lg-4">
                <div style="background:{{ $p[5] ? 'rgba(99,102,241,0.1)' : 'rgba(255,255,255,0.03)' }};border:{{ $p[5] ? '2px solid #6366f1' : '1px solid rgba(255,255,255,0.07)' }};border-radius:1.25rem;padding:2rem;text-align:center;position:relative;">
                    @if($p[5])
                    <div style="position:absolute;top:-12px;left:50%;transform:translateX(-50%);background:#6366f1;color:white;font-size:0.75rem;font-weight:600;padding:0.2rem 1rem;border-radius:100px;">POPULAIRE</div>
                    @endif
                    <h3 style="color:white;font-weight:700;margin-bottom:0.5rem;">{{ $p[0] }}</h3>
                    <div style="font-size:2.5rem;font-weight:800;color:{{ $p[5] ? '#6366f1' : 'white' }};margin:1rem 0;font-family:'Poppins',sans-serif;">
                        @if($p[2] === '0') Gratuit
                        @elseif($p[2] === 'devis') Sur devis
                        @else ${{ $p[1] }}<small style="font-size:1rem;color:#94a3b8;">/mois</small>
                        @endif
                    </div>
                    <p style="color:#64748b;font-size:0.875rem;margin-bottom:1.5rem;">{{ $p[3] }}</p>
                    <ul class="list-unstyled mb-2" style="text-align:left;">
                        @foreach($p[4] as $feature)
                        <li style="color:#94a3b8;font-size:0.875rem;padding:0.4rem 0;border-bottom:1px solid rgba(255,255,255,0.05);">
                            <i class="bi bi-check-circle-fill me-2" style="color:#22c55e;"></i>{{ $feature }}
                        </li>
                        @endforeach
                    </ul>
                    <a href="{{ route('identity.register') }}" class="btn w-100 mt-3" style="background:{{ $p[5] ? '#6366f1' : 'rgba(255,255,255,0.05)' }};color:white;border-radius:0.75rem;padding:0.75rem;font-weight:600;border:none;">
                        {{ $p[2] === 'devis' ? 'Nous contacter' : 'Commencer' }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
