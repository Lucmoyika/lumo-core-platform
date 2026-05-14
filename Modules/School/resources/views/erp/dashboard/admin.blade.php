<x-school::layouts.master :module="$module" page-title="Admin Dashboard · School ERP">
    <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.8rem;margin-bottom:1rem;">
        <h1 style="margin:0;">📈 Admin Dashboard</h1>
        <a class="badge" href="{{ route('school.erp') }}">← ERP</a>
    </div>

    <section class="stats-grid" style="margin-bottom:1rem;">
        <article class="stat"><strong>{{ $totals['students'] }}</strong><div class="muted">Élèves</div></article>
        <article class="stat"><strong>{{ $totals['teachers'] }}</strong><div class="muted">Enseignants</div></article>
        <article class="stat"><strong>{{ $totals['classes'] }}</strong><div class="muted">Classes</div></article>
        <article class="stat"><strong>{{ number_format($totals['revenue'], 0, ',', ' ') }}</strong><div class="muted">Revenus (CDF)</div></article>
        <article class="stat"><strong>{{ $totals['attendance_rate'] }}%</strong><div class="muted">Taux présence</div></article>
    </section>

    <section class="panel" style="margin-bottom:1rem;">
        <h3 style="margin-top:0;">Workflow connecté</h3>
        <div class="card-grid">
            <article class="card">Admissions: <strong>{{ $workflow['admissions'] }}</strong></article>
            <article class="card">Inscriptions: <strong>{{ $workflow['enrollments'] }}</strong></article>
            <article class="card">Présences: <strong>{{ $workflow['attendances'] }}</strong></article>
            <article class="card">Examens: <strong>{{ $workflow['exams'] }}</strong></article>
            <article class="card">Notes: <strong>{{ $workflow['marks'] }}</strong></article>
            <article class="card">Bulletins: <strong>{{ $workflow['report_cards'] }}</strong></article>
            <article class="card">Paiements: <strong>{{ $workflow['payments'] }}</strong></article>
        </div>
    </section>

    <section class="panel" style="margin-bottom:1rem;">
        <h3 style="margin-top:0;">Graphiques revenus</h3>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
                <h4>Mensuel</h4>
                @foreach($charts['monthly_revenue'] as $row)
                    <div style="display:flex;justify-content:space-between;border-bottom:1px solid rgba(148,163,184,.14);padding:.4rem 0;">
                        <span class="muted">{{ $row->month }}</span>
                        <strong>{{ number_format((float)$row->amount, 0, ',', ' ') }}</strong>
                    </div>
                @endforeach
            </div>
            <div>
                <h4>Par classe</h4>
                @foreach($charts['revenue_by_class'] as $row)
                    <div style="margin-bottom:.55rem;">
                        <div style="display:flex;justify-content:space-between;"><span>{{ $row->class_name }}</span><strong>{{ number_format((float)$row->revenue, 0, ',', ' ') }}</strong></div>
                        <div style="height:.45rem;background:rgba(148,163,184,.2);border-radius:999px;"><div style="height:.45rem;background:var(--module-accent);border-radius:999px;width:{{ min(100, (float)$row->revenue / max(1, (float)$charts['revenue_by_class']->max('revenue')) * 100) }}%"></div></div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="panel table-wrapper">
        <h3 style="margin-top:0;color:#fca5a5;">Alertes impayés</h3>
        <table>
            <thead><tr><th>Facture</th><th>Élève</th><th>Échéance</th><th>Reste</th></tr></thead>
            <tbody>
                @forelse($unpaid_alerts as $invoice)
                    <tr>
                        <td><code>{{ $invoice->invoice_number }}</code></td>
                        <td>{{ $invoice->enrollment?->student?->full_name ?? '—' }}</td>
                        <td>{{ $invoice->due_date?->format('d/m/Y') }}</td>
                        <td style="color:#fca5a5;">{{ number_format($invoice->balance, 0, ',', ' ') }} {{ $invoice->currency }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="muted">Aucune alerte impayée.</td></tr>
                @endforelse
            </tbody>
        </table>
    </section>
</x-school::layouts.master>
