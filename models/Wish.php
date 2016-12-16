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
            [['category', 'wish_title','state', 'country', 'city'], 'required'],
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
        $scenarios['create'] = ['category', 'wish_title','summary_title', 'wish_description','primary_image','state', 'country', 'city'];
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
		//if($this->validate()) {
			$this->primary_image->saveAs('uploads/' . $this->primary_image->baseName . '.' .$this->primary_image->extension);
			$this->primary_image = 'uploads/'.$this->primary_image->baseName.'.'.$this->primary_image->extension;
			return true;
		//}else
		//	return false;
	}
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWisher()
    {
        return $this->hasOne(User::className(), ['id' => 'wished_by']);
    }
	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Activity::className(), ['wish_id' => 'w_id']) ->andOnCondition(['activity' => 'like']);
    }
	
    /**
     * @return no of likes
     */
    public function getLikesCount()
    {
        return Activity::find()->where(['wish_id'=>$this->w_id,'activity'=>'like'])->count();
    }	
	
    /**
	 * Is this wish liked by the particular user
     * @return boolean
     */	
	public function isLiked($byUser){
		if(Activity::find()->where(['wish_id'=>$this->w_id,'activity'=>'like','user_id'=>$byUser])->one()!= null)
			return true;
		else return false;
	}
	
    /**
	 * Is this wish favourited by the particular user
     * @return boolean
     */		
	public function isFaved($byUser){
		if(Activity::find()->where(['wish_id'=>$this->w_id,'activity'=>'fav','user_id'=>$byUser])->one()!= null)
			return true;
		else return false;
	}
	
    /**
	 * Forms th html for a particular wish
     * @return html
     */		
	public function getWishAsCard(){
		  $str = '';
          $str .= '<div class="grid-item col-md-4"><div class="thumbnail">';
          $str .= '<img src="'.\Yii::$app->homeUrl.$this->primary_image.'" class="img-responsive" alt="Image">';
          /////activities///
          if(!$this->isFaved(\Yii::$app->user->id))
            $str .=  '<div class="smp-links"><span title="Add to favourites" data-w_id="'.$this->w_id.'" data-a_type="fav" class="fav-wish glyphicon glyphicon-heart-empty txt-smp-orange"></span></br>';
          else
            $str .=  '<div class="smp-links"><span title="You favourited it" data-w_id="'.$this->w_id.'" data-a_type="fav" class="fav-wish glyphicon glyphicon-heart-empty txt-smp-blue"></span></br>';

          if(!$this->isLiked(\Yii::$app->user->id))
            $str .=  '<span title="Like it" data-w_id="'.$this->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-green"></span></div>';
          else
            $str .=  '<span title="You liked it" data-w_id="'.$this->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-pink"></span></div>';
          //////////////////
          $str .=  '<div class="smp-wish-desc">';
            $str .=  '<p>Name : <span>'.$this->wisherName.'</span></p>
            <p>Wish For : <span>'.$this->wish_title.'</span></p>
            <p>Location : <span>'.$this->location.'</span></p>
            <p><a class="fnt-green" href="#">Read More</a>
            &nbsp;<i class="fa fa-thumbs-o-up fnt-blue"></i> '.$this->likesCount.' Likes</p>';
          $str .=  '</div>
          <div class="shareIcons"></div>';
          $str .=  '</div></div>';	
			
		echo $str;
	}
	public function getHtmlForProfile(){
		echo '<div class="col-md-6 grid-item"> 
				<div class="smp_inline thumbnail">
					<img src="'.\Yii::$app->homeUrl.$this->primary_image.'"  class="img-responsive" alt="Image">
				</div>
				<div class="smp_inline">
					<p>Wish Title : <span>'.$this->wish_title.'</span></p>
					<p>Wish Description : <span>'.$this->wish_description.'</span></p>
					<p>Location : <span>'.$this->location.'</span></p>
					<p>Category : <span>'.$this->categoryName.'</span></p>
					<p><a class="fnt-green" href="#">Read More >></a> </p>
				</div>
			</div>';
	}
    /**
     * @returns the location of the wish
     */	
	public function getLocation(){
		
		$country = Country::findOne($this->country);
		$state = State::findOne($this->state);
		$city = City::findOne($this->city);
		if(!$country || $state)
			return "Unknown";
		else return "$state->name , $country->name";
	}
    /**
     * @returns the location of the wish
     */	
	public function getCategoryName(){
		
		$Category = Category::findOne($this->category);
		if(!$Category)
			return "Unknown";
		else return "$Category->title";
	}
    /**
     * @returns the name of the wisher
     */	
	public function getWisherName(){
		
		$profile = UserProfile::find()->where(['user_id'=>$this->wished_by])->one();
		if(!$profile)
			return User::findOne($this->wished_by)->username;
		
		return "$profile->firstname $profile->lastname";
	}	
	
}
