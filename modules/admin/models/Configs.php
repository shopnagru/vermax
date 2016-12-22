<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "configs".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $type
 *
 * @property Clients[] $clients
 * @property Clients[] $clients0
 * @property Clients[] $clients1
 * @property Clients[] $clients2
 * @property Params[] $params
 */
class Configs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'unique', 'targetAttribute' => 'name'],
            [['type'], 'required'],
            [['type'], 'string'],
            [['name', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание',
            'type' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['firmware' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients0()
    {
        return $this->hasMany(Clients::className(), ['conf' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients1()
    {
        return $this->hasMany(Clients::className(), ['setting' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients2()
    {
        return $this->hasMany(Clients::className(), ['update' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParams()
    {
        return $this->hasMany(Params::className(), ['conf' => 'id']);
    }

    /**
     * @inheritdoc
     * @return ConfigsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfigsQuery(get_called_class());
    }
}
