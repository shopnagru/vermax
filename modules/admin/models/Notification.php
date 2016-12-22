<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property string $message
 * @property string $mac
 * @property string $ip
 * @property integer $all
 * @property string $date
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message'], 'required'],
            [['message'], 'string'],
            [['all'], 'integer'],
            [['date'], 'safe'],
            [['mac', 'ip'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message' => 'Сообщение',
            'mac' => 'Mac',
            'ip' => 'Ip',
            'all' => 'Всем',
            'date' => 'Дата',
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }
}
