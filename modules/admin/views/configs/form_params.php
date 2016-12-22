<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\modules\admin\models\Params */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="col-md-12">
        <div class="form-group field-params-conf col-md-2">
            <label class="control-label" for="params-conf">Имя конфигурации</label>

            <select class="form-control" name="Params[conf][<?php echo $model->id; ?>]">
                <?php foreach ($configs as $conf): ?>
                <option value="<?php echo $conf->id; ?>" <?php if($conf->id == $model->conf){echo "selected";} ?>><?php echo $conf->name; ?></option>
                <?php endforeach;?>
            </select>


            <div class="help-block"></div>
        </div>



        <div class="form-group field-params-name col-md-4">
            <label class="control-label" for="params-name">Имя параметра</label>
            <input type="text"  class="form-control" name="Params[name][<?php echo $model->id; ?>]" value="<?php echo $model->name; ?>" maxlength="255">

            <div class="help-block"></div>
        </div>
        <div class="form-group field-params-value col-md-3">
            <label class="control-label" for="params-value">Значение параметра</label>
            <textarea class="form-control" name="Params[value][<?php echo $model->id; ?>]" maxlength="255"><?php echo $model->value; ?></textarea>

            <div class="help-block"></div>
        </div>
        <div class="form-group field-params-comment col-md-3">
            <label class="control-label" for="params-comment">Комментарий</label>
            <textarea  class="form-control" name="Params[comment][<?php echo $model->id; ?>]" maxlength="255"><?php echo $model->comment; ?></textarea>

            <div class="help-block"></div>
        </div>

</div>