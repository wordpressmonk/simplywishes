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
            [['user_id', 'wish_id', 'story_text', 'story_image'], 'required'],
            [['user_id', 'wish_id', 'status'], 'integer'],
            [['story_text'], 'string'],
            [['created_at'], 'safe'],
            [['story_image'], 'string', 'max' => 255],
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
			$this->story_image->saveAs('happystory/' . $this->story_image->baseName . '.' .$this->story_image->extension);
			$this->story_image = 'happystory/'.$this->story_image->baseName .'.'.$this->story_image->extension;
			return true;	
	}
}
