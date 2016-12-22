<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Configs */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Конфигурации', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configs-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы действительно хотите удалить эту конфигурацию?',
                'method' => 'post',
            ],
        ]) ?>
        
        <?= Html::a('Клонировать', ['createmodels', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

        <?= Html::a('Редактировать параметры', ['newparams', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('К списку', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'description',
            'type',
        ],
    ]) ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'conf',
            [
                'attribute'=>'conf',

                'filter' => ArrayHelper::map(\app\modules\admin\models\Configs::find()->all(),'id','name'),
                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                    return \yii\bootstrap\Html::a($data->getConf0()->one()->name, ['/admin/configs/view', 'id' => $data->getConf0()->one()->id]);


                },
            ],

            [
                'attribute'=>'type',

                'filter' => ['config'=>'config','update'=>'update','setting'=>'setting','firmware'=>'firmware'],

                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                    return $data->getConf0()->one()->type;


                },
            ],

            'name',
            'value',
            // 'comment',

            [
                'class' => \yii\grid\ActionColumn::className(),

                'urlCreator'=>function($action, $model, $key, $index){
                    return ['/admin/params/'.$action,'id'=>$model->id];
                },
                'template'=>'{view} {update}  {delete}',
            ]
        ],
    ]); ?>

</div>
