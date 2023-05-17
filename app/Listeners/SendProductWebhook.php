<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use Illuminate\Support\Facades\Http;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendProductWebhook
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProductCreated $event): void
    {
        $product = $event->product;

        // Prepare the webhook payload
        $payload = [
            'name' => $product->name,
            'code' => $product->code,
            'category_id' => $product->category_id,
            'price' => $product->price,
            'release_date' => $product->release_date,
            'tags' => $product->tags->pluck('name'),
        ];

         // Send the webhook request
         $response = Http::post('http://httpbin.org/post', $payload);

         // Handle the webhook response if needed
        if ($response->successful()) {
            $responseData = $response->json();
            // Display a success message
            echo 'Webhook request was successful: ' . json_encode($responseData) . PHP_EOL;
        } else {
           // Handle the request failure
            // You can check the status code, error message, etc.
            $statusCode = $response->status();
            $errorMessage = $response->body();
            echo 'Webhook request failed. Status Code: ' . $statusCode . ', Error Message: ' . $errorMessage . PHP_EOL;
        }
    }
}
