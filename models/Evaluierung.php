<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "evaluierung".
 *
 * @property int $id
 * @property string $username
 * @property int $round
 * @property string $f1
 * @property string $f2
 * @property string $f3
 * @property string $f4
 * @property string $f5
 * @property string $f6
 * @property string $f7
 * @property string $f8
 * @property string $f9
 * @property string $f10
 * @property string $f11
 * @property string $f12
 * @property string $f13
 * @property string $XY1
 * @property string $XY2
 * @property string $XY3
 * @property string $XY4
 * @property string $XY5
 * @property string $XY6
 * @property string $XY7
 * @property string $XY8
 * @property string $XY9
 * @property string $XY10
 */
class Evaluierung extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evaluierung';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'round', 'f1', 'f2', 'f3', 'f4', 'f5', 'f6', 'f7', 'f8', 'f9', 'f10', 'f11', 'f12', 'f13', 'XY1', 'XY2', 'XY3', 'XY4', 'XY5', 'XY6', 'XY7', 'XY8', 'XY9', 'XY10'], 'required'],
            [['round'], 'integer'],
            [['username','f1', 'f2', 'f3', 'f5', 'f7', 'f8', 'f9', 'f10', 'f11', 'f12', 'f13', 'XY1', 'XY2', 'XY3', 'XY4', 'XY5', 'XY6', 'XY7', 'XY8', 'XY9', 'XY10'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'User Name',
            'round' => 'Round',
            'f1' => 'F1',
            'f2' => 'F2',
            'f3' => 'F3',
            'f4' => 'F4',
            'f5' => 'F5',
            'f6' => 'F6',
            'f7' => 'F7',
            'f8' => 'F8',
            'f9' => 'F9',
            'f10' => 'F10',
            'f11' => 'F11',
            'f12' => 'F12',
            'f13' => 'F13',
            'XY1' => 'Xy1',
            'XY2' => 'Xy2',
            'XY3' => 'Xy3',
            'XY4' => 'Xy4',
            'XY5' => 'Xy5',
            'XY6' => 'Xy6',
            'XY7' => 'Xy7',
            'XY8' => 'Xy8',
            'XY9' => 'Xy9',
            'XY10' => 'Xy10',
        ];
    }

    /**
     * @inheritdoc
     * @return EvaluierungQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EvaluierungQuery(get_called_class());
    }
}
