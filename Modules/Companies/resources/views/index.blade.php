<x-companies::layouts.master :module="$module" :page-title="$module['label'].' · Site public'">
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
    <section class="stats-grid" style="margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">enregistrements</div></article>
        <article class="stat"><strong>{{ $stats['published'] }}</strong><div class="muted">publiés</div></article>
        <article class="stat"><strong>{{ $stats['draft'] }}</strong><div class="muted">brouillons</div></article>
    </section>
    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Catalogue public</h2>
        <div class="card-grid">
            @foreach($records as $record)
                <article class="card">
                    <span class="status">{{ ucfirst($record->status) }}</span>
                    <h3>{{ $record->name }}</h3>
                    <p class="muted">{{ $record->headline }}</p>
                    <p>{{ $record->description }}</p>
                </article>
            @endforeach
        </div>
    </section>
    <section class="panel">
        <h2 style="margin-top:0;">Micro-interactions</h2>
        <div data-insights-component="companies-insights" data-props='@json(["accent" => $module["accent"], "title" => $module["label"], "features" => $module["features"]])'></div>
    </section>
</x-companies::layouts.master>
