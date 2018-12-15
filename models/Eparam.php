<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "essential_parameters".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $data_type
 * @property string $unit
 * @property string $description
 * @property string $type
 */
class Eparam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'essential_parameters';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value', 'data_type', 'description', 'type'], 'required'],
            [['value'], 'string'],
            [['name', 'data_type', 'unit', 'description', 'type'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'value' => Yii::t('app', 'Value'),
            'data_type' => Yii::t('app', 'Data Type'),
            'unit' => Yii::t('app', 'Unit'),
            'description' => Yii::t('app', 'Description'),
            'type' => Yii::t('app', 'Type'),
        ];
    }

    /**
     * @inheritdoc
     * @return EparamQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EparamQuery(get_called_class());
    }
}
