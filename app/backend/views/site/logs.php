<?php
declare(strict_types=1);


use common\models\WorkLogs\WorkLog;
use yii\data\ActiveDataProvider;

/* @var ActiveDataProvider $dataProvider */

?>

<?=
\yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'work_id',
        [
            'label' => 'Url',
            'content' => function ($model) {
                /* @var WorkLog $model */
                return $model->getWork()?->getExtendedEntity()?->getDetails()['url'] ?? null;
            }
        ],
        'date_created',
        'state',
        'attempt_number',
        'error_data',
        [
            'label' => 'Response code',
            'content' => function ($model) {
                /* @var WorkLog $model */
                return $model->getDetailsInstance()->response_code ?? null;
            }
        ],
        [
            'label' => 'Response body',
            'content' => function ($model) {
                /* @var WorkLog $model */
                $content = $model->getDetailsInstance()?->response_body ?? '';
                $content = mb_strlen($content) > 100 ? mb_substr($content, 0, 100) . '...' : $content;
                return htmlspecialchars($content);
            }
        ],
    ]
]);
?>
