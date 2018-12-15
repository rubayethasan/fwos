<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Evaluierung]].
 *
 * @see Evaluierung
 */
class EvaluierungQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Evaluierung[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Evaluierung|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
