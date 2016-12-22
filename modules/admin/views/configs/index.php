<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\ConfigsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Конфигурации';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configs-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить конфигурацию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
          //  ['class' => 'yii\grid\SerialColumn'],

            //'id',

          [
              'attribute'=>'name',

                  'filter'=>  ArrayHelper::map(\app\modules\admin\models\Configs::find()->select('name')->distinct()->all(),'name','name'),


         'content' => function ($model, $key, $index, $column) {


                 return \yii\bootstrap\Html::a($model->name, '/admin/params?ParamsSearch%5Bconf%5D='.$model->id);
    },

          ],


            'description',
            [
                'attribute'=>'type',

                'filter' => ['config'=>'config','update'=>'update','setting'=>'setting','firmware'=>'firmware'],
                'content' => function ($model, $key, $index, $column) {


                    return \yii\bootstrap\Html::a($model->type, '/admin/params?ParamsSearch%5Btype%5D='.$model->type);
                },
            ],

            [
                'class' => \yii\grid\ActionColumn::className(),
                'buttons'=>[
                    'createmodels'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/admin/configs/createmodels','id'=>$model['id']]); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-apple"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Клонировать'), 'data-pjax' => '0']);
                    }
                ],
                'template'=>'{view} {createmodels} {update}  {delete}',
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
