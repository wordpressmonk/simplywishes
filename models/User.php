<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
	public $password;
	public $verify_password;

	
    const STATUS_DELETED = 12;
    const STATUS_ACTIVE = 10;   
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }
    public function rules()
    {
        return [
			[['username', 'email'],'required'],
			[['password','verify_password'], 'required', 'on'=>'sign-up'],
			[['username', 'email'], 'string', 'max' => 255],
			[['username'], 'unique','targetClass' => '\app\models\User', 'message' => 'This Username has already been taken.'],
			[['email'], 'unique','targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
			[['password','verify_password'], 'string','min'=>6,'max'=>15],
			[['verify_password'],'compare','compareAttribute'=>'password','message'=>'Password do not match'],
		];
	}
	public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['username', 'email','password','verify_password'];
		$scenarios['apply_forgotpassword'] = ['email'];//Scenario Values Only Accepted
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
		return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }
	
    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

	  public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }
	
	
	 public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }
}
