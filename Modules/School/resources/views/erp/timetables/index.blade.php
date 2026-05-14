<x-school::layouts.master :module="$module" page-title="Timetable · School ERP">
    <h1>🗓️ Emploi du temps hebdomadaire</h1>
    <form method="GET" style="margin-bottom:1rem;display:flex;gap:.6rem;flex-wrap:wrap;">
        <select name="class_id" style="padding:.55rem .7rem;border-radius:.5rem;background:#0f172a;color:#e2e8f0;">
            @foreach($classes as $class)
                <option value="{{ $class->id }}" @selected($selected_class && $selected_class->id === $class->id)>{{ $class->full_name }}</option>
            @endforeach
        </select>
        <button class="cta" type="submit">Afficher</button>
    </form>
    <section class="panel table-wrapper">
        <table>
            <thead><tr><th>Jour</th><th>Horaire</th><th>Matière</th><th>Enseignant</th><th>Salle</th><th>Conflit</th></tr></thead>
            <tbody>
                @foreach($entries as $entry)
                    <tr>
                        <td>{{ $weekdays[$entry->day_of_week] ?? $entry->day_of_week }}</td>
                        <td>{{ $entry->starts_at }} - {{ $entry->ends_at }}</td>
                        <td>{{ $entry->subject->name }}</td>
                        <td>{{ $entry->teacher->full_name }}</td>
                        <td>{{ $entry->room }}</td>
                        <td>{!! in_array($entry->id, $conflicts, true) ? '<span style="color:#fca5a5;">⚠ Conflit enseignant</span>' : '<span style="color:#86efac;">✓</span>' !!}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</x-school::layouts.master>
