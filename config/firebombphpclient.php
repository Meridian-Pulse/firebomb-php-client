<?php

return [
    // The API endpoint where exceptions will be sent
    'api_url' => env('FIREBOMB_API_URL', 'https://example.com/api/exceptions'),

    // The API key for authenticating requests
    'api_key' => env('FIREBOMB_API_KEY', 'your-default-api-key'),
];
