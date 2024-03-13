<?php

namespace Database\Factories;

use App\Enums\ExpensesType;
use App\Models\Expense;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->randomElement(ExpensesType::class),
            'value' => $this->faker->randomFloat(2,10,1000),
            'description' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
