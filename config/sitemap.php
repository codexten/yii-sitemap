<?php

use codexten\yii\sitemap\components\Sitemap;

/* @var $params array */

return [
    'components' => [
        'sitemap' => [
            'class' => Sitemap::class,
            'maxUrlsCountInFile' => 10000,
            'siteUrl' => '@siteUrl',
            'sitemapDirectory' => $params['sitemap.dir'],
            'models' => $params['sitemap.models'],
            'optionalAttributes' => ['changefreq', 'lastmod', 'priority'],
            'maxFileSize' => '10M',
        ],
    ],
];