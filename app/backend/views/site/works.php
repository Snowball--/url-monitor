<?php
declare(strict_types=1);


use common\models\Works\Work;
use yii\data\ActiveDataProvider;

/* @var ActiveDataProvider $dataProvider */

?>

<?=
    \yii\grid\GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'type',
            [
                'label' => 'Url',
                'content' => function ($model) {
                    /* @var Work $model */
                    return $model->getExtendedEntity()?->getDetails()['url'] ?? null;
                }
            ],
            'frequency',
            'on_error_repeat_count',
            'on_error_repeat_delay',
            'date_created',
            'is_active'
        ]
    ]);
?>
