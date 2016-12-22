<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Clients */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mac')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'conf')->dropDownList(ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'config'])->all(),'id','name')); ?>

    <?= $form->field($model, 'setting')->dropDownList(ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'setting'])->all(),'id','name')); ?>

    <?= $form->field($model, 'update')->dropDownList(ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'update'])->all(),'id','name')); ?>

    <?= $form->field($model, 'firmware')->dropDownList(ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'firmware'])->all(),'id','name')); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Добавить' : 'Обновить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
