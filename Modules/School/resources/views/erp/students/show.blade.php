<x-school::layouts.master :module="$module ?? \App\Support\Modules\ModuleRegistry::find('school')" :page-title="$student->full_name.' · Élève'">
    <style>
        .info-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:1rem; margin-bottom:1.5rem; }
        .info-item { display:flex; flex-direction:column; gap:.25rem; }
        .info-label { font-size:.8rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b; }
        .info-value { font-weight:600; }
        .back-link { color:#94a3b8; text-decoration:none; display:inline-flex; align-items:center; gap:.4rem; margin-bottom:1rem; }
        .grade-pill { display:inline-block; padding:.2rem .6rem; border-radius:999px; font-size:.8rem; font-weight:700; background:rgba(99,102,241,.2); color:#a5b4fc; }
    </style>

    <a href="{{ route('school.erp.students') }}" class="back-link">← Liste des élèves</a>

    <section class="hero" style="margin-bottom:1.5rem;">
        <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
            <div style="width:4rem;height:4rem;border-radius:50%;background:var(--module-accent);display:grid;place-items:center;font-size:1.5rem;">
                {{ $student->gender === 'female' ? '👧' : '👦' }}
            </div>
            <div>
                <h1 style="margin:0;">{{ $student->full_name }}</h1>
                <p class="muted" style="margin:.25rem 0 0;">{{ $student->student_number }} · {{ $student->gender === 'male' ? 'Masculin' : 'Féminin' }} · {{ $student->birth_date->format('d/m/Y') }} ({{ $student->age }} ans)</p>
            </div>
            <span class="status" style="margin-left:auto;">{{ ucfirst($student->status) }}</span>
        </div>
    </section>

    <div class="info-grid" style="margin-bottom:1.5rem;">
        <article class="panel">
            <h3 style="margin-top:0;">Informations personnelles</h3>
            <div class="info-item"><span class="info-label">Adresse</span><span class="info-value">{{ $student->address ?? '—' }}</span></div>
            <div class="info-item" style="margin-top:.75rem;"><span class="info-label">Email</span><span class="info-value">{{ $student->email ?? '—' }}</span></div>
        </article>
        <article class="panel">
            <h3 style="margin-top:0;">Contact parenté</h3>
            <div class="info-item"><span class="info-label">Parent/Tuteur</span><span class="info-value">{{ $student->parent_name ?? '—' }}</span></div>
            <div class="info-item" style="margin-top:.75rem;"><span class="info-label">Téléphone</span><span class="info-value">{{ $student->parent_phone ?? '—' }}</span></div>
            <div class="info-item" style="margin-top:.75rem;"><span class="info-label">Email parent</span><span class="info-value">{{ $student->parent_email ?? '—' }}</span></div>
        </article>
    </div>

    @foreach($student->enrollments as $enrollment)
        <section class="panel" style="margin-bottom:1.5rem;">
            <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:.5rem; margin-bottom:1rem;">
                <div>
                    <h3 style="margin:0;">{{ $enrollment->schoolClass->name }} - {{ $enrollment->schoolClass->section }} ({{ $enrollment->school_year }})</h3>
                    <p class="muted" style="margin:.25rem 0 0;">{{ $enrollment->schoolClass->academicProgram->name ?? '' }} · Salle {{ $enrollment->schoolClass->room }}</p>
                </div>
                <div style="text-align:right;">
                    <a class="badge" href="{{ route('school.erp.report-cards.show', ['enrollmentId' => $enrollment->id]) }}">Bulletin</a>
                    <div class="muted" style="font-size:.8rem;">Présence: {{ $enrollment->attendance_rate }}%</div>
                    <div class="muted" style="font-size:.8rem;">Frais scolaires</div>
                    <strong>{{ number_format($enrollment->fee_paid, 0, ',', ' ') }} / {{ number_format($enrollment->fee_amount, 0, ',', ' ') }} {{ $enrollment->fee_currency }}</strong>
                    @if($enrollment->fee_balance > 0)
                        <div style="color:#fca5a5; font-size:.8rem;">Solde: {{ number_format($enrollment->fee_balance, 0, ',', ' ') }} {{ $enrollment->fee_currency }}</div>
                    @else
                        <div style="color:#86efac; font-size:.8rem;">✓ Soldé</div>
                    @endif
                </div>
            </div>

            @if($enrollment->grades->count())
                <table>
                    <thead>
                        <tr><th>Matière</th><th>Période</th><th>Note</th><th>/Max</th><th>%</th><th>Mention</th></tr>
                    </thead>
                    <tbody>
                        @foreach($enrollment->grades->sortBy(['subject','period']) as $grade)
                            <tr>
                                <td>{{ $grade->subject }}</td>
                                <td class="muted">{{ $grade->period }}</td>
                                <td><strong>{{ $grade->score }}</strong></td>
                                <td class="muted">{{ $grade->max_score }}</td>
                                <td>{{ $grade->percentage }}%</td>
                                <td><span class="grade-pill">{{ $grade->grade_letter }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="muted">Aucune note enregistrée.</p>
            @endif
        </section>
    @endforeach
</x-school::layouts.master>
