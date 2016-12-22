<?php

namespace app\models;
use Yii;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $fio
 * @property string $access_token
 * @property string $auth_key
 * @property string $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password',], 'string', 'max' => 64],
            [['fio'], 'string', 'max' => 128],
            [['access_token', 'auth_key', 'role'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Login',
            'password' => 'Пароль',
            'fio' => 'Fio',
            'access_token' => 'Access Token',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
        ];
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {


        return static::findOne($id);
    }
    public static function tableName()
    {
        return 'managers';
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {


        return static::findOne([ 'access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {


        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {

        return $this->password === md5($password);
    }

}
