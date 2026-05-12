<x-school::layouts.master :module="$module" :page-title="$module['label'].' · Site public'">

    {{-- ===== HERO ===== --}}
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="badge">{{ $module['icon'] }} {{ $module['label'] }}</span>
                <h1 class="headline">{{ $module['summary'] }}</h1>
                <p class="muted">
                    Destiné aux {{ strtolower($module['audience']) }}.
                    Combinez un site vitrine moderne, un portail sécurisé multi-rôles, un ERP de gestion scolaire et une API REST complète.
                </p>
                <div style="display:flex; gap:.75rem; flex-wrap:wrap; margin-top:1.5rem;">
                    <a class="cta" href="{{ route($module['route_prefix'].'.admission') }}">📋 Déposer une demande d'admission</a>
                    <a class="badge" href="{{ route($module['route_prefix'].'.portal') }}">🔐 Espace connecté</a>
                    <a class="badge" href="{{ $module['api_path'] }}">⚡ API</a>
                </div>
            </div>
            <div class="panel">
                <h2 style="margin-top:0;">Fonctionnalités clés</h2>
                <div class="card-grid">
                    <article class="card">
                        <span style="font-size:1.6rem;">📋</span>
                        <strong>Admissions en ligne</strong>
                        <p class="muted">Formulaire de pré-inscription, suivi de dossier et notifications automatiques par email.</p>
                    </article>
                    <article class="card">
                        <span style="font-size:1.6rem;">🏫</span>
                        <strong>Structure académique</strong>
                        <p class="muted">Gestion des niveaux (maternelle, primaire, secondaire), classes, filières et programmes.</p>
                    </article>
                    <article class="card">
                        <span style="font-size:1.6rem;">📊</span>
                        <strong>Bulletins &amp; Finances</strong>
                        <p class="muted">Saisie des notes, génération de bulletins PDF, suivi des frais scolaires et paiements.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATISTIQUES ===== --}}
    <section class="stats-grid" style="margin-bottom:1.5rem;">
        <article class="stat">
            <strong>{{ $stats['total'] }}</strong>
            <div class="muted">Programmes actifs</div>
        </article>
        <article class="stat">
            <strong>{{ $stats['published'] }}</strong>
            <div class="muted">Ouverts aux inscriptions</div>
        </article>
        <article class="stat">
            <strong>{{ $stats['draft'] }}</strong>
            <div class="muted">En préparation</div>
        </article>
        <article class="stat">
            <strong>3</strong>
            <div class="muted">Cycles (Maternelle · Primaire · Secondaire)</div>
        </article>
    </section>

    {{-- ===== PROGRAMMES ACADÉMIQUES ===== --}}
    <section class="panel" style="margin-bottom:1.5rem;">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1rem;">
            <h2 style="margin:0;">Nos programmes académiques</h2>
            <a class="cta" style="font-size:.9rem; padding:.65rem 1rem;" href="{{ route($module['route_prefix'].'.admission') }}">S'inscrire →</a>
        </div>
        @if($records->isEmpty())
            <p class="muted" style="text-align:center; padding:2rem 0;">Aucun programme publié pour le moment. Revenez bientôt.</p>
        @else
            <div class="card-grid">
                @foreach($records as $record)
                    <article class="card">
                        <div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:.5rem;">
                            <span class="status">{{ ucfirst($record->status === 'active' ? 'Ouvert' : $record->status) }}</span>
                        </div>
                        <h3>{{ $record->name }}</h3>
                        <p class="muted" style="margin:.25rem 0 .5rem;">{{ $record->headline }}</p>
                        <p style="font-size:.9rem; color:#cbd5e1;">{{ Str::limit($record->description, 120) }}</p>
                        @if($record->capabilities)
                            <div style="display:flex; flex-wrap:wrap; gap:.4rem; margin-top:.75rem;">
                                @foreach(array_slice((array) $record->capabilities, 0, 3) as $cap)
                                    <span style="font-size:.78rem; padding:.3rem .6rem; border-radius:999px; background:rgba(99,102,241,.18); color:#a5b4fc;">{{ $cap }}</span>
                                @endforeach
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    </section>

    {{-- ===== PROCESSUS D'ADMISSION ===== --}}
    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Comment s'inscrire ?</h2>
        <div class="card-grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));">
            <article class="card" style="text-align:center;">
                <div style="font-size:2rem; margin-bottom:.5rem;">1️⃣</div>
                <strong>Déposer le dossier</strong>
                <p class="muted" style="font-size:.88rem;">Remplissez le formulaire d'admission en ligne avec les pièces requises.</p>
            </article>
            <article class="card" style="text-align:center;">
                <div style="font-size:2rem; margin-bottom:.5rem;">2️⃣</div>
                <strong>Évaluation</strong>
                <p class="muted" style="font-size:.88rem;">Notre équipe pédagogique examine le dossier et vous contacte sous 48 h.</p>
            </article>
            <article class="card" style="text-align:center;">
                <div style="font-size:2rem; margin-bottom:.5rem;">3️⃣</div>
                <strong>Confirmation &amp; paiement</strong>
                <p class="muted" style="font-size:.88rem;">Validez l'inscription et réglez les frais scolaires via notre portail de paiement sécurisé.</p>
            </article>
            <article class="card" style="text-align:center;">
                <div style="font-size:2rem; margin-bottom:.5rem;">4️⃣</div>
                <strong>Bienvenue !</strong>
                <p class="muted" style="font-size:.88rem;">Accédez à votre espace élève/parent et rejoignez votre classe dès la rentrée.</p>
            </article>
        </div>
        <div style="text-align:center; margin-top:1.5rem;">
            <a class="cta" href="{{ route($module['route_prefix'].'.admission') }}">Commencer ma demande d'admission</a>
        </div>
    </section>

    {{-- ===== MICRO-INTERACTIONS (Vue 3) ===== --}}
    <section class="panel">
        <h2 style="margin-top:0;">Tableau de bord interactif</h2>
        <div data-insights-component="school-insights"
             data-props='@json(["accent" => $module["accent"], "title" => $module["label"], "features" => $module["features"]])'></div>
    </section>

</x-school::layouts.master>
