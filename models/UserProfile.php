<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $profile_id
 * @property integer $user_id
 * @property string $firstname
 * @property string $lastname
 * @property string $about
 * @property integer $country
 * @property integer $state
 * @property integer $city
 * @property string $profile_image
 */
class UserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname'], 'required'],
            [['user_id', 'country', 'state', 'city'], 'integer'],
            [['about'], 'string'],
			[['profile_image'], 'file','extensions' => 'jpg,png', 'skipOnEmpty' => true],
            [['firstname', 'lastname'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'profile_id' => 'Profile ID',
            'user_id' => 'User ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'about' => 'About',
            'country' => 'Country',
            'state' => 'State',
            'city' => 'City',
            'profile_image' => 'Profile Image',
        ];
    }
	
	public function uploadImage(){
		if($this->validate()) {
			$this->profile_image->saveAs('uploads/' . $this->profile_image->baseName . '.' .$this->profile_image->extension);
			$this->profile_image = 'uploads/'.$this->profile_image->baseName.'.'.$this->profile_image->extension;
			return true;
		}else
			return false;
	}
}
