<?php

return [
    'meta'      => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults'       => [
            'title'        => null,
            'description'  => env('APP_NAME').' - View our description, services, features, loans, remittance, types of accounts and galleries. Contact us at any time through the contact form. Also see our blogs, news, achievement history, portfolio, etc.',
            'separator'    => ' - ',
            'keywords'     => [],
            'canonical'    => env('APP_URL'), // Set null for using Url::current(), set false to total remove
        ],

        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google'    => null,
            'bing'      => null,
            'alexa'     => null,
            'pinterest' => null,
            'yandex'    => null,
        ],
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title'        => null,
            'description' =>env('APP_NAME').' - View our description, services, features, loans, remittance, types of accounts and galleries. Contact us at any time through the contact form. Also see our blogs, news, achievement history, portfolio, etc.',
            'url'         => env('APP_URL'), // Set null for using Url::current(), set false to total remove
            'type'        => 'online-examination',
            'site_name'   => env('APP_NAME'),
            'images'      => [],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
          //'card'        => 'summary',
          //'site'        => '@LuizVinicius73',
        ],
    ],
];
