<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="post">
    <h2><?= Html::encode($model->name) ?></h2>

    <?= HtmlPurifier::process($model->name) ?>
</div>