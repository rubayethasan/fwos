<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "test_frage_trace".
 *
 * @property int $id
 * @property string $username
 * @property int $round
 */
class Testfragetrace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'test_frage_trace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username'], 'required'],
            [['round'], 'integer'],
            [['username'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'User Name'),
            'round' => Yii::t('app', 'Round'),
        ];
    }

    /**
     * @inheritdoc
     * @return TestfragetraceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestfragetraceQuery(get_called_class());
    }
}
