<?php

use codexten\yii\sitemap\components\Sitemap;

return [
    'components' => [
        'sitemap' => [
            'class' => Sitemap::class,
            'maxUrlsCountInFile' => 10000,
            'sitemapDirectory' => 'frontend/web',
            'optionalAttributes' => ['changefreq', 'lastmod', 'priority'],
            'maxFileSize' => '10M',
        ],
    ],
];