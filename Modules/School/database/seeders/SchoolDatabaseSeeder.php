<?php

namespace Modules\School\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\School\Models\AcademicProgram;
use Illuminate\Support\Str;

class SchoolDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $records = [
            [
                'name' => 'Maternelle · Éveil Numérique',
                'headline' => 'Parcours maternelle avec activités cognitives, artistiques et digitales.',
                'description' => 'Programme orienté découverte, socialisation et initiation aux outils numériques adaptés à l’âge.',
                'status' => 'active',
                'audience' => 'Parents, encadreurs petite enfance et direction pédagogique',
                'level' => 'maternelle',
                'duration_months' => 12,
                'annual_fee' => 420.00,
                'capabilities' => ['Préinscriptions en ligne', 'Suivi présence', 'Communication parent-école'],
                'metrics' => ['coverage' => 89, 'satisfaction' => 94, 'velocity' => 82],
                'is_public' => true,
                'admission_open' => true,
                'admission_deadline' => now()->addMonths(2)->toDateString(),
                'sort_order' => 1,
                'settings' => ['theme' => '#6366f1', 'module' => 'school'],
            ],
            [
                'name' => 'Primaire · Excellence Scientifique',
                'headline' => 'Cycle primaire renforcé en mathématiques, sciences et langues.',
                'description' => 'Programme de consolidation des fondamentaux avec évaluations continues et activités STEM.',
                'status' => 'active',
                'audience' => 'Élèves primaire, enseignants et coordination académique',
                'level' => 'primaire',
                'duration_months' => 36,
                'annual_fee' => 650.00,
                'capabilities' => ['Classes intelligentes', 'Évaluations trimestrielles', 'Tableau de bord parents'],
                'metrics' => ['coverage' => 93, 'satisfaction' => 91, 'velocity' => 88],
                'is_public' => true,
                'admission_open' => true,
                'admission_deadline' => now()->addMonths(3)->toDateString(),
                'sort_order' => 2,
                'settings' => ['theme' => '#6366f1', 'module' => 'school'],
            ],
            [
                'name' => 'Secondaire · Sciences & Technologies',
                'headline' => 'Filière secondaire axée laboratoires, programmation et robotique.',
                'description' => 'Approche projet pour développer compétences scientifiques et résolution de problèmes réels.',
                'status' => 'active',
                'audience' => 'Élèves secondaires, corps enseignant et encadrement',
                'level' => 'secondaire',
                'duration_months' => 48,
                'annual_fee' => 980.00,
                'capabilities' => ['Laboratoires pratiques', 'Parcours numérique', 'Orientation universitaire'],
                'metrics' => ['coverage' => 90, 'satisfaction' => 88, 'velocity' => 84],
                'is_public' => true,
                'admission_open' => false,
                'admission_deadline' => now()->addMonth()->toDateString(),
                'sort_order' => 3,
                'settings' => ['theme' => '#6366f1', 'module' => 'school'],
            ],
            [
                'name' => 'Professionnel · Gestion & Entrepreneuriat',
                'headline' => 'Parcours professionnalisant en gestion, comptabilité et innovation.',
                'description' => 'Formation orientée emploi avec ateliers pratiques, stages et incubateur scolaire.',
                'status' => 'draft',
                'audience' => 'Étudiants filière pro, coachs métiers et partenaires',
                'level' => 'professionnel',
                'duration_months' => 24,
                'annual_fee' => 790.00,
                'capabilities' => ['Suivi des stages', 'Portefeuille compétences', 'Partenariats entreprises'],
                'metrics' => ['coverage' => 74, 'satisfaction' => 86, 'velocity' => 71],
                'is_public' => false,
                'admission_open' => false,
                'admission_deadline' => now()->addMonths(5)->toDateString(),
                'sort_order' => 4,
                'settings' => ['theme' => '#6366f1', 'module' => 'school'],
            ],
        ];

        foreach ($records as $record) {
            AcademicProgram::query()->updateOrCreate(
                ['slug' => Str::slug($record['name'])],
                array_merge($record, ['slug' => Str::slug($record['name'])]),
            );
        }
    }
}
