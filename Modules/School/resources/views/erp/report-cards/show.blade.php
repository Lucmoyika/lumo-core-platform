<x-school::layouts.master :module="$module" page-title="Bulletin · School ERP">
    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:.5rem;">
        <h1 style="margin:0;">🧾 Bulletin — {{ $enrollment->student->full_name }}</h1>
        <a class="cta" href="{{ route('school.erp.report-cards.pdf', ['enrollmentId' => $enrollment->id, 'period' => $period]) }}">Exporter PDF</a>
    </div>
    <section class="stats-grid" style="margin:1rem 0;">
        <article class="stat"><strong>{{ $period }}</strong><div class="muted">Période</div></article>
        <article class="stat"><strong>{{ $average }}%</strong><div class="muted">Moyenne</div></article>
        <article class="stat"><strong>{{ $rank ?? '-' }}</strong><div class="muted">Rang</div></article>
        <article class="stat"><strong>{{ $attendance_rate }}%</strong><div class="muted">Présence</div></article>
    </section>
    <section class="panel table-wrapper" style="margin-bottom:1rem;">
        <table>
            <thead><tr><th>Matière</th><th>Moyenne</th><th>Enseignant</th></tr></thead>
            <tbody>@foreach($subjects as $row)<tr><td>{{ $row['subject'] }}</td><td>{{ $row['average'] }}%</td><td>{{ $row['teacher'] ?? '—' }}</td></tr>@endforeach</tbody>
        </table>
    </section>
    <section class="panel" style="margin-bottom:1rem;"><h3 style="margin-top:0;">Commentaire enseignant</h3><p>{{ $report_card->teacher_comment }}</p></section>
    <section class="panel table-wrapper"><h3 style="margin-top:0;">Classement de la classe</h3><table><thead><tr><th>#</th><th>Élève</th><th>Moyenne</th></tr></thead><tbody>@foreach($ranking as $i => $row)<tr><td>{{ $i + 1 }}</td><td>{{ $row['student'] }}</td><td>{{ $row['average'] }}%</td></tr>@endforeach</tbody></table></section>
</x-school::layouts.master>
