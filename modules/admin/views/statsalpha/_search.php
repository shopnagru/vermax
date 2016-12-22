<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\StatsalphaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="statsalpha-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'textplain') ?>

    <?= $form->field($model, 'stat_id') ?>

    <?= $form->field($model, 'details') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'channel') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'what') ?>

    <?php // echo $form->field($model, 'extra') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'switch_count') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'mac') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'send_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
