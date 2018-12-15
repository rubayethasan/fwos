<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Questionset]].
 *
 * @see Questionset
 */
class QuestionsetQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Questionset[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Questionset|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
