<?php

namespace backend\controllers;

use common\models\LoginForm;
use common\models\Works\Work;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionUrls(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Work::find(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('works', [
            'dataProvider' => $dataProvider
        ]);
    }
}
