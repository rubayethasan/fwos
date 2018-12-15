<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Eparam]].
 *
 * @see Eparam
 */
class EparamQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Eparam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Eparam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
