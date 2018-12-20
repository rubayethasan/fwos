<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "gruppe".
 *
 * @property int $id
 * @property int $gruppe
 */
class Gruppe extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gruppe';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gruppe'], 'required'],
            [['gruppe'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gruppe' => 'Gruppe',
        ];
    }

    /**
     * {@inheritdoc}
     * @return GruppeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GruppeQuery(get_called_class());
    }
}
