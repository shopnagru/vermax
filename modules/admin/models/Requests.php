<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "requests_monitor".
 *
 * @property integer $id
 * @property string $ip
 * @property string $mac
 * @property string $version
 * @property string $fw
 * @property string $type
 * @property string $response
 * @property string $time
 */
class Requests extends \yii\db\ActiveRecord
{

    public $time2 = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'requests_monitor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time','time2'], 'safe'],
            [[ 'response'], 'text'],
            [['ip', 'mac', 'version', 'fw', 'type'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'mac' => 'Mac',
            'version' => 'Версия плеера',
            'fw' => 'Версия прошивки',
            'type' => 'Тип запроса',
            'response' => 'Ответ',
            'time' => 'от',
            'time2' => 'до',
        ];
    }

    /**
     * @inheritdoc
     * @return RequestsMonitorQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RequestsMonitorQuery(get_called_class());
    }
}
