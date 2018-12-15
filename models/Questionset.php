<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "questionset".
 *
 * @property int $id
 * @property int $round
 * @property string $qn_des
 * @property string $qn_ans
 * @property string $create_date
 * @property string $update_date
 * @property string $created_by
 * @property string $updated_by
 */
class Questionset extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'questionset';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['round', 'qn_des', 'qn_ans'], 'required'],
            [['round'], 'integer'],
            [['qn_des', 'qn_ans'], 'string'],
            [['create_date', 'update_date'], 'safe'],
            [['round'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'round' => Yii::t('app', 'Round'),
            'qn_des' => Yii::t('app', 'Qn Des'),
            'qn_ans' => Yii::t('app', 'Qn Ans'),
            'create_date' => Yii::t('app', 'Create Date'),
            'update_date' => Yii::t('app', 'Update Date'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
        ];
    }

    /**
     * @inheritdoc
     * @return QuestionsetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionsetQuery(get_called_class());
    }
}
