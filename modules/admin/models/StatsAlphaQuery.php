<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Statsalpha]].
 *
 * @see Statsalpha
 */
class StatsAlphaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Statsalpha[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Statsalpha|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
