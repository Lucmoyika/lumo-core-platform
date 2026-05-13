<?php

namespace Modules\School\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\School\Models\AcademicProgram;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Grade;
use Modules\School\Models\SchoolClass;
use Modules\School\Models\Student;
use Modules\School\Models\Teacher;

class SchoolDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (AcademicProgram::query()->exists()) {
            return;
        }

        // ── 1. Academic programs ──────────────────────────────────────────
        $maternelle = AcademicProgram::create([
            'name'         => 'Maternelle',
            'slug'         => 'maternelle',
            'headline'     => 'Éveil et développement de la petite enfance (3-6 ans)',
            'description'  => 'Programme d\'éveil structuré pour accompagner les tout-petits dans leur développement cognitif, moteur et social. Approche ludique et bienveillante.',
            'status'       => 'active',
            'audience'     => 'Enfants de 3 à 6 ans et leurs parents',
            'capabilities' => ['Éveil sensoriel', 'Pré-lecture', 'Motricité fine', 'Expression artistique'],
            'metrics'      => ['velocity' => 92, 'satisfaction' => 97, 'coverage' => 100],
            'is_public'    => true,
            'sort_order'   => 1,
            'settings'     => ['theme' => '#f59e0b', 'module' => 'school'],
        ]);

        $primaire = AcademicProgram::create([
            'name'         => 'Enseignement Primaire',
            'slug'         => 'enseignement-primaire',
            'headline'     => 'Fondations solides pour les élèves de 6 à 12 ans (6 niveaux)',
            'description'  => 'Cycle primaire complet couvrant 6 années d\'enseignement. Accent sur la lecture, l\'écriture, les mathématiques, les sciences et l\'éducation civique.',
            'status'       => 'active',
            'audience'     => 'Élèves de 6 à 12 ans',
            'capabilities' => ['Lecture & écriture', 'Mathématiques', 'Sciences de la vie', 'Éducation civique'],
            'metrics'      => ['velocity' => 88, 'satisfaction' => 93, 'coverage' => 100],
            'is_public'    => true,
            'sort_order'   => 2,
            'settings'     => ['theme' => '#10b981', 'module' => 'school'],
        ]);

        $secondaire = AcademicProgram::create([
            'name'         => 'Humanités Générales',
            'slug'         => 'humanites-generales',
            'headline'     => 'Préparation aux études supérieures — cycle secondaire complet',
            'description'  => 'Cycle secondaire de 6 ans orienté vers les humanités générales avec options Sciences, Lettres et Latin-Philosophie. Préparation au baccalauréat congolais.',
            'status'       => 'active',
            'audience'     => 'Élèves de 12 à 18 ans',
            'capabilities' => ['Options sciences/lettres', 'Épreuves d\'État', 'Orientation supérieure'],
            'metrics'      => ['velocity' => 85, 'satisfaction' => 90, 'coverage' => 95],
            'is_public'    => true,
            'sort_order'   => 3,
            'settings'     => ['theme' => '#6366f1', 'module' => 'school'],
        ]);

        // ── 2. Teachers ───────────────────────────────────────────────────
        $teachers = Teacher::factory()->createMany([
            ['first_name' => 'Jean-Pierre', 'last_name' => 'Muyika',   'specialty' => 'Mathématiques',        'qualification' => 'Licence',  'email' => 'jpmuyika@ecole-lumo.cd'],
            ['first_name' => 'Marie-Claire','last_name' => 'Kasongo',  'specialty' => 'Français',             'qualification' => 'Master',   'email' => 'mckasongo@ecole-lumo.cd'],
            ['first_name' => 'Emmanuel',    'last_name' => 'Ngoy',     'specialty' => 'Sciences',             'qualification' => 'Licence',  'email' => 'engoy@ecole-lumo.cd'],
            ['first_name' => 'Félicité',    'last_name' => 'Mutombo',  'specialty' => 'Histoire-Géographie',  'qualification' => 'Licence',  'email' => 'fmutombo@ecole-lumo.cd'],
            ['first_name' => 'Christophe',  'last_name' => 'Ilunga',   'specialty' => 'Anglais',              'qualification' => 'DESS',     'email' => 'cilunga@ecole-lumo.cd'],
            ['first_name' => 'Grâce',       'last_name' => 'Kabeya',   'specialty' => 'Maternelle',           'qualification' => 'CAPEM',    'email' => 'gkabeya@ecole-lumo.cd'],
            ['first_name' => 'Thierry',     'last_name' => 'Banza',    'specialty' => 'Éducation physique',   'qualification' => 'Licence',  'email' => 'tbanza@ecole-lumo.cd'],
            ['first_name' => 'Patience',    'last_name' => 'Lukusa',   'specialty' => 'Informatique',         'qualification' => 'Master',   'email' => 'plukusa@ecole-lumo.cd'],
        ]);

        // ── 3. School classes ─────────────────────────────────────────────
        $classMat1 = SchoolClass::create(['academic_program_id' => $maternelle->id, 'name' => 'Maternelle 1', 'level' => 'Maternelle 1', 'section' => 'A', 'capacity' => 25, 'room' => 'Salle M1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classMat2 = SchoolClass::create(['academic_program_id' => $maternelle->id, 'name' => 'Maternelle 2', 'level' => 'Maternelle 2', 'section' => 'A', 'capacity' => 25, 'room' => 'Salle M2', 'school_year' => '2025-2026', 'status' => 'active']);
        $classMat3 = SchoolClass::create(['academic_program_id' => $maternelle->id, 'name' => 'Maternelle 3', 'level' => 'Maternelle 3', 'section' => 'A', 'capacity' => 28, 'room' => 'Salle M3', 'school_year' => '2025-2026', 'status' => 'active']);
        $classP1a  = SchoolClass::create(['academic_program_id' => $primaire->id,   'name' => '1ère Primaire', 'level' => '1ère Primaire', 'section' => 'A', 'capacity' => 35, 'room' => 'Salle A1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classP1b  = SchoolClass::create(['academic_program_id' => $primaire->id,   'name' => '1ère Primaire', 'level' => '1ère Primaire', 'section' => 'B', 'capacity' => 35, 'room' => 'Salle A2', 'school_year' => '2025-2026', 'status' => 'active']);
        $classP3a  = SchoolClass::create(['academic_program_id' => $primaire->id,   'name' => '3ème Primaire', 'level' => '3ème Primaire', 'section' => 'A', 'capacity' => 38, 'room' => 'Salle B1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classP6a  = SchoolClass::create(['academic_program_id' => $primaire->id,   'name' => '6ème Primaire', 'level' => '6ème Primaire', 'section' => 'A', 'capacity' => 40, 'room' => 'Salle C1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classS1a  = SchoolClass::create(['academic_program_id' => $secondaire->id, 'name' => '1ère Secondaire', 'level' => '1ère Secondaire', 'section' => 'A', 'capacity' => 40, 'room' => 'Salle D1', 'school_year' => '2025-2026', 'status' => 'active']);
        $classS3a  = SchoolClass::create(['academic_program_id' => $secondaire->id, 'name' => '3ème Secondaire', 'level' => '3ème Secondaire', 'section' => 'A', 'capacity' => 38, 'room' => 'Salle D3', 'school_year' => '2025-2026', 'status' => 'active']);
        $classS6a  = SchoolClass::create(['academic_program_id' => $secondaire->id, 'name' => '6ème Secondaire', 'level' => '6ème Secondaire', 'section' => 'A', 'capacity' => 35, 'room' => 'Salle D6', 'school_year' => '2025-2026', 'status' => 'active']);

        // Assign teachers to classes
        $classMat1->teachers()->attach($teachers[5]->id, ['subject' => 'Maternelle', 'role' => 'teacher']);
        $classMat2->teachers()->attach($teachers[5]->id, ['subject' => 'Maternelle', 'role' => 'teacher']);
        $classP1a->teachers()->attach($teachers[1]->id, ['subject' => 'Français', 'role' => 'teacher']);
        $classP1a->teachers()->attach($teachers[0]->id, ['subject' => 'Mathématiques', 'role' => 'teacher']);
        $classP3a->teachers()->attach($teachers[2]->id, ['subject' => 'Sciences', 'role' => 'teacher']);
        $classP6a->teachers()->attach($teachers[3]->id, ['subject' => 'Histoire-Géographie', 'role' => 'teacher']);
        $classS1a->teachers()->attach($teachers[4]->id, ['subject' => 'Anglais', 'role' => 'teacher']);
        $classS1a->teachers()->attach($teachers[0]->id, ['subject' => 'Mathématiques', 'role' => 'teacher']);
        $classS3a->teachers()->attach($teachers[7]->id, ['subject' => 'Informatique', 'role' => 'teacher']);
        $classS6a->teachers()->attach($teachers[6]->id, ['subject' => 'Éducation physique', 'role' => 'teacher']);

        // ── 4. Students ───────────────────────────────────────────────────
        $studentData = [
            ['EL-2025-0001', 'Josué',     'Muyika',     '2018-03-15', 'male',   'Gombe, Kinshasa',    'M. David Muyika',      '+243 81 234 5678'],
            ['EL-2025-0002', 'Esther',    'Kasongo',    '2019-07-22', 'female', 'Ngaliema, Kinshasa', 'Mme Claudette Kasongo', '+243 89 876 5432'],
            ['EL-2025-0003', 'Daniel',    'Ngoy',       '2017-11-08', 'male',   'Lemba, Kinshasa',    'M. Pierre Ngoy',        '+243 82 345 6789'],
            ['EL-2025-0004', 'Ruth',      'Mutombo',    '2018-01-30', 'female', 'Kasa-Vubu, Kinshasa','Mme Grâce Mutombo',     '+243 90 123 4567'],
            ['EL-2025-0005', 'Samuel',    'Ilunga',     '2016-05-12', 'male',   'Gombe, Kinshasa',    'M. Roger Ilunga',       '+243 85 654 3210'],
            ['EL-2025-0006', 'Déborah',   'Kabeya',     '2015-09-03', 'female', 'Ngaliema, Kinshasa', 'M. Marc Kabeya',        '+243 83 789 0123'],
            ['EL-2025-0007', 'Ezéchiel',  'Banza',      '2016-12-20', 'male',   'Kalamu, Kinshasa',   'Mme Sophie Banza',      '+243 97 234 5678'],
            ['EL-2025-0008', 'Jolie',     'Lukusa',     '2017-04-17', 'female', 'Lemba, Kinshasa',    'M. Henri Lukusa',       '+243 81 567 8901'],
            ['EL-2025-0009', 'Caleb',     'Ntumba',     '2013-08-25', 'male',   'Kasa-Vubu, Kinshasa','Mme Pauline Ntumba',    '+243 84 890 1234'],
            ['EL-2025-0010', 'Rebecca',   'Kabongo',    '2014-02-14', 'female', 'Gombe, Kinshasa',    'M. Albert Kabongo',     '+243 99 012 3456'],
            ['EL-2025-0011', 'Moïse',     'Lufungulo',  '2013-06-30', 'male',   'Ngaliema, Kinshasa', 'Mme Adèle Lufungulo',   '+243 82 123 4567'],
            ['EL-2025-0012', 'Lydie',     'Kibangula',  '2014-10-05', 'female', 'Gombe, Kinshasa',    'M. Théo Kibangula',     '+243 86 345 6789'],
            ['EL-2025-0013', 'Aaron',     'Nzinga',     '2010-03-18', 'male',   'Kalamu, Kinshasa',   'M. Simon Nzinga',       '+243 91 456 7890'],
            ['EL-2025-0014', 'Naomi',     'Mukadi',     '2011-07-09', 'female', 'Lemba, Kinshasa',    'Mme Hortense Mukadi',   '+243 85 567 8901'],
            ['EL-2025-0015', 'David',     'Tshimanga',  '2009-01-24', 'male',   'Kasa-Vubu, Kinshasa','M. Paul Tshimanga',     '+243 88 678 9012'],
            ['EL-2025-0016', 'Miriam',    'Kabamba',    '2010-11-11', 'female', 'Gombe, Kinshasa',    'Mme Lucie Kabamba',     '+243 97 789 0123'],
            ['EL-2025-0017', 'Elijah',    'Mbuyi',      '2008-04-07', 'male',   'Ngaliema, Kinshasa', 'M. Justin Mbuyi',       '+243 82 890 1234'],
            ['EL-2025-0018', 'Rachel',    'Nkusu',      '2009-09-16', 'female', 'Lemba, Kinshasa',    'Mme Rose Nkusu',        '+243 83 901 2345'],
            ['EL-2025-0019', 'Théodore',  'Kandolo',    '2007-06-28', 'male',   'Kalamu, Kinshasa',   'M. Félix Kandolo',      '+243 90 012 3456'],
            ['EL-2025-0020', 'Bénédicte', 'Muyumba',    '2008-12-03', 'female', 'Gombe, Kinshasa',    'Mme Claire Muyumba',    '+243 84 123 4567'],
        ];

        $students = [];
        foreach ($studentData as $d) {
            $students[] = Student::create([
                'student_number' => $d[0],
                'first_name'     => $d[1],
                'last_name'      => $d[2],
                'birth_date'     => $d[3],
                'gender'         => $d[4],
                'address'        => $d[5],
                'parent_name'    => $d[6],
                'parent_phone'   => $d[7],
                'status'         => 'active',
            ]);
        }

        // ── 5. Enrollments ────────────────────────────────────────────────
        $enrollments = [];
        // Maternelle 1: students 0-3
        foreach (array_slice($students, 0, 4) as $s) {
            $enrollments[] = Enrollment::create(['student_id' => $s->id, 'school_class_id' => $classMat1->id, 'school_year' => '2025-2026', 'status' => 'active', 'fee_amount' => 50000, 'fee_paid' => 50000, 'fee_currency' => 'CDF', 'enrolled_at' => '2025-09-01']);
        }
        // 1ère Primaire A: students 4-7
        foreach (array_slice($students, 4, 4) as $s) {
            $enrollments[] = Enrollment::create(['student_id' => $s->id, 'school_class_id' => $classP1a->id, 'school_year' => '2025-2026', 'status' => 'active', 'fee_amount' => 75000, 'fee_paid' => fake()->numberBetween(30000, 75000), 'fee_currency' => 'CDF', 'enrolled_at' => '2025-09-01']);
        }
        // 3ème Primaire A: students 8-11
        foreach (array_slice($students, 8, 4) as $s) {
            $enrollments[] = Enrollment::create(['student_id' => $s->id, 'school_class_id' => $classP3a->id, 'school_year' => '2025-2026', 'status' => 'active', 'fee_amount' => 80000, 'fee_paid' => fake()->numberBetween(40000, 80000), 'fee_currency' => 'CDF', 'enrolled_at' => '2025-09-01']);
        }
        // 1ère Secondaire A: students 12-15
        foreach (array_slice($students, 12, 4) as $s) {
            $enrollments[] = Enrollment::create(['student_id' => $s->id, 'school_class_id' => $classS1a->id, 'school_year' => '2025-2026', 'status' => 'active', 'fee_amount' => 120000, 'fee_paid' => fake()->numberBetween(60000, 120000), 'fee_currency' => 'CDF', 'enrolled_at' => '2025-09-01']);
        }
        // 6ème Secondaire A: students 16-19
        foreach (array_slice($students, 16, 4) as $s) {
            $enrollments[] = Enrollment::create(['student_id' => $s->id, 'school_class_id' => $classS6a->id, 'school_year' => '2025-2026', 'status' => 'active', 'fee_amount' => 150000, 'fee_paid' => fake()->numberBetween(100000, 150000), 'fee_currency' => 'CDF', 'enrolled_at' => '2025-09-01']);
        }

        // ── 6. Grades ─────────────────────────────────────────────────────
        $subjects = ['Mathématiques', 'Français', 'Sciences', 'Histoire-Géographie', 'Anglais'];
        $periods  = ['1er trimestre', '2ème trimestre', '3ème trimestre'];

        foreach ($enrollments as $enrollment) {
            foreach ($subjects as $subject) {
                foreach ($periods as $period) {
                    $score = round(fake()->numberBetween(8, 20) + fake()->randomFloat(1, 0, 0.9), 1);
                    Grade::create([
                        'enrollment_id' => $enrollment->id,
                        'teacher_id'    => $teachers[0]->id,
                        'subject'       => $subject,
                        'period'        => $period,
                        'score'         => $score,
                        'max_score'     => 20,
                        'grade_letter'  => self::letterGrade($score, 20),
                        'graded_at'     => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
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

