<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "happy_stories".
 *
 * @property integer $hs_id
 * @property integer $user_id
 * @property integer $wish_id
 * @property string $story_text
 * @property string $story_image
 * @property integer $status
 * @property string $created_at
 */
class HappyStories extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'happy_stories';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wish_id', 'story_text'], 'required'],
			[['story_image'], 'required','except' => 'update_by_happystory_user'], 
            [['user_id', 'wish_id', 'status'], 'integer'],
            [['story_text'], 'string'],
            [['created_at'], 'safe'],          
			[['story_image'], 'file','extensions' => 'jpg,png'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'hs_id' => 'Hs ID',
            'user_id' => 'User ID',
            'wish_id' => 'Wish ID',
            'story_text' => 'Story Text',
            'story_image' => 'Story Image',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
	
	public function uploadImage(){	
	
		$this->story_image->saveAs('uploads/happystory/' . $this->story_image->baseName . '.' .$this->story_image->extension);
		$this->story_image = 'uploads/happystory/'.$this->story_image->baseName .'.'.$this->story_image->extension;
		return true;	
	}
	
    /**
     * @return no of likes
     */
    public function getLikesCount()
    {
        return StoryActivity::find()->where(['story_id'=>$this->hs_id,'activity'=>'like'])->count();
    }	
	
    /**
	 * Is this wish liked by the particular user
     * @return boolean
     */	
	public function isLiked($byUser){
		if(StoryActivity::find()->where(['story_id'=>$this->hs_id,'activity'=>'like','user_id'=>$byUser])->one()!= null)
			return true;
		else return false;
	}
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWish()
    {
        return $this->hasOne(Wish::className(), ['w_id' => 'wish_id']);
    }	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
    }	
}
