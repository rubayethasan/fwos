<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Eingeben]].
 *
 * @see Eingeben
 */
class EingebenQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Eingeben[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Eingeben|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
