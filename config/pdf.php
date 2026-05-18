<?php

declare(strict_types=1);

return [
    'mode' => 'utf-8',
    'format' => 'A4',
    'author' => 'Board Governance Portal',
    'subject' => '',
    'keywords' => '',
    'creator' => 'Laravel',
    'display_mode' => 'fullpage',
    'tempDir' => storage_path('app/temp'),
    'pdf_a' => false,
    'pdf_a_auto_undo' => false,
    'font_path' => base_path('resources/fonts/'),
    'font_data' => [
        'tajawal' => [
            'R' => 'Tajawal-Regular.ttf',
            'B' => 'Tajawal-Bold.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        // Additional fonts can be added here
    ],
    'auto_script_to_lang' => true,
    'auto_lang_to_font' => true,
    'allow_charset_conversion' => false,
    'custom_font_dir' => base_path('resources/fonts/'),
    'custom_font_data' => [
        'tajawal' => [
            'R' => 'Tajawal-Regular.ttf',
            'B' => 'Tajawal-Bold.ttf',
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
    ],
    'auto_otf' => true,
    'direction' => 'rtl',
];
