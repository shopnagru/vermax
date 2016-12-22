<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Statsalpha */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Statsalphas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statsalpha-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('К списку', ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'date',
            'textplain:ntext',
            'stat_id',
            'details',
            'url:url',
            'channel',
            'time',
            'what',
            'extra',
            'status',
            'switch_count',
            'type',
            'mac',
            'ip',
            'send_date',
        ],
    ]) ?>

</div>
