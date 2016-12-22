<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'name',
            'mac',
            'ip',

            [
                'attribute'=>'conf',

                'filter' => ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'config'])->all(),'id','name'),
                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                    return $data->getConf0()->one()->name;


                },
            ],
            [
                'attribute'=>'setting',

                'filter' => ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'setting'])->all(),'id','name'),
                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                    return $data->getSetting0()->one()->name;


                },
            ],

             //'update',

            [
                'attribute'=>'update',

                'filter' => ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'update'])->all(),'id','name'),
                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                    return $data->getUpdate0()->one()->name;


                },
            ],


             //'firmware',

            [
                'attribute'=>'firmware',

                'filter' => ArrayHelper::map(\app\modules\admin\models\Configs::find()->where(['type'=>'firmware'])->all(),'id','name'),
                'content'=>function($data){
                    //return \app\models\Street::find()->where(['id'=>$data->street])->one()->street;

                        return $data->getFirmware0()->one()->name;


                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
