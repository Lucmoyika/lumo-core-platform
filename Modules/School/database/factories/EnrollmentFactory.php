<?php

namespace Modules\School\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\School\Models\Enrollment;
use Modules\School\Models\SchoolClass;
use Modules\School\Models\Student;

class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'school_class_id' => SchoolClass::factory(),
            'school_year' => '2025-2026',
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'suspended']),
            'fee_amount' => $this->faker->randomElement([50000, 75000, 100000, 120000, 150000]),
            'fee_paid' => fn (array $attrs) => $this->faker->numberBetween(0, (int) $attrs['fee_amount']),
            'fee_currency' => 'CDF',
            'enrolled_at' => $this->faker->dateTimeBetween('-8 months', '-1 month'),
        ];
    }
}
