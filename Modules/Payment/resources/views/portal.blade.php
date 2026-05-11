<x-payment::layouts.master :module="$module" :page-title="$module['label'].' · Portail'">
    <section class="hero">
        <span class="badge">🔐 Portail {{ $module['label'] }}</span>
        <h1 class="headline">Un espace authentifié multi-rôles pour {{ strtolower($module['label']) }}.</h1>
        <p class="muted">Utilisateur connecté : {{ $user?->name ?? 'invité' }} · Les accès sont gouvernés par policies et rôles Spatie.</p>
    </section>
    <section class="roles-grid" style="margin-bottom:1.5rem;">
        @foreach($module['roles'] as $role)
            <article class="role-card">
                <span class="badge">Rôle</span>
                <h3>{{ ucfirst(str_replace('-', ' ', $role)) }}</h3>
                <p class="muted">Redirection et expérience contextualisée pour ce rôle dans le portail {{ $module['label'] }}.</p>
            </article>
        @endforeach
    </section>
    <section class="panel">
        <h2 style="margin-top:0;">Accès rapides</h2>
        <div class="card-grid">
            @foreach($records as $record)
                <article class="card">
                    <h3>{{ $record->name }}</h3>
                    <p class="muted">{{ $record->headline }}</p>
                    <p>{{ $record->description }}</p>
                </article>
            @endforeach
        </div>
    </section>
</x-payment::layouts.master>
