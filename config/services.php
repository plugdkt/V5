<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | UP Azure AD / Microsoft 365 SSO (ขอ credentials จาก CITCOMS)
    |--------------------------------------------------------------------------
    */
    'azure' => [
        'client_id'     => env('AZURE_CLIENT_ID'),
        'client_secret' => env('AZURE_CLIENT_SECRET'),
        'redirect'      => env('AZURE_REDIRECT_URI', '/auth/callback'),
        'tenant'        => env('AZURE_TENANT_ID', 'common'),
        'proxy'         => null,
    ],

    'sso' => [
        'mock' => env('SSO_MOCK', false),
    ],

    // Faculty central SSO (MEDSCI ACC)
    'medsci_sso' => [
        'login_url'     => env('MEDSCI_SSO_LOGIN_URL', 'https://www.medsci.up.ac.th/msc_acc/sso/login.php'),
        'logout_url'    => env('MEDSCI_SSO_LOGOUT_URL', 'https://www.medsci.up.ac.th/msc_acc/sso/logout.php'),
        'verify_url'    => env('MEDSCI_SSO_VERIFY_URL', 'https://www.medsci.up.ac.th/msc_acc/api/verify.php'),
        'client_id'     => env('MEDSCI_SSO_CLIENT_ID', 'MSC_V5'),
        'client_secret' => env('MEDSCI_SSO_CLIENT_SECRET'),
        // keep false only until the server trusts the CA bundle; true is recommended
        'verify_ssl'    => env('MEDSCI_SSO_VERIFY_SSL', false),
    ],

    'tinymce' => [
        'api_key' => env('TINYMCE_API_KEY', 'no-api-key'),
    ],

];
