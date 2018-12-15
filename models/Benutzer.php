<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "benutzer".
 *
 * @property int $id
 * @property int $user_id
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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'benutzer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'regel', 'name', 'gruppe', 'vorname', 'geschlecht', 'email', 'studienfach', 'semester', 'kenntnisse', 'username', 'password', 'rolle', 'status'], 'required'],
            [['user_id', 'gruppe', 'semester'], 'integer'],
            [['regel', 'geschlecht', 'kenntnisse', 'status'], 'string'],
            [['name', 'vorname', 'email', 'studienfach', 'username', 'password', 'rolle'], 'string', 'max' => 255],
            [['username'], 'unique'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'regel' => 'Regel',
            'name' => 'Name',
            'gruppe' => 'Gruppe',
            'vorname' => 'Vorname',
            'geschlecht' => 'Geschlecht',
            'email' => 'Email',
            'studienfach' => 'Studienfach',
            'semester' => 'Semester',
            'kenntnisse' => 'Kenntnisse',
            'username' => 'Username',
            'password' => 'Password',
            'rolle' => 'Rolle',
            'status' => 'Status',
        ];
    }

    /**
     * {@inheritdoc}
     * @return BenutzerQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BenutzerQuery(get_called_class());
    }
}
