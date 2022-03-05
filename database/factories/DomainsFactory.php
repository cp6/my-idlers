<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DomainsFactory extends Factory
{
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->bothify('???#??#?'),
            'domain' => $this->faker->domainWord,
            'extension' => 'com',
            'ns1' => null,
            'ns2' => null,
            'ns3' => null,
            'provider_id' => $this->faker->numberBetween(1, 27),
            'label' => null,
            'price' => 9.99,
            'currency' => 'USD',
            'payment_term' => 4,
            'owned_since' => $this->faker->dateTimeThisDecade,
            'next_due_date' => date('Y-m-d',strtotime('+130 days',strtotime(str_replace('/', '-', date("Y-m-d")))))
        ];
    }
}
