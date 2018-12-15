<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eingeben".
 *
 * @property int $id
 * @property int $user_id
 * @property int $user_name
 * @property int $round
 * @property string $qn_ans
 * @property string $create_date
 * @property string $update_date
 * @property string $created_by
 * @property string $updated_by
 */
class Eingeben extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eingeben';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id','user_name', 'round', 'qn_ans'], 'required'],
            [['user_id', 'round'], 'integer'],
            [['qn_ans'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['created_by', 'updated_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'user_name' => Yii::t('app', 'User Name'),
            'round' => Yii::t('app', 'Round'),
            'qn_ans' => Yii::t('app', 'Qn Ans'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return EingebenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EingebenQuery(get_called_class());
    }
}
