<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\datetime\DateTimePicker;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\RequestsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Запросы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="requests-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>

    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'ip',
            'mac',
            'version',
            'fw',
            'type',
             //'response',
            [
                'class' => \yii\grid\ActionColumn::className(),


                'template'=>'{view}',
            ],
            [
                'attribute' => 'time',
                'value' => 'time',
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'time',
                    'language' => 'ru',
                    'pluginOptions' => [

                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:i:ss',
                        'todayHighlight' => true
                    ]
                ]),

            ],

            [
                'attribute' => 'time2',
                'value' => 'time2',
                'filter' => DateTimePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'time2',
                    'language' => 'ru',
                    'pluginOptions' => [

                        'autoclose' => true,
                        'format' => 'yyyy-mm-dd hh:i:ss',
                        'todayHighlight' => true
                    ]
                ]),

            ],


        ],
    ]); ?>
<?php Pjax::end(); ?></div>
