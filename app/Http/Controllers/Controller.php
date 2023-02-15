<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function checkConnection() {
        try {
            $response = Http::get('https://undangankuu.com');
            // Check for a successful response code (e.g. 200)
            if ($response->ok()) {
                // API is reachable and working
                echo "API connection successful!";
            } else {
                // API is reachable, but returned an error status code
                echo "API returned an error status code: " . $response->status();
            }
        } catch (\Exception $e) {
            // API is unreachable or returned an error
            echo "API connection failed: " . $e->getMessage();
        }
    }
}
