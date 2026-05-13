<?php

namespace Modules\School\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\School\Models\Enrollment;
use Modules\School\Models\Grade;
use Modules\School\Models\Teacher;

class GradeFactory extends Factory
{
    protected $model = Grade::class;

    private static array $subjects = [
        'Mathématiques', 'Français', 'Sciences', 'Histoire', 'Géographie',
        'Anglais', 'Éducation physique', 'Informatique', 'Chimie', 'Biologie',
    ];

    private static array $periods = [
        '1er trimestre', '2ème trimestre', '3ème trimestre',
        '1ère période', '2ème période',
    ];

    public function definition(): array
    {
        $maxScore = 20;
        $score = round($this->faker->numberBetween(4, 20) + $this->faker->randomFloat(1, 0, 0.9), 1);

        return [
            'enrollment_id' => Enrollment::factory(),
            'teacher_id' => Teacher::factory(),
            'subject' => $this->faker->randomElement(self::$subjects),
            'period' => $this->faker->randomElement(self::$periods),
            'score' => $score,
            'max_score' => $maxScore,
            'grade_letter' => self::letterGrade((float) $score, (float) $maxScore),
            'comment' => $this->faker->boolean(40) ? $this->faker->sentence(8) : null,
            'graded_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
        ];
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
