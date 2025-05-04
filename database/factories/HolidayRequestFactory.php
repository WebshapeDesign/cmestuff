<?php

namespace Database\Factories;

use App\Models\HolidayRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class HolidayRequestFactory extends Factory
{
    protected $model = HolidayRequest::class;

    public function definition()
    {
        $startDate = Carbon::now()->addDays(rand(1, 30));
        $endDate = $startDate->copy()->addDays(rand(1, 14));
        
        return [
            'user_id' => User::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days_requested' => $startDate->diffInDays($endDate) + 1,
            'status' => $this->faker->randomElement(['pending', 'approved', 'denied']),
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
            ];
        });
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
            ];
        });
    }

    public function denied()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'denied',
            ];
        });
    }
} 