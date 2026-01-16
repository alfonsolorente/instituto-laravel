<?php

namespace Database\Factories;

use App\Models\Alumno;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlumnoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Alumno::class;

    /**
     * Define el estado predeterminado del modelo Alumno.
     * Utiliza Faker para generar datos realistas aleatorios.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->firstName(),
            'apellidos' => fake()->lastName() . ' ' . fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'dni' => fake()->unique()->numerify('########') . fake()->randomLetter(),
            'f_nac' => fake()->dateTimeBetween('-25 years', '-18 years'),
        ];
    }
}
