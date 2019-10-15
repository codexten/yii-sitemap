<?php

namespace codexten\yii\sitemap\components;

class Sitemap extends \zhelyabuzhsky\sitemap\components\Sitemap
{
    public $models = [];

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
}