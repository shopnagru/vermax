<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Configs */

$this->title = 'Клонирование конфигурации';
$this->params['breadcrumbs'][] = ['label' => 'Конфигурация', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_clone', [
        'model' => $model,
    ]) ?>

</div>
