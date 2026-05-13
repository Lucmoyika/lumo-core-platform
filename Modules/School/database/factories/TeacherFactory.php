<?php

namespace Modules\School\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\School\Models\Teacher;

class TeacherFactory extends Factory
{
    protected $model = Teacher::class;

    private static array $congoleseFirstNames = [
        'Jean-Pierre', 'Marie-Claire', 'Emmanuel', 'Félicité', 'Christophe',
        'Grâce', 'Thierry', 'Patience', 'Bernadette', 'Olivier',
        'Solange', 'Patrick', 'Jeannette', 'Didier', 'Agnès',
        'Franck', 'Claudette', 'Serge', 'Monique', 'Guy',
    ];

    private static array $congoleseLastNames = [
        'Muyika', 'Kabila', 'Tshisekedi', 'Lumumba', 'Mobutu',
        'Kasongo', 'Ngoy', 'Mwamba', 'Nkongolo', 'Mutombo',
        'Kalala', 'Mukeba', 'Ilunga', 'Kabeya', 'Kongolo',
        'Banza', 'Mwangi', 'Lukusa', 'Ntumba', 'Kabongo',
    ];

    private static array $specialties = [
        'Mathématiques', 'Sciences', 'Français', 'Histoire-Géographie',
        'Éducation physique', 'Anglais', 'Informatique', 'Chimie',
        'Physique', 'Biologie', 'Arts plastiques', 'Musique',
        'Philosophie', 'Éducation religieuse', 'Maternelle',
    ];

    public function definition(): array
    {
        $firstName = $this->faker->randomElement(self::$congoleseFirstNames);
        $lastName = $this->faker->randomElement(self::$congoleseLastNames);
        $specialty = $this->faker->randomElement(self::$specialties);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => strtolower(str_replace('-', '', $firstName)) . '.' . strtolower($lastName) . $this->faker->numberBetween(1, 99) . '@ecole-lumo.cd',
            'phone' => '+243 ' . $this->faker->numerify('## ### ####'),
            'specialty' => $specialty,
            'qualification' => $this->faker->randomElement(['Licence', 'Master', 'DESS', 'Doctorat', 'BEPEC', 'CAPEM']),
            'hired_at' => $this->faker->dateTimeBetween('-10 years', '-6 months'),
            'status' => $this->faker->randomElement(['active', 'active', 'active', 'inactive']),
            'subjects' => [$specialty, $this->faker->randomElement(self::$specialties)],
        ];
    }
}
