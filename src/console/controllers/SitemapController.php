<?php

namespace codexten\yii\sitemap\console\controllers;

use Yii;
use yii\console\Controller;

class SitemapController extends Controller
{
    public function actionGenerate()
    {
        Yii::$app->sitemap
            ->create();
    }

}