<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%benutzer}}".
 *
 * @property int $id
 * @property string $regel
 * @property string $name
 * @property int $gruppe
 * @property string $vorname
 * @property string $geschlecht
 * @property string $email
 * @property string $studienfach
 * @property int $semester
 * @property string $kenntnisse
 * @property string $username
 * @property string $password
 * @property string $rolle
 * @property string $status
 */
class Benutzer extends \yii\db\ActiveRecord
{
    public $password_wiederholen;
    //public $verifyCode;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%benutzer}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['regel', 'name', 'vorname', 'geschlecht', 'email', 'studienfach', 'semester', 'kenntnisse', 'username'], 'required'],
            [['regel', 'geschlecht', 'kenntnisse'], 'string'],
            [['semester', 'status','gruppe'], 'integer'],
            [['email'], 'email'],
            ['username', 'unique'],
            [['name', 'vorname', 'email', 'studienfach', 'username','rolle'], 'string', 'max' => 255],

            ['password', 'string', 'min' => 6,'max' => 255],
            [['password','password_wiederholen'], 'required', 'on' => 'create'],
            ['password_wiederholen', 'compare', 'compareAttribute'=>'password' ,'on' => 'create'],
            ['regel', 'compare', 'compareValue'=>'ja' ],
            //['verifyCode', 'captcha','on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'regel' => Yii::t('app', 'Regel'),
            'name' => Yii::t('app', 'Name'),
            'gruppe' => Yii::t('app', 'Gruppe'),
            'vorname' => Yii::t('app', 'Vorname'),
            'geschlecht' => Yii::t('app', 'Geschlecht'),
            'email' => Yii::t('app', 'Email'),
            'studienfach' => Yii::t('app', 'Studienfach'),
            'semester' => Yii::t('app', 'Semester'),
            'kenntnisse' => Yii::t('app', 'Kenntnisse'),
            'username' => Yii::t('app', 'Benutzername'),
            'password' => Yii::t('app', 'Passwort'),
            'rolle' => Yii::t('app', 'Rolle'),
            'status' => Yii::t('app', 'Status'),
            //'verifyCode' => Yii::t('app', 'Bestätigungscode'),
        ];
    }

    /**
     * @inheritdoc
     * @return BenutzerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BenutzerQuery(get_called_class());
    }
}
