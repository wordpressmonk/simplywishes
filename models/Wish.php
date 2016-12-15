<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "wishes".
 *
 * @property integer $w_id
 * @property integer $wished_by
 * @property integer $granted_by
 * @property integer $category
 * @property string $wish_title
 * @property string $summary_title
 * @property string $wish_description
 * @property string $primary_image
 * @property integer $state
 * @property integer $country
 * @property integer $city
 */
class Wish extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'wish_title'], 'required'],
			['primary_image', 'required', 'message' => '{attribute} can\'t be blank', 'on'=>'create'],
            [['wished_by', 'granted_by', 'category', 'state', 'country', 'city'], 'integer'],
            [['wish_description'], 'string'],
			[['primary_image'], 'file','extensions' => 'jpg,png', 'skipOnEmpty' => true],
            [['wish_title'], 'string', 'max' => 100],
            [['summary_title'], 'string', 'max' => 150],
        ];
    }
	public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['category', 'wish_title', 'primary_image'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'w_id' => 'W ID',
            'wished_by' => 'Wished By',
            'granted_by' => 'Granted By',
            'category' => 'Category',
            'wish_title' => 'Wish Title',
            'summary_title' => 'Summary Title',
            'wish_description' => 'Wish Description',
            'primary_image' => 'Primary Image',
            'state' => 'State',
            'country' => 'Country',
            'city' => 'City',
        ];
    }
	public function uploadImage(){
		if($this->validate()) {
			$this->primary_image->saveAs('uploads/' . $this->primary_image->baseName . '.' .$this->primary_image->extension);
			$this->primary_image = 'uploads/'.$this->primary_image->baseName.'.'.$this->primary_image->extension;
			return true;
		}else
			return false;
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWisher()
    {
        return $this->hasOne(User::className(), ['id' => 'wished_by']);
    }
	
	public function isLiked($byUser){
		if(Activity::find()->where(['wish_id'=>$this->w_id,'activity'=>'like','user_id'=>$byUser])->one()!= null)
			return true;
		else return false;
	}
	
	public function isFaved($byUser){
		if(Activity::find()->where(['wish_id'=>$this->w_id,'activity'=>'fav','user_id'=>$byUser])->one()!= null)
			return true;
		else return false;
	}
}
