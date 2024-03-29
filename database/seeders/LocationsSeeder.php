<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationsSeeder extends Seeder
{
    public function run()
    {//Note add any new locations at the bottom of the array
        $locations = [
            ['name' => 'My basement'],
            ['name' => 'Adelaide, Australia'],
            ['name' => 'Amsterdam, Netherlands'],
            ['name' => 'Atlanta, USA'],
            ['name' => 'Auckland, New Zealand'],
            ['name' => 'Bangkok, Thailand'],
            ['name' => 'Barcelona, Spain'],
            ['name' => 'Beijing, China'],
            ['name' => 'Bengaluru, India'],
            ['name' => 'Berlin, Germany'],
            ['name' => 'Brisbane, Australia'],
            ['name' => 'Brussels, Belgium'],
            ['name' => 'Bucharest, Romania'],
            ['name' => 'Buenos Aires, Argentina'],
            ['name' => 'Charlotte, USA'],
            ['name' => 'Chennai, India'],
            ['name' => 'Chicago, USA'],
            ['name' => 'Christchurch, New Zealand'],
            ['name' => 'Dallas, USA'],
            ['name' => 'Denver, USA'],
            ['name' => 'Dhaka, Bangladesh'],
            ['name' => 'Dublin, Ireland'],
            ['name' => 'Frankfurt, Germany'],
            ['name' => 'Hamburg, Germany'],
            ['name' => 'Helsinki, Finland'],
            ['name' => 'Hong Kong'],
            ['name' => 'Houston, USA'],
            ['name' => 'Istanbul, Turkey'],
            ['name' => 'Jakarta, Indonesia'],
            ['name' => 'Johannesburg, South Africa'],
            ['name' => 'Kansas City, USA'],
            ['name' => 'Kuala Lumpur, Malaysia'],
            ['name' => 'Kiev, Ukraine'],
            ['name' => 'Las Vegas, USA'],
            ['name' => 'London, United kingdom'],
            ['name' => 'Los Angeles, USA'],
            ['name' => 'Luxembourg'],
            ['name' => 'Lyon, France'],
            ['name' => 'Madrid, Spain'],
            ['name' => 'Manchester, United Kingdom'],
            ['name' => 'Melbourne, Australia'],
            ['name' => 'Mexico City, Mexico'],
            ['name' => 'Miami, USA'],
            ['name' => 'Milan, Italy'],
            ['name' => 'Montreal, Canada'],
            ['name' => 'Moscow, Russia'],
            ['name' => 'Mumbai, India'],
            ['name' => 'Munich, Germany'],
            ['name' => 'New Delhi, India'],
            ['name' => 'New Jersey, USA'],
            ['name' => 'New York, USA'],
            ['name' => 'Newcastle, United Kingdom'],
            ['name' => 'Nuremberg, Germany'],
            ['name' => 'Ogden, USA'],
            ['name' => 'Oslo, Norway'],
            ['name' => 'Paris, France'],
            ['name' => 'Perth, Australia'],
            ['name' => 'Phoenix, USA'],
            ['name' => 'Philadelphia, USA'],
            ['name' => 'Portland, USA'],
            ['name' => 'Riga, Latvia'],
            ['name' => 'Rome, Italy'],
            ['name' => 'Rotterdam, Netherlands'],
            ['name' => 'Salt Lake City, USA'],
            ['name' => 'San Diego, USA'],
            ['name' => 'San Francisco, USA'],
            ['name' => 'San Jose, USA'],
            ['name' => 'Seattle, USA'],
            ['name' => 'Seoul, South Korea'],
            ['name' => 'Shanghai, China'],
            ['name' => 'Silicon Valley, USA'],
            ['name' => 'Singapore'],
            ['name' => 'Sofia, Bulgaria'],
            ['name' => 'St Petersburg, Russia'],
            ['name' => 'Stockholm, Sweden'],
            ['name' => 'Sydney, Australia'],
            ['name' => 'Tampa, USA'],
            ['name' => 'Tokyo, Japan'],
            ['name' => 'Toronto, Canada'],
            ['name' => 'Vancouver, Canada'],
            ['name' => 'Warsaw, Poland'],
            ['name' => 'Washington, USA'],
            ['name' => 'Wellington, New Zealand'],
            ['name' => 'Zurich, Switzerland'],
            ['name' => 'Quebec, Canada'],
            ['name' => 'Kharkiv, Ukraine'],
            ['name' => 'Sao Paulo, Brazil'],
        ];

        DB::table('locations')->insert($locations);

    }
}
