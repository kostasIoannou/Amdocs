<?php

namespace App\Listeners;

use App\Events\ProductUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class SendUpdateProductWebhook
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
    public function handle(ProductUpdated $event): void
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
        
        // Send the PUT request to the webhook URL
        $response = Http::put('http://httpbin.org/put', $payload);

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
