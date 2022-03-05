<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Server::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $ram = $this->faker->numberBetween(512, 4086);
        $disk = $this->faker->numberBetween(5, 120);
        return [
            'id' => $this->faker->unique()->bothify('???#??#?'),
            'hostname' => $this->faker->domainName,
            'ipv4' => $this->faker->ipv4,
            'ipv6' => $this->faker->ipv6,
            'server_type' => $this->faker->numberBetween(1, 4),
            'ns1' => null,
            'ns2' => null,
            'os_id' => $this->faker->numberBetween(1, 27),
            'provider_id' => $this->faker->numberBetween(1, 27),
            'location_id' => $this->faker->numberBetween(1, 28),
            'label' => null,
            //'price' => $this->faker->randomFloat(2, 2.50, 30.00),
            //'currency' => 'USD',
            //'payment_term' => 1,
            'ram' => $ram,
            'ram_as_mb' => $ram,
            'disk' => $disk,
            'disk_as_gb' => $disk,
            'bandwidth' => $this->faker->numberBetween(100, 999),
            'owned_since' => $this->faker->dateTimeThisDecade,
            //'next_due_date' => date('Y-m-d',strtotime('+30 days',strtotime(str_replace('/', '-', date("Y-m-d")))))
        ];
    }

}
