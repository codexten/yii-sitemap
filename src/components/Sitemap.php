<?php

namespace codexten\yii\sitemap\components;

use codexten\yii\web\UrlManager;
use zhelyabuzhsky\sitemap\models\SitemapEntityInterface;
use yii\base\Component;
use yii\base\Exception;


class Sitemap extends \zhelyabuzhsky\sitemap\components\Sitemap
{
    public $siteUrl;
    public $models = [];
    public $entities = [];
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
        $this->siteUrl = \Yii::getAlias($this->siteUrl);

        parent::init();
    }

    /**
     * Create sitemap file.
     */
    public function create()
    {
        foreach ($this->models as $model) {
            $this->addModel($model);
        }

        $this->fileIndex = 0;
        $this->beginFile();

        foreach ($this->dataSources as $dataSource) {
            /** @var ActiveQuery $query */
            $query = $dataSource['query'];
            /** @var Connection $connection */
            $connection = $dataSource['connection'];
            foreach ($query->batch(100, $connection) as $entities) {
                foreach ($entities as $entity) {
                    if (!$this->isDisallowUrl($entity->getSitemapLoc())) {
                        $this->writeEntity($entity);
                    }
                }
            }
        }

        foreach ($this->entities as $entity) {
            $this->writeEntity($entity);
        }

        if (is_resource($this->handle)) {
            $this->closeFile();
            $this->gzipFile();
        }

        $this->createIndexFile();
        $this->updateSitemaps();
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


        foreach ($this->generatedFiles as $fileName) {
            fwrite(
                $this->handle,
                PHP_EOL.
                '<sitemap>'.PHP_EOL.
                "\t".'<loc>'.$this->siteUrl.'/'.$fileName.'.gz'.'</loc>'.PHP_EOL.
                "\t".'<lastmod>'.$lastmod.'</lastmod>'.PHP_EOL.
                '</sitemap>'
            );
        }
        fwrite($this->handle, PHP_EOL.'</sitemapindex>');
        fclose($this->handle);
        $this->gzipFile();
    }

    /**
     * Write entity to sitemap file.
     *
     * @param  SitemapEntityInterface|array  $entity
     */
    protected function writeEntity($entity)
    {
        $str = PHP_EOL.'<url>'.PHP_EOL;

        foreach (
            array_merge(
                ['loc'],
                $this->optionalAttributes
            ) as $attribute
        ) {
            $attributeValue = is_array($entity) ? $entity[$attribute] : call_user_func([
                $entity,
                'getSitemap'.$attribute,
            ]);

            $str .= sprintf("\t<%s>%s</%1\$s>", $attribute, $attributeValue).PHP_EOL;
        }

        $str .= '</url>';

        if ($this->isLimitExceeded(strlen($str))) {
            $this->closeFile();
            $this->gzipFile();
            $this->beginFile();
        }

        fwrite($this->handle, $str);
        ++$this->urlCount;
    }
}