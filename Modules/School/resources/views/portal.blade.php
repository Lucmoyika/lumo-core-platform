<x-school::layouts.master :module="$module" :page-title="$module['label'].' · Portail'">

    {{-- ===== HERO PORTAIL ===== --}}
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="badge">🔐 Portail {{ $module['label'] }}</span>
                <h1 class="headline">Votre espace personnel sécurisé</h1>
                <p class="muted">
                    Bienvenue, <strong style="color:#fff;">{{ $user?->name ?? 'Utilisateur' }}</strong>.
                    Les accès sont gouvernés par les rôles et policies de sécurité Spatie.
                </p>
            </div>
            <div class="panel">
                <h2 style="margin-top:0;">Accès par rôle</h2>
                <div class="roles-grid">
                    @foreach($module['roles'] as $role)
                        <article class="role-card">
                            <span class="badge">
                                @switch($role)
                                    @case('super-admin') 🛡️ @break
                                    @case('admin') 👔 @break
                                    @case('manager') 📋 @break
                                    @case('teacher') 🧑‍🏫 @break
                                    @default 👤
                                @endswitch
                            </span>
                            <h3>{{ ucfirst(str_replace('-', ' ', $role)) }}</h3>
                            <p class="muted" style="font-size:.85rem;">
                                @switch($role)
                                    @case('super-admin') Administration globale de la plateforme scolaire. @break
                                    @case('admin') Gestion des inscriptions, programmes et personnel. @break
                                    @case('manager') Supervision des classes, absences et finances. @break
                                    @case('teacher') Saisie des notes, cours et suivi pédagogique. @break
                                    @default Accès à l'espace dédié à ce rôle.
                                @endswitch
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- ===== ACTIONS RAPIDES ===== --}}
    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Actions rapides</h2>
        <div class="card-grid">
            <article class="card">
                <span style="font-size:1.5rem;">📋</span>
                <strong>Gérer les admissions</strong>
                <p class="muted" style="font-size:.88rem;">Consultez et traitez les dossiers d'inscription en attente.</p>
                <a class="badge" href="{{ route($module['route_prefix'].'.erp') }}" style="margin-top:.75rem; display:inline-flex;">Ouvrir l'ERP →</a>
            </article>
            <article class="card">
                <span style="font-size:1.5rem;">🧑‍🏫</span>
                <strong>Mes classes</strong>
                <p class="muted" style="font-size:.88rem;">Accédez aux cahiers de texte, emplois du temps et listes d'élèves.</p>
                <span class="badge" style="margin-top:.75rem; display:inline-flex; opacity:.6;">Bientôt disponible</span>
            </article>
            <article class="card">
                <span style="font-size:1.5rem;">📊</span>
                <strong>Bulletins scolaires</strong>
                <p class="muted" style="font-size:.88rem;">Saisie des notes, consultation et génération des bulletins PDF.</p>
                <span class="badge" style="margin-top:.75rem; display:inline-flex; opacity:.6;">Bientôt disponible</span>
            </article>
            <article class="card">
                <span style="font-size:1.5rem;">💳</span>
                <strong>Frais scolaires</strong>
                <p class="muted" style="font-size:.88rem;">Suivi des paiements, reçus et échéanciers par élève.</p>
                <span class="badge" style="margin-top:.75rem; display:inline-flex; opacity:.6;">Bientôt disponible</span>
            </article>
        </div>
    </section>

    {{-- ===== PROGRAMMES RÉCENTS ===== --}}
    <section class="panel">
        <h2 style="margin-top:0;">Programmes académiques — accès rapide</h2>
        @if($records->isEmpty())
            <p class="muted">Aucun programme disponible pour le moment.</p>
        @else
            <div class="card-grid">
                @foreach($records as $record)
                    <article class="card">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:.5rem;">
                            <h3 style="margin:0;">{{ $record->name }}</h3>
                            <span class="status">{{ ucfirst($record->status) }}</span>
                        </div>
                        <p class="muted" style="margin:.25rem 0 .5rem; font-size:.88rem;">{{ $record->headline }}</p>
                        @if($record->metrics)
                            <div style="display:flex; gap:.75rem; font-size:.82rem; color:#94a3b8; margin-top:.5rem;">
                                @isset($record->metrics['satisfaction'])
                                    <span>⭐ {{ $record->metrics['satisfaction'] }}% satisfaction</span>
                                @endisset
                                @isset($record->metrics['coverage'])
                                    <span>📈 {{ $record->metrics['coverage'] }}% couverture</span>
                                @endisset
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </section>

</x-school::layouts.master>
