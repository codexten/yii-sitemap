<?php

namespace codexten\yii\sitemap\console\controllers;

use Yii;
use yii\console\Controller;

class SitemapController extends Controller
{
    public function actionGenerate()
    {
        Yii::$app->sitemap
//            ->addModel(Business::className())
//            ->setDirectory('frontend/web/business')
//            ->addDataSource(
//                Business::find()
//                    ->andWhere(['>=', 'id', $start])
//                    ->andWhere(['<=', 'id', $end])->orderBy(['id' => SORT_ASC])
//            )
            ->create();
    }

}