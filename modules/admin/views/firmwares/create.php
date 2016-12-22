<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Firmwares */

$this->title = 'Добавить прошивку';
$this->params['breadcrumbs'][] = ['label' => 'Прошивки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firmwares-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
