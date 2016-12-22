<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ParamsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Параметры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="params-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить параметр', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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


            'name',

            [
                'attribute'=>'type',

                'filter' => ['config'=>'config','update'=>'update','setting'=>'setting','firmware'=>'firmware'],

                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                    return $data->getConf0()->one()->type;


                },
            ],
            'value',
            // 'comment',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
