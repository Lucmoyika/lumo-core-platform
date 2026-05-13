<x-school::layouts.master :module="$module" :page-title="$module['label'].' · ERP'">
    <section class="hero">
        <span class="badge">🏢 ERP {{ $module['label'] }}</span>
        <h1 class="headline">Pilotage opérationnel — Smart School ERP</h1>
        <p class="muted">Backoffice complet : programmes, classes, élèves, enseignants, notes et présences.</p>
    </section>

    <section style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:1rem; margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">Programmes</div></article>
        <article class="stat"><strong>{{ $stats['published'] }}</strong><div class="muted">Actifs</div></article>
        <article class="stat"><strong>{{ $stats['draft'] }}</strong><div class="muted">Brouillons</div></article>
        <article class="stat"><strong>{{ $globalStats['students'] }}</strong><div class="muted">Élèves</div></article>
        <article class="stat"><strong>{{ $globalStats['teachers'] }}</strong><div class="muted">Enseignants</div></article>
        <article class="stat"><strong>{{ $globalStats['classes'] }}</strong><div class="muted">Classes</div></article>
        <article class="stat"><strong>{{ $globalStats['enrollments'] }}</strong><div class="muted">Inscriptions</div></article>
        <article class="stat"><strong>{{ $globalStats['grades'] }}</strong><div class="muted">Notes</div></article>
    </section>

    <section class="panel" style="margin-bottom:1.5rem;">
        <h2 style="margin-top:0;">Modules ERP</h2>
        <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:1rem;">
            <a href="{{ route('school.erp.students') }}" class="erp-card">
                <span style="font-size:2rem;">👩‍🎓</span>
                <strong>Élèves</strong>
                <span class="muted">{{ $globalStats['students'] }} inscrits</span>
            </a>
            <a href="{{ route('school.erp.teachers') }}" class="erp-card">
                <span style="font-size:2rem;">👨‍🏫</span>
                <strong>Enseignants</strong>
                <span class="muted">{{ $globalStats['teachers'] }} actifs</span>
            </a>
            <a href="{{ route('school.erp.classes') }}" class="erp-card">
                <span style="font-size:2rem;">🏫</span>
                <strong>Classes</strong>
                <span class="muted">{{ $globalStats['classes'] }} classes</span>
            </a>
            <a href="{{ $module['api_path'] }}" class="erp-card">
                <span style="font-size:2rem;">🔌</span>
                <strong>API</strong>
                <span class="muted">Endpoints REST</span>
            </a>
        </div>
    </section>

    <section class="panel table-wrapper">
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; margin-bottom:1rem;">
            <h2 style="margin:0;">Programmes académiques</h2>
            <a class="cta" href="{{ $module['api_path'] }}">Voir l'API</a>
        </div>
        <table>
            <thead>
                <tr><th>Nom</th><th>Public cible</th><th>Statut</th><th>Publication</th><th>Classes</th></tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td><strong>{{ $record->name }}</strong><div class="muted">{{ $record->headline }}</div></td>
                        <td class="muted">{{ $record->audience }}</td>
                        <td><span class="status">{{ ucfirst($record->status) }}</span></td>
                        <td>{{ $record->is_public ? 'Public' : 'Privé' }}</td>
                        <td>{{ $record->classes->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $records->links() }}</div>
    </section>

    <style>
        .erp-card { display:flex; flex-direction:column; gap:.4rem; padding:1.25rem; background:rgba(15,23,42,.7); border:1px solid rgba(148,163,184,.16); border-radius:1.2rem; text-decoration:none; color:#e2e8f0; transition:border-color .2s; }
        .erp-card:hover { border-color: var(--module-accent); }
    </style>
</x-school::layouts.master>
