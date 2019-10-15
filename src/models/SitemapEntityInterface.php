<?php

namespace codexten\yii\sitemap\models;

interface SitemapEntityInterface extends \zhelyabuzhsky\sitemap\models\SitemapEntityInterface
{
    /**
     * @return string
     */
    public function getUrl();

}