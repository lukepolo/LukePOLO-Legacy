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

	'mailgun' => [
		'domain' => '',
		'secret' => '',
	],

	'mandrill' => [
		'secret' => '',
	],

	'ses' => [
		'key' => '',
		'secret' => '',
		'region' => 'us-east-1',
	],

	'stripe' => [
		'model'  => 'User',
		'secret' => '',
	],

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
    'linkedin' => [
        'client_id' => '759xb8vfxo4lie',
        'client_secret' => 'JoIP0eNFNNmjCrnq',
        'redirect' => env('OAUTH_URL').'/auth/callback/linkedin'
    ],
    'facebook' => [
        'client_id' => '895876067125328',
        'client_secret' => '8f984f54cd785725127b513b3075b905',
        'redirect' => env('OAUTH_URL').'/auth/callback/facebook'
    ],
    'reddit' => [
        'client_id' => 'rXVCgPea5w5OtA',
        'client_secret' =>'rsVpR7_iv5vJM6PpG6qZhReyWsc',
        'redirect' => env('OAUTH_URL').'/auth/callback/reddit'
    ],
];
