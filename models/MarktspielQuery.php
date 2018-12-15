<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Marktspiel]].
 *
 * @see Marktspiel
 */
class MarktspielQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Marktspiel[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Marktspiel|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
