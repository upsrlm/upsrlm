<?php
return [
    'adminEmail' => 'admin@example.com',
    'page_size30'=>30,
    'bsVersion' => '4.x',
    'googleAnalytics' => [
        'developerKey' 		 => '', // Public key
        'clientId' 			 => '1017283435578-gjshs0aju3u5ufn6h5hue2vhq56pn2g3.apps.googleusercontent.com', // Client ID
        'analyticsId'        => 'ga:232409765', //(It is the number at the end of the URL starting with p: https://www.google.com/analytics/web/#home/a33443w112345pXXXXXXXX/)
        'serviceAccountName' => 'upsrlm-googleanalytics@single-cycling-301108.iam.gserviceaccount.com', // Email address
        'privateKeyPath'	 => __DIR__.'/single-cycling-301108-972e378850c1.p12', //path to private key in p12 format
    ],
];
