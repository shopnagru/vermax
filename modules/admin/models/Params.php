<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "params".
 *
 * @property integer $id
 * @property integer $conf
 * @property string $name
 * @property string $value
 * @property string $comment
 */
class Params extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public $type;
    public static function tableName()
    {
        return 'params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf'], 'integer'],
            [[ 'name','type', 'value', 'comment'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conf' => 'Имя конфигурации',
            'type' => 'Тип конфигурации',
            'name' => 'Имя параметра',
            'value' => 'Значение параметра',
            'comment' => 'Комментарий',
        ];
    }

    public function getConf0()
    {
        return $this->hasOne(Configs::className(), ['id' => 'conf']);
    }



    /**
     * @inheritdoc
     * @return ParamsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ParamsQuery(get_called_class());
    }
}
