<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Statsalpha */

$this->title = 'Create Statsalpha';
$this->params['breadcrumbs'][] = ['label' => 'Statsalphas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="statsalpha-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
