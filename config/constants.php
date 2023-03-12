<?php
$asset = (PHP_SAPI === 'cli') ? false : asset('/');
$site = (PHP_SAPI === 'cli') ? false : url('/');
return [
        'smSite'                              => $site,
//admin slug and url
    'smAdminSlug'                         => 'admin',
    'smAdminUrl'                          => $site . '/admin/',
//pagination
    'smPagination'                        => 10,
    'smPaginationMedia'                   => 49,
    'smFrontPagination'                   => 10,
    'cachingTimeInMinutes'                => 10,
    'popupHideTimeInMinutes'              => 24 * 60,
    'popupHideTimeInMinutesForSubscriber' => 30 * 24 * 60,
//image upload directory and url
    'smUploadsDir'                        => 'uploads/',
    'smUploads'                           => $asset . 'uploads/',
    'smUploadsUrl'                        => $asset . 'uploads/',
     /*
    |--------------------------------------------------------------------------
    | App Constants
    |--------------------------------------------------------------------------
    |List of all constants for the app
    */

    'langs' => [
        'en' => ['full_name' => 'English', 'short_name' => 'English'],
        'es' => ['full_name' => 'Spanish - Español', 'short_name' => 'Spanish'],
        'sq' => ['full_name' => 'Albanian - Shqip', 'short_name' => 'Albanian'],
        'hi' => ['full_name' => 'Hindi - हिंदी', 'short_name' => 'Hindi'],
        'nl' => ['full_name' => 'Dutch', 'short_name' => 'Dutch'],
        'fr' => ['full_name' => 'French - Français', 'short_name' => 'French'],
        'de' => ['full_name' => 'German - Deutsch', 'short_name' => 'German'],
        'ar' => ['full_name' => 'Arabic - العَرَبِيَّة', 'short_name' => 'Arabic'],
        'tr' => ['full_name' => 'Turkish - Türkçe', 'short_name' => 'Turkish'],
        'id' => ['full_name' => 'Indonesian', 'short_name' => 'Indonesian'],
        'ps' => ['full_name' => 'Pashto', 'short_name' => 'Pashto'],
        'pt' => ['full_name' => 'Portuguese', 'short_name' => 'Portuguese'],
        'vi' => ['full_name' => 'Vietnamese', 'short_name' => 'Vietnamese'],
        'ce' => ['full_name' => 'Chinese', 'short_name' => ''],
        'ro' => ['full_name' => 'Romanian', 'short_name' => ''],
        'lo' => ['full_name' => 'Lao', 'short_name' => '']
    ],
    'langs_rtl' => ['ar'],
    'non_utf8_languages' => ['ar', 'hi', 'ps'],
    
    'document_size_limit' => '1000000', //in Bytes,
    'image_size_limit' => '500000', //in Bytes

    'asset_version' => 80,

    'disable_purchase_in_other_currency' => true,
    
    'iraqi_selling_price_adjustment' => false,

    'currency_precision' => 2, //Maximum 4
    'quantity_precision' => 2,  //Maximum 4

    'product_img_path' => 'img',

    'enable_sell_in_diff_currency' => false,
    'currency_exchange_rate' => 1,
    'orders_refresh_interval' => 600, //Auto refresh interval on Kitchen and Orders page in seconds,

    'default_date_format' => 'm/d/Y', //Default date format to be used if session is not set. All valid formats can be found on https://www.php.net/manual/en/function.date.php
    
    'new_notification_count_interval' => 60, //Interval to check for new notifications in seconds;Default is 60sec
    
    'administrator_usernames' => env('ADMINISTRATOR_USERNAMES'),
    'allow_registration' => env('ALLOW_REGISTRATION', true),
    'app_title' => env('APP_TITLE'),
    'mpdf_temp_path' => storage_path('app/pdf'), //Temporary path used by mpdf
    
    'document_upload_mimes_types' => ['application/pdf' => '.pdf',
        'text/csv' => '.csv',
        'application/zip' => '.zip',
        'application/msword' => '.doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '.docx',
        'image/jpeg' => '.jpeg',
        'image/jpg' => '.jpg',
        'image/png' => '.png'
        
    ], //List of MIME type: https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types
    'show_report_606' => false,
    'show_report_607' => false,

        'smPostMaxInMb'                       => 5,

//galary (600x400, 112x112 not crop resized)
    'smImgWidth'                          => [

        227, //order page signature
        112, //media
        600, //media big show
        30, //admin user image
        1920, //slider
        80, //admin table image view
        165, //admin select image view
        16, //fav icon
        190, //header logo
        622, //about home page
        110, //services home page
        20, //portfoilo category image
        337, //portfoilo home page
        670, //portfoilo details page Sliding
        1600, //portfoilo details page Hover View
        370, //team home page
        85, //testimonial home page
        75, //Clients home page
        1920, //breadcrumb
        370, // blog
        770, // blog details
        120, //blog rightsider bar
        70, //blog footer
        // 193,
        // 600,
        // 165,
        // 80,
        // 45,
        // 30,
        // 750,
        // 748,
        // 360,
        // 358,
        // 358,
        // 550,
        // 560,
        // 270,
        // 210,
        // 170,
        // 263,
        // -----------sumon
        // 200,
        // 550,
        // 100,
        // 81,
        // 1920,
        // 550,
        // 370,
        // 1920,
        // 770,
        // 95,
        // // portfolio page
        // 630,
        // // portfolio details
        // 1170

    ],
    'smImgHeight'                         => [
        42, //order page signature
        112,//media
        400,//media big show
        30, //admin user image
        932,//slider
        80, //admin image view
        165, //admin select image view
        16,//fav icon
        34,//header logo
        360, //about home page
        115, //services home page
        20, //portfoilo category image
        302, //portfoilo home page
        391, //portfoilo details page Sliding
        1200, //portfoilo details page Hover View
        400, //team home page
        85, //testimonial home page
        54, //Clients home page
        340, //breadcrumb
        280, // blog
        450, // blog details
        100, //blog rightsider bar
        70, //blog footer
        // 78,
        // 400,
        // 165,
        // 80,
        // 45,
        // 30,
        // 560,
        // 436,
        // 380,
        // 263,
        // 200,
        // 550,
        // 447,
        // 316,
        // 153,
        // 95,
        // 365,
        // -------------
        // 88,
        // 594,
        // 100,
        // 28,
        // 1210,
        // 600,
        // 280,
        // 340,
        // 450,
        // 95,
        // // portfolio page
        // 430,
        // // portfolio details
        // 624

    ],
];
