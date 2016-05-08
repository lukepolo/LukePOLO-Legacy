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
        'client_id' => env('GOOGLE_CLIENT'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('OAUTH_URL').'/auth/callback/google'
    ],
    'twitter' => [
        'client_id' => env('TWITTER_CLIENT'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect' => env('OAUTH_URL').'/auth/callback/twitter'
    ],
    'github' => [
        'client_id' => env('GITHUB_CLIENT'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('OAUTH_URL').'/auth/callback/github'
    ],
];
