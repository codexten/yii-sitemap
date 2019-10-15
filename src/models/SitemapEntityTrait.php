<?php


namespace codexten\yii\sitemap\models;


trait SitemapEntityTrait
{
    /**
     * @inheritdoc
     */
    public function getSitemapLastmod()
    {
        return date('c');
    }

    /**
     * @inheritdoc
     */
    public function getSitemapChangefreq()
    {
        return 'daily';
    }

    /**
     * @inheritdoc
     */
    public function getSitemapPriority()
    {
        return 0.5;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc()
    {
        return $this->getUrl();
    }

    /**
     * @inheritdoc
     */
    public static function getSitemapDataSource()
    {
        return self::find();
    }
}