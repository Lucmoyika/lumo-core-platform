<x-school::layouts.master :module="$module" :page-title="$module['label'].' · Site public'">
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="badge">{{ $module['icon'] }} {{ $module['label'] }}</span>
                <h1 class="headline">{{ $module['summary'] }}</h1>
                <p class="muted">Public cible : {{ $module['audience'] }}. Chaque espace combine site vitrine, portail sécurisé, ERP et API-first.</p>
                <div style="display:flex; gap:.75rem; flex-wrap:wrap; margin-top:1.25rem;">
                    <a class="cta" href="{{ route($module['route_prefix'].'.portal') }}">Accéder au portail</a>
                    <a class="badge" href="{{ $module['api_path'] }}">Documentation API rapide</a>
                </div>
            </div>
            <div class="panel">
                <h2 style="margin-top:0;">Points forts</h2>
                <div class="card-grid">
                    @foreach($module['features'] as $feature)
                        <article class="card">
                            <strong>{{ $feature }}</strong>
                            <p class="muted">Implémenté avec couches service, repository, policy, validation et ressource API.</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <section class="panel" style="margin-bottom:1.5rem;">
        <form method="GET" class="filters-grid">
            <input type="text" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Rechercher un programme...">
            <select name="status">
                <option value="">Tous statuts</option>
                @foreach(['active' => 'Actif', 'draft' => 'Brouillon', 'archived' => 'Archivé'] as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="level">
                <option value="">Tous niveaux</option>
                @foreach(['maternelle' => 'Maternelle', 'primaire' => 'Primaire', 'secondaire' => 'Secondaire', 'professionnel' => 'Professionnel'] as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['level'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <select name="admission_open">
                <option value="">Admissions (toutes)</option>
                <option value="1" @selected(($filters['admission_open'] ?? '') === '1')>Admissions ouvertes</option>
                <option value="0" @selected(($filters['admission_open'] ?? '') === '0')>Admissions fermées</option>
            </select>
            <button type="submit" class="cta">Filtrer</button>
        </form>
    </section>
    <section class="stats-grid" style="margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">enregistrements</div></article>
        <article class="stat"><strong>{{ $stats['published'] }}</strong><div class="muted">publiés</div></article>
        <article class="stat"><strong>{{ $stats['draft'] }}</strong><div class="muted">brouillons</div></article>
        <article class="stat"><strong>{{ $stats['admission_open'] ?? 0 }}</strong><div class="muted">admissions ouvertes</div></article>
    </section>
    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Catalogue public</h2>
        <div class="card-grid">
            @forelse($records as $record)
                <article class="card">
                    <span class="status">{{ ucfirst($record->status) }}</span>
                    <h3>{{ $record->name }}</h3>
                    <p class="muted">{{ $record->headline }}</p>
                    <p><strong>Niveau:</strong> {{ ucfirst($record->level) }} · <strong>Durée:</strong> {{ $record->duration_months }} mois</p>
                    <p><strong>Frais annuels:</strong> {{ number_format((float) $record->annual_fee, 2, ',', ' ') }} $ · <strong>Admissions:</strong> {{ $record->admission_open ? 'Ouvertes' : 'Fermées' }}</p>
                    <p>{{ $record->description }}</p>
                </article>
            @empty
                <article class="card">
                    <h3>Aucun programme trouvé</h3>
                    <p class="muted">Ajustez les filtres pour afficher des résultats.</p>
                </article>
            @endforelse
        </div>
    </section>
    <section class="panel">
        <h2 style="margin-top:0;">Micro-interactions</h2>
        <div data-insights-component="school-insights" data-props='@json(["accent" => $module["accent"], "title" => $module["label"], "features" => $module["features"]])'></div>
    </section>
</x-school::layouts.master>
