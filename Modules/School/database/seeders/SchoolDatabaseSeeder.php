<?php

namespace Modules\School\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Modules\School\Models\AcademicProgram;
use Modules\School\Models\Admission;
use Modules\School\Models\Attendance;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Exam;
use Modules\School\Models\Grade;
use Modules\School\Models\Invoice;
use Modules\School\Models\ParentGuardian;
use Modules\School\Models\Payment;
use Modules\School\Models\ReportCard;
use Modules\School\Models\SchoolClass;
use Modules\School\Models\Student;
use Modules\School\Models\Subject;
use Modules\School\Models\Teacher;
use Modules\School\Models\TimetableEntry;

class SchoolDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (AcademicProgram::query()->exists()) {
            return;
        }

        $maternelle = AcademicProgram::create([
            'name' => 'Maternelle',
            'slug' => 'maternelle',
            'headline' => 'Éveil et développement de la petite enfance (3-6 ans)',
            'description' => 'Programme d\'éveil structuré pour accompagner les tout-petits.',
            'status' => 'active',
            'audience' => 'Enfants de 3 à 6 ans et leurs parents',
            'capabilities' => ['Éveil sensoriel', 'Pré-lecture', 'Motricité fine'],
            'metrics' => ['velocity' => 92, 'satisfaction' => 97],
            'is_public' => true,
            'sort_order' => 1,
            'settings' => ['theme' => '#f59e0b', 'module' => 'school'],
        ]);

        $primaire = AcademicProgram::create([
            'name' => 'Enseignement Primaire',
            'slug' => 'enseignement-primaire',
            'headline' => 'Fondations solides pour les élèves de 6 à 12 ans',
            'description' => 'Cycle primaire complet de 6 années.',
            'status' => 'active',
            'audience' => 'Élèves de 6 à 12 ans',
            'capabilities' => ['Lecture & écriture', 'Mathématiques', 'Sciences'],
            'metrics' => ['velocity' => 88, 'satisfaction' => 93],
            'is_public' => true,
            'sort_order' => 2,
            'settings' => ['theme' => '#10b981', 'module' => 'school'],
        ]);

        $secondaire = AcademicProgram::create([
            'name' => 'Humanités Générales',
            'slug' => 'humanites-generales',
            'headline' => 'Préparation aux études supérieures',
            'description' => 'Cycle secondaire de 6 ans orienté humanités générales.',
            'status' => 'active',
            'audience' => 'Élèves de 12 à 18 ans',
            'capabilities' => ['Options sciences/lettres', 'Épreuves d\'État'],
            'metrics' => ['velocity' => 85, 'satisfaction' => 90],
            'is_public' => true,
            'sort_order' => 3,
            'settings' => ['theme' => '#6366f1', 'module' => 'school'],
        ]);

        $teachers = Teacher::factory()->createMany([
            ['first_name' => 'Jean-Pierre', 'last_name' => 'Muyika', 'specialty' => 'Mathématiques', 'qualification' => 'Licence', 'email' => 'jpmuyika@ecole-lumo.cd'],
            ['first_name' => 'Marie-Claire', 'last_name' => 'Kasongo', 'specialty' => 'Français', 'qualification' => 'Master', 'email' => 'mckasongo@ecole-lumo.cd'],
            ['first_name' => 'Emmanuel', 'last_name' => 'Ngoy', 'specialty' => 'Sciences', 'qualification' => 'Licence', 'email' => 'engoy@ecole-lumo.cd'],
            ['first_name' => 'Félicité', 'last_name' => 'Mutombo', 'specialty' => 'Histoire-Géographie', 'qualification' => 'Licence', 'email' => 'fmutombo@ecole-lumo.cd'],
            ['first_name' => 'Christophe', 'last_name' => 'Ilunga', 'specialty' => 'Anglais', 'qualification' => 'DESS', 'email' => 'cilunga@ecole-lumo.cd'],
            ['first_name' => 'Grâce', 'last_name' => 'Kabeya', 'specialty' => 'Maternelle', 'qualification' => 'CAPEM', 'email' => 'gkabeya@ecole-lumo.cd'],
            ['first_name' => 'Thierry', 'last_name' => 'Banza', 'specialty' => 'Éducation physique', 'qualification' => 'Licence', 'email' => 'tbanza@ecole-lumo.cd'],
            ['first_name' => 'Patience', 'last_name' => 'Lukusa', 'specialty' => 'Informatique', 'qualification' => 'Master', 'email' => 'plukusa@ecole-lumo.cd'],
        ]);

        $subjects = collect([
            ['name' => 'Mathématiques', 'code' => 'MATH', 'coefficient' => 2],
            ['name' => 'Français', 'code' => 'FR', 'coefficient' => 2],
            ['name' => 'Sciences', 'code' => 'SCI', 'coefficient' => 2],
            ['name' => 'Histoire-Géographie', 'code' => 'HG', 'coefficient' => 1],
            ['name' => 'Anglais', 'code' => 'ENG', 'coefficient' => 1],
            ['name' => 'Informatique', 'code' => 'INFO', 'coefficient' => 1],
            ['name' => 'Éducation physique', 'code' => 'EPS', 'coefficient' => 1],
        ])->map(fn (array $subject) => Subject::create($subject));

        $subjectByName = $subjects->keyBy('name');

        $classMat1 = SchoolClass::create(['academic_program_id' => $maternelle->id, 'name' => 'Maternelle 1', 'level' => 'Maternelle 1', 'section' => 'A', 'capacity' => 25, 'room' => 'Salle M1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classP1a = SchoolClass::create(['academic_program_id' => $primaire->id, 'name' => '1ère Primaire', 'level' => '1ère Primaire', 'section' => 'A', 'capacity' => 35, 'room' => 'Salle A1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classP3a = SchoolClass::create(['academic_program_id' => $primaire->id, 'name' => '3ème Primaire', 'level' => '3ème Primaire', 'section' => 'A', 'capacity' => 38, 'room' => 'Salle B1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classS1a = SchoolClass::create(['academic_program_id' => $secondaire->id, 'name' => '1ère Secondaire', 'level' => '1ère Secondaire', 'section' => 'A', 'capacity' => 40, 'room' => 'Salle D1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classS6a = SchoolClass::create(['academic_program_id' => $secondaire->id, 'name' => '6ème Secondaire', 'level' => '6ème Secondaire', 'section' => 'A', 'capacity' => 35, 'room' => 'Salle D6', 'school_year' => '2025-2026', 'status' => 'active']);

        $classTeacherMap = [
            [$classMat1, $teachers[5], 'Français'],
            [$classP1a, $teachers[1], 'Français'],
            [$classP1a, $teachers[0], 'Mathématiques'],
            [$classP3a, $teachers[2], 'Sciences'],
            [$classS1a, $teachers[4], 'Anglais'],
            [$classS1a, $teachers[0], 'Mathématiques'],
            [$classS6a, $teachers[7], 'Informatique'],
            [$classS6a, $teachers[6], 'Éducation physique'],
        ];

        foreach ($classTeacherMap as [$class, $teacher, $subjectName]) {
            $class->teachers()->attach($teacher->id, ['subject' => $subjectName, 'role' => 'teacher']);
            $subject = $subjectByName->get($subjectName);
            if ($subject) {
                $teacher->subjectsRelation()->syncWithoutDetaching([$subject->id]);
                DB::table('school_class_subject_teacher')->insert([
                    'school_class_id' => $class->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacher->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        $studentData = [
            ['EL-2025-0001', 'Josué', 'Muyika', '2018-03-15', 'male', 'Gombe, Kinshasa', 'M. David Muyika', '+243 81 234 5678'],
            ['EL-2025-0002', 'Esther', 'Kasongo', '2019-07-22', 'female', 'Ngaliema, Kinshasa', 'Mme Claudette Kasongo', '+243 89 876 5432'],
            ['EL-2025-0003', 'Daniel', 'Ngoy', '2017-11-08', 'male', 'Lemba, Kinshasa', 'M. Pierre Ngoy', '+243 82 345 6789'],
            ['EL-2025-0004', 'Ruth', 'Mutombo', '2018-01-30', 'female', 'Kasa-Vubu, Kinshasa', 'Mme Grâce Mutombo', '+243 90 123 4567'],
            ['EL-2025-0005', 'Samuel', 'Ilunga', '2016-05-12', 'male', 'Gombe, Kinshasa', 'M. Roger Ilunga', '+243 85 654 3210'],
            ['EL-2025-0006', 'Déborah', 'Kabeya', '2015-09-03', 'female', 'Ngaliema, Kinshasa', 'M. Marc Kabeya', '+243 83 789 0123'],
            ['EL-2025-0007', 'Ezéchiel', 'Banza', '2016-12-20', 'male', 'Kalamu, Kinshasa', 'Mme Sophie Banza', '+243 97 234 5678'],
            ['EL-2025-0008', 'Jolie', 'Lukusa', '2017-04-17', 'female', 'Lemba, Kinshasa', 'M. Henri Lukusa', '+243 81 567 8901'],
            ['EL-2025-0009', 'Caleb', 'Ntumba', '2013-08-25', 'male', 'Kasa-Vubu, Kinshasa', 'Mme Pauline Ntumba', '+243 84 890 1234'],
            ['EL-2025-0010', 'Rebecca', 'Kabongo', '2014-02-14', 'female', 'Gombe, Kinshasa', 'M. Albert Kabongo', '+243 99 012 3456'],
        ];

        $students = collect($studentData)->map(function (array $d): Student {
            return Student::create([
                'student_number' => $d[0],
                'first_name' => $d[1],
                'last_name' => $d[2],
                'birth_date' => $d[3],
                'gender' => $d[4],
                'address' => $d[5],
                'parent_name' => $d[6],
                'parent_phone' => $d[7],
                'status' => 'active',
            ]);
        });

        $students->each(function (Student $student): void {
            Admission::create([
                'student_id' => $student->id,
                'reference' => 'ADM-' . now()->format('Y') . '-' . str_pad((string) $student->id, 4, '0', STR_PAD_LEFT),
                'status' => 'approved',
                'applied_at' => Carbon::parse('2025-08-20'),
                'approved_at' => Carbon::parse('2025-08-25'),
                'meta' => ['channel' => 'online'],
            ]);
        });

        $parents = [];
        foreach ($students as $student) {
            $key = Str::lower((string) $student->parent_name);
            if (! isset($parents[$key])) {
                $parents[$key] = ParentGuardian::create([
                    'name' => $student->parent_name,
                    'phone' => $student->parent_phone,
                    'email' => null,
                    'relationship' => 'parent',
                ]);
            }
            $parents[$key]->students()->syncWithoutDetaching([$student->id => ['relationship' => 'parent']]);
        }

        $enrollments = collect();
        foreach ([$classMat1, $classP1a, $classP3a, $classS1a, $classS6a] as $index => $class) {
            foreach ($students->slice($index * 2, 2) as $student) {
                $enrollments->push(Enrollment::create([
                    'student_id' => $student->id,
                    'school_class_id' => $class->id,
                    'school_year' => '2025-2026',
                    'status' => 'active',
                    'fee_amount' => [50000, 75000, 80000, 120000, 150000][$index],
                    'fee_paid' => fake()->numberBetween(30000, [50000, 75000, 80000, 120000, 150000][$index]),
                    'fee_currency' => 'CDF',
                    'enrolled_at' => '2025-09-01',
                ]));
            }
        }

        $periods = ['1er trimestre', '2ème trimestre', '3ème trimestre'];

        foreach ($enrollments as $enrollment) {
            $class = $enrollment->schoolClass;
            $teacherPivot = $class->teachers()->get();

            foreach ($periods as $period) {
                foreach ($teacherPivot as $teacher) {
                    $subjectName = $teacher->pivot->subject;
                    $subject = $subjectByName->get($subjectName) ?? $subjectByName->first();

                    $exam = Exam::create([
                        'school_class_id' => $class->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'name' => 'Contrôle ' . $period,
                        'period' => $period,
                        'exam_date' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                        'max_score' => 20,
                    ]);

                    $score = round(fake()->numberBetween(8, 20) + fake()->randomFloat(1, 0, 0.9), 1);

                    Grade::create([
                        'enrollment_id' => $enrollment->id,
                        'teacher_id' => $teacher->id,
                        'exam_id' => $exam->id,
                        'subject' => $subjectName,
                        'period' => $period,
                        'score' => $score,
                        'max_score' => 20,
                        'grade_letter' => self::letterGrade($score, 20),
                        'graded_at' => $exam->exam_date,
                    ]);
                }

                $average = round((float) $enrollment->grades()->where('period', $period)->selectRaw('AVG((score / max_score) * 100) as avg_pct')->value('avg_pct'), 2);
                ReportCard::create([
                    'enrollment_id' => $enrollment->id,
                    'period' => $period,
                    'average' => $average,
                    'rank' => null,
                    'teacher_comment' => $average >= 60 ? 'Bon travail, continuez vos efforts.' : 'Renforcement recommandé sur les fondamentaux.',
                    'generated_at' => now()->toDateString(),
                ]);
            }

            for ($d = 1; $d <= 20; $d++) {
                Attendance::create([
                    'enrollment_id' => $enrollment->id,
                    'date' => Carbon::parse('2026-01-01')->addDays($d),
                    'status' => fake()->randomElement(['present', 'present', 'present', 'absent', 'late']),
                    'reason' => null,
                    'notified' => false,
                ]);
            }

            $invoice = Invoice::create([
                'enrollment_id' => $enrollment->id,
                'invoice_number' => 'INV-2026-' . str_pad((string) $enrollment->id, 5, '0', STR_PAD_LEFT),
                'amount' => $enrollment->fee_amount,
                'paid_amount' => min((float) $enrollment->fee_paid, (float) $enrollment->fee_amount),
                'currency' => $enrollment->fee_currency,
                'due_date' => Carbon::parse('2026-02-15')->toDateString(),
                'status' => ((float) $enrollment->fee_paid >= (float) $enrollment->fee_amount) ? 'paid' : 'partial',
            ]);

            if ((float) $invoice->paid_amount > 0) {
                Payment::create([
                    'invoice_id' => $invoice->id,
                    'amount' => $invoice->paid_amount,
                    'method' => fake()->randomElement(['cash', 'mobile-money', 'bank-transfer']),
                    'reference' => 'PAY-' . Str::upper(Str::random(8)),
                    'paid_at' => Carbon::parse('2026-01-20')->toDateString(),
                ]);
            }
        }

        foreach ([$classMat1, $classP1a, $classP3a, $classS1a, $classS6a] as $class) {
            $subjectTeacherAssignments = DB::table('school_class_subject_teacher')->where('school_class_id', $class->id)->get();
            foreach ($subjectTeacherAssignments as $assignment) {
                for ($day = 1; $day <= 5; $day++) {
                    TimetableEntry::firstOrCreate([
                        'school_class_id' => $class->id,
                        'teacher_id' => $assignment->teacher_id,
                        'subject_id' => $assignment->subject_id,
                        'day_of_week' => $day,
                        'starts_at' => '08:00:00',
                        'ends_at' => '09:00:00',
                    ], [
                        'room' => $class->room,
                    ]);
                }
            }
        }
    }

    private static function letterGrade(float $score, float $max): string
    {
        $pct = ($score / $max) * 100;
        if ($pct >= 90) return 'A+';
        if ($pct >= 80) return 'A';
        if ($pct >= 70) return 'B';
        if ($pct >= 60) return 'C';
        if ($pct >= 50) return 'D';
        return 'F';
    }
}
