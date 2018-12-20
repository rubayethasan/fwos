<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Gruppe]].
 *
 * @see Gruppe
 */
class GruppeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Gruppe[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Gruppe|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
