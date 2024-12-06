<?php

namespace backend\controllers;

use common\models\Works\Work;
use common\models\Works\WorkLog;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

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

    public function actionLogs(): string
    {
        $dataProvider = new ActiveDataProvider([
            'query' => WorkLog::find()->orderBy(['id' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);
        return $this->render('logs', [
            'dataProvider' => $dataProvider
        ]);
    }
}
