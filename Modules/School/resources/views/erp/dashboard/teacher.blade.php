<x-school::layouts.master :module="$module" page-title="Teacher Dashboard · School ERP">
    <h1>👨‍🏫 Teacher Dashboard — {{ $teacher->full_name }}</h1>
    <section class="card-grid" style="margin-bottom:1rem;">
        <article class="card"><strong>{{ $assigned_classes->count() }}</strong><p class="muted">Classes assignées</p></article>
        <article class="card"><strong>{{ $today_schedule->count() }}</strong><p class="muted">Cours aujourd'hui</p></article>
        <article class="card"><strong>{{ $students->count() }}</strong><p class="muted">Élèves suivis</p></article>
        <article class="card"><a class="badge" href="{{ route('school.erp.students') }}">Saisie rapide des notes</a></article>
    </section>
    <section class="panel" style="margin-bottom:1rem;"><h3 style="margin-top:0;">Planning du jour</h3>@forelse($today_schedule as $entry)<div>{{ $entry->starts_at }} - {{ $entry->ends_at }} · {{ $entry->schoolClass->full_name }} · {{ $entry->subject->name }}</div>@empty<div class="muted">Aucun cours aujourd'hui.</div>@endforelse</section>
    <section class="panel table-wrapper" style="margin-bottom:1rem;"><h3 style="margin-top:0;">Élèves</h3><table><thead><tr><th>Nom</th><th>N°</th></tr></thead><tbody>@foreach($students as $student)<tr><td>{{ $student->full_name }}</td><td>{{ $student->student_number }}</td></tr>@endforeach</tbody></table></section>
    <section class="panel table-wrapper"><h3 style="margin-top:0;">Dernières notes saisies</h3><table><thead><tr><th>Élève</th><th>Matière</th><th>Période</th><th>Note</th></tr></thead><tbody>@foreach($mark_entry_shortcut as $grade)<tr><td>{{ $grade->enrollment?->student?->full_name }}</td><td>{{ $grade->subject }}</td><td>{{ $grade->period }}</td><td>{{ $grade->score }}/{{ $grade->max_score }}</td></tr>@endforeach</tbody></table></section>
</x-school::layouts.master>
