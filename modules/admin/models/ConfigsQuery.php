<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Configs]].
 *
 * @see Configs
 */
class ConfigsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Configs[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Configs|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
