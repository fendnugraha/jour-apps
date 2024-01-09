<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['Client', 'Supplier', 'Vendor']), // Example types
            'description' => $this->faker->sentence,
            // Add more fields and faker methods as needed
        ];
    }
}
