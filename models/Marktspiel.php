<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marktspiel".
 *
 * @property int $id
 * @property string $username
 * @property int $round
 * @property string $VK1
 * @property string $VK2
 * @property string $VK3
 * @property string $VK4
 * @property string $VK5
 * @property string $VK6
 * @property string $VK7
 * @property string $VK8
 * @property string $VK9
 * @property string $VK10
 * @property string $VK11
 * @property string $VK12
 * @property string $VK13
 * @property string $VK14
 * @property string $VK15
 * @property string $VK16
 * @property string $VK17
 * @property int $variante
 * @property float $input
 */
class Marktspiel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'marktspiel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'round', 'variante','input'], 'required'],
            [['round','variante'], 'integer'],
            [['input'], 'number'],
            [['username'], 'string', 'max' => 255],
            [['VK1', 'VK2', 'VK3', 'VK4', 'VK5', 'VK6', 'VK7', 'VK8', 'VK9', 'VK10', 'VK11', 'VK12', 'VK13', 'VK14', 'VK15', 'VK16', 'VK17'], 'string', 'max' => 2],
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
            'VK1' => 'Vk1',
            'VK2' => 'Vk2',
            'VK3' => 'Vk3',
            'VK4' => 'Vk4',
            'VK5' => 'Vk5',
            'VK6' => 'Vk6',
            'VK7' => 'Vk7',
            'VK8' => 'Vk8',
            'VK9' => 'Vk9',
            'VK10' => 'Vk10',
            'VK11' => 'Vk11',
            'VK12' => 'Vk12',
            'VK13' => 'Vk13',
            'VK14' => 'Vk14',
            'VK15' => 'Vk15',
            'VK16' => 'Vk16',
            'VK17' => 'Vk17',
        ];
    }

    /**
     * @inheritdoc
     * @return MarktspielQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MarktspielQuery(get_called_class());
    }
}
