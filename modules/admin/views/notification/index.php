<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\NotificationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="notification-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить сообщение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'message:ntext',
            'mac',
            'ip',

            [
                'attribute'=>'all',
                'filter' => [0=>'Нет',1=>'Да'],
                'content'=>function($model, $key, $index, $column){
                    return $model->{$column->attribute} ? 'Да' : 'Нет';
                },
            ],
            // 'date',
            [
                'class' => \yii\grid\ActionColumn::className(),
                'buttons'=>[
                    'clone'=>function ($url, $model) {
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/admin/notification/clone','id'=>$model['id']]); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-apple"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Клонировать'), 'data-pjax' => '0']);
                    }
                ],
                'template'=>'{view} {clone} {update}  {delete}',
            ]

        ],
    ]); ?>
<?php Pjax::end(); ?></div>
