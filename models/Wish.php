<?php

namespace app\models;

use Yii;
use yii\helpers\Url;

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
            [['category', 'wish_title','state', 'country', 'city','expected_cost','expected_date'], 'required'],
			['primary_image', 'required', 'message' => '{attribute} can\'t be blank', 'on'=>'create'],
            [['wished_by', 'granted_by', 'category', 'state', 'country', 'city'], 'integer'],
            [['wish_description'], 'string'],
			[['primary_image'], 'file','extensions' => 'jpg,png', 'skipOnEmpty' => true],
            [['wish_title'], 'string', 'max' => 100],
            [['summary_title','who_can'], 'string', 'max' => 150],
			[['in_return'], 'string', 'max' => 1500],
        ];
    }
	public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['create'] = ['category', 'wish_title','summary_title', 'wish_description','primary_image','state', 'country', 'city','expected_cost','expected_date','in_return','who_can'];
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
			'expected_cost'=>'Expected Cost(USD)',
			'expected_date'=>'Expected Date',
			'in_return'=>'What Do I Give In Return',
			'who_can'=>'Who Can Potentialy Help me',
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
    public function getCountryModel()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStateModel()
    {
        return $this->hasOne(State::className(), ['id' => 'state']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCityModel()
    {
        return $this->hasOne(City::className(), ['id' => 'city']);
    }	
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLikes()
    {
        return $this->hasMany(Activity::className(), ['wish_id' => 'w_id']) ->andOnCondition(['activity' => 'like']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSaved()
    {
        return $this->hasMany(Activity::className(), ['wish_id' => 'w_id']) ->andOnCondition(['activity' => 'fav']);
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
          $str .= '<div class="grid-item col-md-4"><div class=" smpl-wish-block1 thumbnail">';
          $str .= '<div><a href="'.Url::to(['wish/view','id'=>$this->w_id]).'"><img src="'.\Yii::$app->homeUrl.$this->primary_image.'" class="img-responsive" alt="Image"></a></div>';
          /////activities///
          if(!$this->isFaved(\Yii::$app->user->id))
            $str .=  '<div class="smp-links"><span title="Save this wish" data-w_id="'.$this->w_id.'" data-a_type="fav" class="fav-wish fa fa-save txt-smp-orange"></span></br>';
          else
            $str .=  '<div class="smp-links"><span title="You saved it" data-w_id="'.$this->w_id.'" data-a_type="fav" class="fav-wish fa fa-save txt-smp-blue"></span></br>';

          if(!$this->isLiked(\Yii::$app->user->id))
            $str .=  '<span title="Like it" data-w_id="'.$this->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-green"></span></div>';
          else
            $str .=  '<span title="You liked it" data-w_id="'.$this->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-pink"></span></div>';
          //////////////////
          $str .=  '<div class="smp-wish-desc">';
            $str .=  '<p><div class="list-icon">
							<img src="'.$this->wisherPic.'" alt="">
							<a href="'.Url::to(['account/profile','id'=>$this->wished_by]).'"><span>'.$this->wisherName.'</span></a>
						</div></p>
            <!--<p>Wish For : <span>'.$this->wish_title.'</span></p>
            <p>Location : <span>'.$this->location.'</span></p>-->
			<p class="desc" >'.substr($this->summary_title,0,50).'</p>
            <p><a class="fnt-green" href="'.Url::to(['wish/view','id'=>$this->w_id]).'">Read More</a>
            &nbsp;<i class="fa fa-thumbs-o-up fnt-blue"></i> '.$this->likesCount.' Likes</p>';
          $str .=  '</div>
          <div class="shareIcons" data_text="'.$this->wish_title.'" data_url="'.Url::to(['wish/view','id'=>$this->w_id],true).'" ></div>';
          $str .=  '</div></div>';	
			
		echo $str;
	}
	public function getHtmlForProfile(){
		echo '<div class="col-md-6 grid-item"> 
				<div class="smp_inline thumbnail">					
					<a href="'.Url::to(['wish/view','id'=>$this->w_id]).'"><img src="'.\Yii::$app->homeUrl.$this->primary_image.'"  class="img-responsive" alt="Image"></a> 					
				</div>
				
				<div class="smp_inline">
					<p>Wish Title : <span>'.$this->wish_title.'</span></p>
					<p>Wish Description : <span>'.substr($this->wish_description,0,25).'..</span></p>
					<p>Location : <span>'.$this->location.'</span></p>
					<p>Category : <span>'.$this->categoryName.'</span></p>
					<p><a class="fnt-green" href="'.Url::to(['wish/view','id'=>$this->w_id]).'">Read More >></a> </p>
					
					
				</div>
			</div>';
	}
	
		public function getHtmlForProfileSaved(){
		echo '<div class="col-md-6 grid-item"> 
				<div class="smp_inline thumbnail">					
					<a href="'.Url::to(['wish/view','id'=>$this->w_id]).'"><img src="'.\Yii::$app->homeUrl.$this->primary_image.'"  class="img-responsive" alt="Image"></a>
					<br>
					<p><a style="margin-left:10px" class="fnt-danger" href="'.Url::to(['wish/remove-wish','wish_id'=>$this->w_id]).'"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a> </p>
				</div>
				
				<div class="smp_inline">
					<p>Wish Title : <span>'.$this->wish_title.'</span></p>
					<p>Wish Description : <span>'.substr($this->wish_description,0,25).'..</span></p>
					<p>Location : <span>'.$this->location.'</span></p>
					<p>Category : <span>'.$this->categoryName.'</span></p>
					<p><a class="fnt-green" href="'.Url::to(['wish/view','id'=>$this->w_id]).'">Read More >></a> </p>
					
					
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
		if(!$country || !$state)
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
    /**
     * @returns the name of the wisher
     */	
	public function getWisherPic(){
		
		$profile = UserProfile::find()->where(['user_id'=>$this->wished_by])->one();
		if($profile && $profile->profile_image!='')
			return Yii::$app->homeUrl.$profile->profile_image;
		
		else return Yii::$app->homeUrl."images/default_profile.png";
	}		
}
