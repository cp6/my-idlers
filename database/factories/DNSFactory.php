<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DNSFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->bothify('???#??#?'),
            'dns_type' => $this->faker->shuffleArray(['A', 'AAA']),
            'value1' => $this->faker->shuffleArray(['dev', 'blog', 'panel']),
            'value2' => $this->faker->ipv4
        ];
    }
}
