<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "stat".
 *
 * @property integer $id
 * @property string $date
 * @property string $textplain
 * @property string $stat_id
 * @property string $details
 * @property string $url
 * @property string $channel
 * @property string $time
 * @property string $what
 * @property string $extra
 * @property string $status
 * @property string $switch_count
 * @property string $type
 * @property string $mac
 * @property string $ip
 * @property string $send_date
 */
class Statsalpha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'stat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['textplain'], 'string'],
            [['mac', 'ip', 'send_date'], 'required'],
            [['stat_id', 'details', 'url', 'channel', 'time', 'what', 'extra', 'status', 'switch_count'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 150],
            [['mac', 'send_date'], 'string', 'max' => 100],
            [['ip'], 'string', 'max' => 15],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Дата',
            'textplain' => 'Текст',
            'stat_id' => 'Stat ID',
            'details' => 'Details',
            'url' => 'Url',
            'channel' => 'Канал',
            'time' => 'Время',
            'what' => 'What',
            'extra' => 'Extra',
            'status' => 'Статус',
            'switch_count' => 'Switch Count',
            'type' => 'Тип',
            'mac' => 'Mac',
            'ip' => 'Ip',
            'send_date' => 'Send Date',
        ];
    }

    /**
     * @inheritdoc
     * @return StatsAlphaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new StatsAlphaQuery(get_called_class());
    }
}
