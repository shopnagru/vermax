<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Firmwares]].
 *
 * @see Firmwares
 */
class FirmwaresQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Firmwares[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Firmwares|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
