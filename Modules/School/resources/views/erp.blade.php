<x-school::layouts.master :module="$module" :page-title="$module['label'].' · ERP'">

    {{-- ===== HERO ERP ===== --}}
    <section class="hero">
        <div class="hero-grid">
            <div>
                <span class="badge">🏢 ERP {{ $module['label'] }}</span>
                <h1 class="headline">Pilotage scolaire unifié</h1>
                <p class="muted">
                    Gérez vos programmes académiques, inscriptions, enseignants et finances depuis un seul backoffice.
                    Les données sont exposées via une API REST versionnée.
                </p>
                <div style="display:flex; gap:.75rem; flex-wrap:wrap; margin-top:1.25rem;">
                    <a class="cta" href="{{ $module['api_path'] }}">⚡ Consulter l'API</a>
                    <a class="badge" href="{{ route($module['route_prefix'].'.admission') }}">📋 Voir les admissions</a>
                </div>
            </div>
            <div class="panel">
                <h2 style="margin-top:0;">Modules ERP actifs</h2>
                <div class="card-grid" style="grid-template-columns:1fr 1fr;">
                    <article class="card">
                        <span style="font-size:1.25rem;">📋</span>
                        <strong>Admissions</strong>
                        <p class="muted" style="font-size:.82rem;">Traitement des dossiers</p>
                    </article>
                    <article class="card">
                        <span style="font-size:1.25rem;">🏫</span>
                        <strong>Programmes</strong>
                        <p class="muted" style="font-size:.82rem;">Structure académique</p>
                    </article>
                    <article class="card">
                        <span style="font-size:1.25rem;">📊</span>
                        <strong>Évaluations</strong>
                        <p class="muted" style="font-size:.82rem;">Notes &amp; bulletins</p>
                    </article>
                    <article class="card">
                        <span style="font-size:1.25rem;">💳</span>
                        <strong>Finances</strong>
                        <p class="muted" style="font-size:.82rem;">Frais &amp; paiements</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== STATISTIQUES ERP ===== --}}
    <section class="stats-grid" style="margin-bottom:1.5rem;">
        <article class="stat">
            <strong>{{ $stats['total'] }}</strong>
            <div class="muted">Programmes au total</div>
        </article>
        <article class="stat">
            <strong>{{ $stats['published'] }}</strong>
            <div class="muted">Ouverts aux inscriptions</div>
        </article>
        <article class="stat">
            <strong>{{ $stats['draft'] }}</strong>
            <div class="muted">En cours de préparation</div>
        </article>
        <article class="stat">
            <strong>{{ max(0, $stats['total'] - $stats['draft'] - $stats['published']) }}</strong>
            <div class="muted">Archivés / inactifs</div>
        </article>
    </section>

    {{-- ===== TABLE PROGRAMMES ===== --}}
    <section class="panel table-wrapper" style="margin-bottom:1.5rem;">
        <div style="display:flex; justify-content:space-between; gap:1rem; align-items:center; flex-wrap:wrap; margin-bottom:1.25rem;">
            <div>
                <h2 style="margin:.2rem 0;">Gestion des programmes académiques</h2>
                <p class="muted" style="margin:0; font-size:.88rem;">Source alimentée par le repository — exposée via l'API <code style="color:#a5b4fc;">/api/v1/schools</code></p>
            </div>
            <a class="cta" style="font-size:.88rem; padding:.65rem 1rem;" href="{{ $module['api_path'] }}">Consulter l'API →</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Programme</th>
                    <th>Public cible</th>
                    <th>Statut</th>
                    <th>Visibilité</th>
                    <th>Capacités</th>
                    <th>Mis à jour</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        <td class="muted" style="font-size:.82rem;">{{ $record->id }}</td>
                        <td>
                            <strong>{{ $record->name }}</strong>
                            <div class="muted" style="font-size:.82rem;">{{ $record->headline }}</div>
                        </td>
                        <td class="muted" style="font-size:.85rem;">{{ $record->audience }}</td>
                        <td>
                            <span class="status" @style([
                                'background:rgba(34,197,94,.15); color:#86efac;'  => $record->status === 'active',
                                'background:rgba(245,158,11,.15); color:#fcd34d;' => $record->status === 'draft',
                                'background:rgba(148,163,184,.15); color:#94a3b8;' => !in_array($record->status, ['active','draft']),
                            ])>{{ ucfirst($record->status) }}</span>
                        </td>
                        <td>
                            @if($record->is_public)
                                <span style="color:#86efac; font-size:.85rem;">🌐 Public</span>
                            @else
                                <span style="color:#94a3b8; font-size:.85rem;">�� Privé</span>
                            @endif
                        </td>
                        <td class="muted" style="font-size:.82rem;">
                            @if($record->capabilities)
                                {{ implode(', ', array_slice((array) $record->capabilities, 0, 2)) }}
                            @else
                                —
                            @endif
                        </td>
                        <td class="muted" style="font-size:.82rem;">
                            {{ $record->updated_at?->diffForHumans() ?? '—' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:2rem; color:#64748b;">Aucun programme enregistré.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $records->links() }}</div>
    </section>

    {{-- ===== FLUX MÉTIER ===== --}}
    <section class="panel">
        <h2 style="margin-top:0;">Flux opérationnels</h2>
        <div class="card-grid">
            <article class="card">
                <span style="font-size:1.4rem; margin-bottom:.5rem; display:block;">📥</span>
                <strong>Réception dossiers</strong>
                <p class="muted" style="font-size:.85rem;">Les demandes arrivent via le formulaire public et alimentent la file d'attente ERP.</p>
            </article>
            <article class="card">
                <span style="font-size:1.4rem; margin-bottom:.5rem; display:block;">✅</span>
                <strong>Validation &amp; affectation</strong>
                <p class="muted" style="font-size:.85rem;">L'admin valide, affecte la classe et déclenche les notifications d'acceptation.</p>
            </article>
            <article class="card">
                <span style="font-size:1.4rem; margin-bottom:.5rem; display:block;">📤</span>
                <strong>Exposition API</strong>
                <p class="muted" style="font-size:.85rem;">Tous les programmes sont accessibles via <code style="color:#a5b4fc;">GET /api/v1/schools</code> avec pagination et filtres.</p>
            </article>
        </div>
    </section>

</x-school::layouts.master>
