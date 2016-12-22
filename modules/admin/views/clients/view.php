<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Clients */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить клиента?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('К списку', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'mac',
            'ip',

            [
                'attribute' => 'conf',
                'format' => 'html',
                //'label' => 'Дата завершения',
                'value' => $model->getConf0()->one()->name,
            ],
            [
                'attribute' => 'setting',
                'format' => 'html',
                //'label' => 'Дата завершения',
                'value' => $model->getSetting0()->one()->name,
            ],
            [
                'attribute' => 'update',
                'format' => 'html',
                //'label' => 'Дата завершения',
                'value' => $model->getUpdate0()->one()->name,
            ],

            [
                'attribute' => 'firmware',
                'format' => 'html',
                //'label' => 'Дата завершения',
                'value' => $model->getFirmware0()->one()->name,
            ],
        ],
    ]) ?>

</div>
