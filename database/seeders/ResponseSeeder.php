<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Response;

class ResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $question = "How did you like the restaurant?";

        $responses = [
            // Good reviews
            "Absolutely loved it! The food was amazing.",
            "Great experience, will definitely come back!",
            "The service was excellent and the food was delicious.",
            "Fantastic! Best meal I've had in months.",
            
            // Medium reviews
            "It was okay, nothing special but decent.",
            "Pretty good, though a bit pricey for what it was.",
            "Food was fine, service could be better.",
            
            // Bad reviews
            "Not impressed. The food was cold and bland.",
            "Disappointing. Long wait times and mediocre food.",
            "Would not recommend. Overpriced and underwhelming.",
        ];

        foreach ($responses as $response) {
            Response::create([
                'question' => $question,
                'response' => $response,
            ]);
        }
    }
}

