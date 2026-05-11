<x-payment::layouts.master :module="$module" :page-title="$module['label'].' · ERP'">
    <section class="hero">
        <span class="badge">🏢 ERP {{ $module['label'] }}</span>
        <h1 class="headline">Pilotage opérationnel, données métier et API unifiées.</h1>
        <p class="muted">Le backoffice expose CRUD, statistiques et surfaces d’intégration pour le module.</p>
    </section>
    <section class="stats-grid" style="margin-bottom:1.5rem;">
        <article class="stat"><strong>{{ $stats['total'] }}</strong><div class="muted">total</div></article>
        <article class="stat"><strong>{{ $stats['published'] }}</strong><div class="muted">visibles</div></article>
        <article class="stat"><strong>{{ $stats['draft'] }}</strong><div class="muted">draft</div></article>
    </section>
    <section class="panel table-wrapper">
        <div style="display:flex; justify-content:space-between; gap:1rem; align-items:center; flex-wrap:wrap; margin-bottom:1rem;">
            <div>
                <h2 style="margin:.2rem 0;">Table métier</h2>
                <p class="muted" style="margin:0;">Source alimentée par le repository et exposée via ressource API.</p>
            </div>
            <a class="cta" href="{{ $module['api_path'] }}">Consulter l’API</a>
        </div>
        <table>
            <thead>
                <tr><th>Nom</th><th>Audience</th><th>Statut</th><th>Publication</th></tr>
            </thead>
            <tbody>
                @foreach($records as $record)
                    <tr>
                        <td><strong>{{ $record->name }}</strong><div class="muted">{{ $record->headline }}</div></td>
                        <td>{{ $record->audience }}</td>
                        <td>{{ ucfirst($record->status) }}</td>
                        <td>{{ $record->is_public ? 'Public' : 'Privé' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $records->links() }}</div>
    </section>
</x-payment::layouts.master>
