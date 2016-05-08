<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Third Party Services
	|--------------------------------------------------------------------------
	|
	| This file is for storing the credentials for third party services such
	| as Stripe, Mailgun, Mandrill, and others. This file provides a sane
	| default location for this type of information, allowing packages
	| to have a conventional place to find your various credentials.
	|
	*/
    'google' => [
        'client_id' => '772661298760-helk6dlad48v95ldh2k3fghkh51foe13.apps.googleusercontent.com',
        'client_secret' => 'pdEIKIbmTfoFPSlmpBFnSjQJ',
        'redirect' => env('OAUTH_URL').'/auth/callback/google'
    ],
    'twitter' => [
        'client_id' => 'lpgywM1w7ncTHUEXVkVRb2DFX',
        'client_secret' => 'essOKLJR26Kx0PI5UNA9PEJ91cKO3Ep6r06eg5iL1fhc2ukjDq',
        'redirect' => env('OAUTH_URL').'/auth/callback/twitter'
    ],
    'github' => [
        'client_id' => '6072f5c4775aacd8445e',
        'client_secret' => 'f50d00daa7e0b4aafb554a9a9ee35da197debb9f',
        'redirect' => env('OAUTH_URL').'/auth/callback/github'
    ],
];
