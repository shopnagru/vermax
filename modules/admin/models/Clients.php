<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "clients".
 *
 * @property integer $id
 * @property string $name
 * @property string $mac
 * @property string $ip
 * @property integer $conf
 * @property integer $setting
 * @property integer $update
 * @property integer $firmware
 *
 * @property Configs $conf0
 * @property Settings $setting0
 * @property Updates $update0
 * @property Firmwares $firmware0
 */
class Clients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conf', 'setting', 'update', 'firmware'], 'integer'],
            [['name', 'mac', 'ip'], 'string', 'max' => 255],

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
            'mac' => 'Mac',
            'ip' => 'Ip',
            'conf' => 'Конфигурация',
            'setting' => 'Настройки',
            'update' => 'Обновления плеера',
            'firmware' => 'Прошивки',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConf0()
    {
        return $this->hasOne(Configs::className(), ['id' => 'conf']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSetting0()
    {
        return $this->hasOne(Configs::className(), ['id' => 'setting']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdate0()
    {
        return $this->hasOne(Configs::className(), ['id' => 'update']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFirmware0()
    {
        return $this->hasOne(Configs::className(), ['id' => 'firmware']);
    }

    /**
     * @inheritdoc
     * @return ClientsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ClientsQuery(get_called_class());
    }
}
