<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Measure;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var Generator
     */
    protected $faker;

    private $startCoordinates = [
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
        [
            "latitude" => 48.65946355650771,
            "longitude" => 6.188320691041134,
        ],
    ];

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Get a new Faker instance.
     *
     * @return Generator
     * @throws BindingResolutionException
     */
    protected function withFaker(): Generator
    {
        return Container::getInstance()->make(Generator::class);
    }

    private function changeDistance($distance): float
    {
        $distanceRatioInterval = 0.5;
        return $this->faker->randomFloat(3, $distance - $distance * $distanceRatioInterval, $distance + $distance * $distanceRatioInterval);;
    }

    private function changeAngle($angle): float
    {
        $angleRatioInterval = 0.5;
        dump($this->faker->randomFloat(3, $angle - $angle * $angleRatioInterval, $angle + $angle * $angleRatioInterval));
        return $this->faker->randomFloat(3, $angle - $angle * $angleRatioInterval, $angle + $angle * $angleRatioInterval);
    }

    /**
     * Translate given coordinates by given distance and angle
     *
     * @param array $coordinates
     * @param int $distance
     * @param int $angle
     * @return array|float[]|int[]
     */
    private function translateCoordinates(array $coordinates, int $distance, int $angle): array
    {
        $dx = $distance * sin(deg2rad($angle));
        $dy = $distance * cos(deg2rad($angle));

        $latitude = $coordinates['latitude'] + (180 / pi()) * ($dy / 6378137);
        $longitude = $coordinates['longitude'] + (180 / pi()) * ($dx / 6378137) / cos($coordinates['latitude']);

        return ['latitude' => $latitude, 'longitude' => $longitude];
    }


    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $groups = Group::factory(count($this->startCoordinates))
            ->create();

        for ($i = 0; $i < count($groups); $i++) {
            $coordinates = $this->startCoordinates[$i];
            $startDate = new Carbon($groups[$i]->start);
            $endDate = new Carbon($groups[$i]->end);
            $period = $groups[$i]->period;

            $distance = 5;
            $angle = 45;

            while ($startDate < $endDate) {
                $measure = Measure::create([
                    'group_id' => $groups[$i]->id,
                    'values' => [
                        "latitude" => $coordinates['latitude'],
                        "longitude" => $coordinates['longitude'],
                        "temperature" => [
                            "value" => $this->faker->numberBetween(-10, 100),
                            "unit" => "°C",
                        ],
                        "humidité" => [
                            "value" => $this->faker->numberBetween(0, 100),
                            "unit" => "%",
                        ],
                    ],
                    'created_at' => $startDate,
                    'updated_at' => $startDate,
                ]);
                $distance = $this->changeDistance($distance);
                $angle = $this->changeAngle($angle);
                $coordinates = $this->translateCoordinates($coordinates, $distance, $angle);
                $startDate->addSeconds($period);
            }
        }
    }
}
