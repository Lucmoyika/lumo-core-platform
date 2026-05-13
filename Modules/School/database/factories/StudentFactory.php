<?php

namespace Modules\School\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\School\Models\Student;

class StudentFactory extends Factory
{
    protected $model = Student::class;

    private static int $counter = 1;

    private static array $congoleseFirstNames = [
        'Josué', 'Esther', 'Daniel', 'Ruth', 'Samuel',
        'Déborah', 'Ezéchiel', 'Jolie', 'Caleb', 'Rebecca',
        'Moïse', 'Lydie', 'Aaron', 'Naomi', 'David',
        'Miriam', 'Elijah', 'Rachel', 'Joshua', 'Sarah',
        'Théodore', 'Bénédicte', 'Aristide', 'Clarisse', 'Firmin',
        'Gertrude', 'Hubert', 'Innocent', 'Joëlle', 'Kévin',
        'Laurence', 'Marcel', 'Nathalie', 'Octave', 'Prudence',
    ];

    private static array $congoleseLastNames = [
        'Muyika', 'Kasongo', 'Ngoy', 'Mwamba', 'Mutombo',
        'Kalala', 'Mukeba', 'Ilunga', 'Kabeya', 'Kongolo',
        'Banza', 'Lukusa', 'Ntumba', 'Kabongo', 'Lufungulo',
        'Kibangula', 'Nzinga', 'Mukadi', 'Tshimanga', 'Kabamba',
        'Mbuyi', 'Nkusu', 'Kandolo', 'Muyumba', 'Lubamba',
    ];

    public function definition(): array
    {
        $firstName = $this->faker->randomElement(self::$congoleseFirstNames);
        $lastName = $this->faker->randomElement(self::$congoleseLastNames);

        return [
            'student_number' => 'EL-' . date('Y') . '-' . str_pad((string)(self::$counter++), 4, '0', STR_PAD_LEFT),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'birth_date' => $this->faker->dateTimeBetween('-18 years', '-4 years'),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'email' => null,
            'phone' => null,
            'address' => $this->faker->randomElement(['Gombe', 'Ngaliema', 'Lemba', 'Kasa-Vubu', 'Kalamu']) . ', Kinshasa',
            'parent_name' => $this->faker->randomElement(['M.', 'Mme']) . ' ' . $this->faker->randomElement(self::$congoleseFirstNames) . ' ' . $lastName,
            'parent_phone' => '+243 ' . $this->faker->numerify('## ### ####'),
            'parent_email' => strtolower(Str::ascii($lastName)) . '@gmail.com',
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'suspended', 'transferred']),
        ];
    }
}
