<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var frontend\models\Form\AddUrlMonitorWorkForm $model */
/** @var ActiveForm $form */
?>

<div class="container">

    <?php $form = ActiveForm::begin([
            'layout' => 'horizontal'

    ]); ?>

        <?= $form->field($model, 'url') ?>
        <?= $form->field($model, 'frequency') ?>
        <?= $form->field($model, 'onErrorRepeatCount') ?>
        <?= $form->field($model, 'onErrorRepeatDelay') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- url_monitor_form -->
