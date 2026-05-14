<x-school::layouts.master :module="$module" page-title="Fees · School ERP">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;">
        <h1 style="margin:0;">💰 Gestion des frais</h1>
        <form method="POST" action="{{ route('school.erp.fees.generate-invoices') }}">@csrf<button class="cta" type="submit">Générer factures</button></form>
    </div>

    @if(session('status'))<p class="badge" style="margin:1rem 0;">{{ session('status') }}</p>@endif

    <section class="stats-grid" style="margin:1rem 0;">
        <article class="stat"><strong>{{ number_format($totals['invoiced'],0,',',' ') }}</strong><div class="muted">Facturé</div></article>
        <article class="stat"><strong>{{ number_format($totals['paid'],0,',',' ') }}</strong><div class="muted">Payé</div></article>
        <article class="stat"><strong>{{ number_format($totals['balance'],0,',',' ') }}</strong><div class="muted">Reste à payer</div></article>
    </section>

    <section class="panel table-wrapper" style="margin-bottom:1rem;">
        <table>
            <thead><tr><th>Facture</th><th>Élève</th><th>Montant</th><th>Payé</th><th>Reste</th><th>Échéance</th><th>Statut</th></tr></thead>
            <tbody>
                @foreach($invoices as $invoice)
                    <tr>
                        <td><code>{{ $invoice->invoice_number }}</code></td>
                        <td>{{ $invoice->enrollment?->student?->full_name }}</td>
                        <td>{{ number_format($invoice->amount,0,',',' ') }} {{ $invoice->currency }}</td>
                        <td>{{ number_format($invoice->paid_amount,0,',',' ') }} {{ $invoice->currency }}</td>
                        <td style="color:{{ $invoice->balance > 0 ? '#fca5a5' : '#86efac' }};">{{ number_format($invoice->balance,0,',',' ') }} {{ $invoice->currency }}</td>
                        <td>{{ $invoice->due_date?->format('d/m/Y') }}</td>
                        <td>{{ ucfirst($invoice->status) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div style="margin-top:1rem;">{{ $invoices->links() }}</div>
    </section>

    <section class="panel table-wrapper">
        <h3 style="margin-top:0;color:#fca5a5;">Alertes impayés</h3>
        <table>
            <thead><tr><th>Facture</th><th>Élève</th><th>Échéance</th><th>Solde</th></tr></thead>
            <tbody>
                @forelse($alerts as $invoice)
                    <tr>
                        <td>{{ $invoice->invoice_number }}</td>
                        <td>{{ $invoice->enrollment?->student?->full_name }}</td>
                        <td>{{ $invoice->due_date?->format('d/m/Y') }}</td>
                        <td>{{ number_format($invoice->balance,0,',',' ') }} {{ $invoice->currency }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">Aucune alerte.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</x-school::layouts.master>
