<x-school::layouts.master :module="$module ?? \App\Support\Modules\ModuleRegistry::find('school')" page-title="Enseignants · ERP School">
    <style>
        .search-bar { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.5rem; }
        .search-bar input { background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.2); color:#e2e8f0; padding:.65rem 1rem; border-radius:.75rem; flex:1; min-width:180px; }
        .search-bar button { padding:.65rem 1.25rem; border-radius:.75rem; background:var(--module-accent); color:#fff; border:none; cursor:pointer; font-weight:600; }
        .back-link { color:#94a3b8; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; margin-bottom:1rem; }
        .back-link:hover { color:#e2e8f0; }
    </style>

    <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <a href="{{ route('school.erp') }}" class="back-link">← ERP</a>
        <h1 style="margin:0; font-size:1.5rem;">👨‍🏫 Enseignants</h1>
    </div>

    <section style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:1rem; margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">Total</div></article>
        <article class="stat"><strong>{{ $stats['active'] }}</strong><div class="muted">Actifs</div></article>
        <article class="stat"><strong>{{ $stats['inactive'] }}</strong><div class="muted">Inactifs</div></article>
    </section>

    <section class="panel table-wrapper">
        <form method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Nom, prénom ou spécialité..." value="{{ request('q') }}">
            <button type="submit">Filtrer</button>
        </form>

        <table>
            <thead>
                <tr><th>Enseignant</th><th>Spécialité</th><th>Qualification</th><th>Email</th><th>Téléphone</th><th>Statut</th></tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td><strong>{{ $teacher->full_name }}</strong></td>
                        <td>{{ $teacher->specialty }}</td>
                        <td class="muted">{{ $teacher->qualification }}</td>
                        <td class="muted">{{ $teacher->email }}</td>
                        <td class="muted">{{ $teacher->phone }}</td>
                        <td><span class="status {{ $teacher->status === 'active' ? '' : 'badge-status-inactive' }}">{{ ucfirst($teacher->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted" style="text-align:center;padding:2rem;">Aucun enseignant trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $teachers->links() }}</div>
    </section>

    <style>
        .badge-status-inactive { background:rgba(148,163,184,.15); color:#94a3b8; }
    </style>
</x-school::layouts.master>
