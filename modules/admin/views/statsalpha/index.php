<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\admin\models\StatsalphaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statsalpha-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'date',
           //'textplain:ntext',

            [
                'attribute'=>'textplain',
                'content' => function ($model, $key, $index, $column) {
                            $json = json_decode($model->{$column->attribute},1);

                            $val ='';
                            foreach ($json as $k=>$v){
                                if($k == 'date'){
                                    $v = date('Y-m-d H:i:s',strtotime($v));
                                }
                                $val .= $k.'=>'.$v."<br>";
                            }
                    return $val;
                },
            ],
            //'stat_id',
            //'details',
             //'url:url',
             'channel',
             'time',
            // 'what',
            // 'extra',
            // 'status',
            'switch_count',
            //'type',
            [
                'attribute'=>'type',
                'filter'=>  ArrayHelper::map(\app\modules\admin\models\Statsalpha::find()->select('type')->distinct()->all(),'type','type'),
    ],
            // 'mac',
           'ip',
            // 'send_date',

            [
                'class' => \yii\grid\ActionColumn::className(),


                'template'=>'{view}',
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
