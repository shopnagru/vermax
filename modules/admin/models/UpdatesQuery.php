<?php

namespace app\modules\admin\models;

/**
 * This is the ActiveQuery class for [[Updates]].
 *
 * @see Updates
 */
class UpdatesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Updates[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Updates|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
