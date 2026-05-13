<x-school::layouts.master :module="$module ?? \App\Support\Modules\ModuleRegistry::find('school')" page-title="Classes · ERP School">
    <style>
        .back-link { color:#94a3b8; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; margin-bottom:1rem; }
        .back-link:hover { color:#e2e8f0; }
        .progress-bar { height:.5rem; border-radius:999px; background:rgba(148,163,184,.15); overflow:hidden; margin-top:.4rem; }
        .progress-fill { height:100%; background:var(--module-accent); border-radius:999px; }
    </style>

    <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap; margin-bottom:1.5rem;">
        <a href="{{ route('school.erp') }}" class="back-link">← ERP</a>
        <h1 style="margin:0; font-size:1.5rem;">🏫 Classes</h1>
    </div>

    <section style="display:grid; grid-template-columns:repeat(auto-fit,minmax(160px,1fr)); gap:1rem; margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">Classes</div></article>
        <article class="stat"><strong>{{ $stats['active'] }}</strong><div class="muted">Actives</div></article>
        <article class="stat"><strong>{{ $stats['capacity'] }}</strong><div class="muted">Capacité totale</div></article>
    </section>

    <section class="panel table-wrapper">
        <table>
            <thead>
                <tr><th>Classe</th><th>Programme</th><th>Salle</th><th>Année</th><th>Capacité</th><th>Inscrits</th><th>Enseignants</th><th>Statut</th></tr>
            </thead>
            <tbody>
                @forelse($classes as $class)
                    @php $enrolled = $class->enrollments->count(); $pct = $class->capacity > 0 ? round($enrolled / $class->capacity * 100) : 0; @endphp
                    <tr>
                        <td><strong>{{ $class->name }}</strong> @if($class->section)<span class="muted">— {{ $class->section }}</span>@endif</td>
                        <td class="muted">{{ $class->academicProgram->name ?? '—' }}</td>
                        <td class="muted">{{ $class->room }}</td>
                        <td class="muted">{{ $class->school_year }}</td>
                        <td>{{ $class->capacity }}</td>
                        <td>
                            {{ $enrolled }}
                            <div class="progress-bar"><div class="progress-fill" style="width:{{ $pct }}%"></div></div>
                        </td>
                        <td>{{ $class->teachers->count() }}</td>
                        <td><span class="status">{{ ucfirst($class->status) }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="muted" style="text-align:center;padding:2rem;">Aucune classe trouvée.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $classes->links() }}</div>
    </section>
</x-school::layouts.master>
