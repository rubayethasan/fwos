<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "eingabe".
 *
 * @property int $id
 * @property string $username
 * @property int $round
 * @property float $x0
 * @property float $x1
 * @property float $x2
 * @property float $e2
 * @property float $e5
 * @property float $x31
 * @property float $x32
 * @property string $q
 * @property float $lk
 * @property float $kk
 * @property float $zpf
 * @property float $zpp
 * @property float $vpf
 * @property float $vpp
 */
class Eingabe extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'eingabe';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['round','q','username'], 'required'],
            [['round'], 'integer'],
            [['x0', 'x1', 'x2', 'e2', 'e5', 'x31', 'x32', 'lk', 'kk', 'zpf', 'zpp', 'vpf', 'vpp'], 'number'],
            [['q','username'], 'string'],
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
            'x0' => Yii::t('app', 'Flächenstilllegung'),
            'x1' => Yii::t('app', 'Mais'),
            'x2' => Yii::t('app', 'Kurzumtrieb'),
            'e2' => Yii::t('app', 'Kurzumtrieb'),
            'e5' => Yii::t('app', 'Holz'),
            'x31' => Yii::t('app', 'Schweinemastställe'),
            'x32' => Yii::t('app', 'Schweinemastplätze'),
            'q' => Yii::t('app', 'Maschinen kaufen'),
            'lk' => Yii::t('app', 'Annuitätendarlehen'),
            'kk' => Yii::t('app', 'kurzfristiges Darlehen'),
            'zpf' => Yii::t('app', 'zupachten Fläche'),
            'zpp' => Yii::t('app', 'zupachten Preis'),
            'vpf' => Yii::t('app', 'verpachten Fläche'),
            'vpp' => Yii::t('app', 'verpachten Preis'),
        ];
    }

    /**
     * @inheritdoc
     * @return EingabeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EingabeQuery(get_called_class());
    }
}
