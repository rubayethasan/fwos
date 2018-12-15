<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Benutzer]].
 *
 * @see Benutzer
 */
class BenutzerQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Benutzer[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Benutzer|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
