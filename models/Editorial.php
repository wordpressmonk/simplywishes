<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "editorial".
 *
 * @property integer $e_id
 * @property string $e_title
 * @property string $e_text
 * @property string $e_image
 * @property integer $status
 * @property string $created_at
 */
class Editorial extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'editorial';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['e_title', 'e_text', ], 'required'],
			[['e_image'], 'required','except' => 'update_by_editorial_admin'], 
            [['e_text'], 'string'],
            [['status'], 'integer'],
            [['created_at'], 'safe'],
            [['e_title'], 'string', 'max' => 250],
			[['e_image'], 'file','extensions' => 'jpg,png'],
         
        ];
    }

	
	public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['update_by_editorial_admin'] = ['e_title','e_text','e_image']; //Scenario Values Only Accepted
        return $scenarios;
    } 
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'e_id' => 'E ID',
            'e_title' => 'Title',
            'e_text' => 'Text',
            'e_image' => 'Image',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }
	
	public function uploadImage(){	
			$this->e_image->saveAs('editorial/' . $this->e_image->baseName . '.' .$this->e_image->extension);
			$this->e_image = 'editorial/'.$this->e_image->baseName .'.'.$this->e_image->extension;
			return true;	
	}
}
