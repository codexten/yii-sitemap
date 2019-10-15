<?php

namespace codexten\yii\sitemap\components;

use codexten\yii\web\UrlManager;

class Sitemap extends \zhelyabuzhsky\sitemap\components\Sitemap
{
    public $models = [];
    /**
     * @var UrlManager
     */
    public $urlManager;

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $this->sitemapDirectory = \Yii::getAlias($this->sitemapDirectory);
        parent::init();
    }

    /**
     * {@inheritDoc}
     */
    public function create()
    {
        foreach ($this->models as $model) {
            $this->addModel($model);
        }

        parent::create();
    }

    /**
     * Create index file sitemap.xml.
     */
    protected function createIndexFile()
    {
        $this->path = "{$this->sitemapDirectory}/_sitemap.xml";
        $this->handle = fopen($this->path, 'w');
        fwrite(
            $this->handle,
            '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL.
            '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'
        );
        $objDateTime = new \DateTime('NOW');
        $lastmod = $objDateTime->format(\DateTime::W3C);

        $baseUrl = \Yii::$app->urlManager->baseUrl;
        $hostInfo = \Yii::$app->urlManager->hostInfo;

        foreach ($this->generatedFiles as $fileName) {
            fwrite(
                $this->handle,
                PHP_EOL.
                '<sitemap>'.PHP_EOL.
                "\t".'<loc>'.$hostInfo.$baseUrl.'/'.$fileName.'.gz'.'</loc>'.PHP_EOL.
                "\t".'<lastmod>'.$lastmod.'</lastmod>'.PHP_EOL.
                '</sitemap>'
            );
        }
        fwrite($this->handle, PHP_EOL.'</sitemapindex>');
        fclose($this->handle);
        $this->gzipFile();
    }
}