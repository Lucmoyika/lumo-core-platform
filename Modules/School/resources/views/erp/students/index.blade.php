<x-school::layouts.master :module="$module ?? \App\Support\Modules\ModuleRegistry::find('school')" page-title="Élèves · ERP School">
    <style>
        .search-bar { display:flex; gap:.75rem; flex-wrap:wrap; margin-bottom:1.5rem; }
        .search-bar input, .search-bar select { background:rgba(15,23,42,.8); border:1px solid rgba(148,163,184,.2); color:#e2e8f0; padding:.65rem 1rem; border-radius:.75rem; flex:1; min-width:180px; }
        .search-bar button { padding:.65rem 1.25rem; border-radius:.75rem; background:var(--module-accent); color:#fff; border:none; cursor:pointer; font-weight:600; }
        .badge-status-active { background:rgba(34,197,94,.15); color:#86efac; }
        .badge-status-suspended { background:rgba(239,68,68,.15); color:#fca5a5; }
        .badge-status-transferred { background:rgba(234,179,8,.15); color:#fde047; }
        .back-link { color:#94a3b8; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; margin-bottom:1rem; }
        .back-link:hover { color:#e2e8f0; }
    </style>

    <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <a href="{{ route('school.erp') }}" class="back-link">← ERP</a>
        <h1 style="margin:0; font-size:1.5rem;">👩‍🎓 Élèves</h1>
    </div>

    <section style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:1rem; margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">Total</div></article>
        <article class="stat"><strong>{{ $stats['active'] }}</strong><div class="muted">Actifs</div></article>
        <article class="stat"><strong>{{ $stats['suspended'] }}</strong><div class="muted">Suspendus</div></article>
    </section>

    <section class="panel table-wrapper">
        <form method="GET" class="search-bar">
            <input type="text" name="q" placeholder="Nom, prénom ou numéro..." value="{{ request('q') }}">
            <select name="status">
                <option value="">Tous les statuts</option>
                <option value="active" @selected(request('status')=='active')>Actifs</option>
                <option value="suspended" @selected(request('status')=='suspended')>Suspendus</option>
                <option value="transferred" @selected(request('status')=='transferred')>Transférés</option>
            </select>
            <button type="submit">Filtrer</button>
        </form>

        <table>
            <thead>
                <tr><th>N°</th><th>Élève</th><th>Genre</th><th>Naissance</th><th>Parent</th><th>Statut</th><th>Actions</th></tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td><code>{{ $student->student_number }}</code></td>
                        <td><strong>{{ $student->full_name }}</strong></td>
                        <td>{{ $student->gender === 'male' ? 'M' : 'F' }}</td>
                        <td class="muted">{{ $student->birth_date->format('d/m/Y') }}</td>
                        <td class="muted">{{ $student->parent_name }}</td>
                        <td><span class="status badge-status-{{ $student->status }}">{{ ucfirst($student->status) }}</span></td>
                        <td><a href="{{ route('school.erp.students.show', $student->id) }}" class="badge">Voir</a></td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="muted" style="text-align:center;padding:2rem;">Aucun élève trouvé.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $students->links() }}</div>
    </section>
</x-school::layouts.master>
