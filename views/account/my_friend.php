<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\UserProfile;


$this->title = 'My Friends';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
		<?php echo $this->render('_profile',['user'=>$user,'profile'=>$profile])?>
		
	<ul class="nav nav-tabs smp-mg-bottom" role="tablist">
		<li role="presentation" class="active">
			<a href="#activewish" role="tab" data-toggle="tab">Friends</a>
		</li>
	  <li role="presentation">
		 <a href="<?=\Yii::$app->homeUrl?>account/friend-requested" role="tab" >Friend Requests</a>
	  </li>
	  <!--<li role="presentation">
		 <a href="<?=\Yii::$app->homeUrl?>account/my-follow" role="tab" >Following</a>
	  </li>-->
	</ul>
	
       <div class="tab-content smp-mg-bottom">
		
		<div role="tabpanel" class="tab-pane active grid" id="fullfilledwish">
			<?php if(isset($myfriend) && !empty($myfriend))
			{
				foreach($myfriend as $userid)
				{	
					if($userid->requested_by == \Yii::$app->user->id)
						$userid = $userid->requested_to;
					else
						$userid = $userid->requested_by;	
					
					$profile = UserProfile::find()->where(['user_id'=>$userid])->one();					
				?>
			 <div class="col-md-6 grid-item"> 
				<div class="smp_inline thumbnail">
					<?php 
					if($profile->profile_image!='') 
						echo '<img  src="'.\Yii::$app->homeUrl.$profile->profile_image.'" class="img-responsive" alt="my-profile-Image">';
					else 
						echo '<img  src="'.\Yii::$app->homeUrl.'images/default_profile.png"   class="img-responsive" alt="my-profile-Image">';
						?>							
				</div>
				<div class="smp_inline">
					<p><span><?= Html::a($profile->firstname.' '.$profile->lastname, Url::to(['account/profile','id'=>$profile->user_id],true)) ?></span></p>						
					<p><span class="btn btn-smp-green pull-right" ><i class='fa fa-check fa-lg'></i> Friends</span>	</p>
				</div>
			</div>
			  
			<?php } } else {
				echo "Sorry, No more friends!!!.";
			} ?>
        </div>
       </div>

</div>




