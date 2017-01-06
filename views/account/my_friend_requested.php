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
		<li role="presentation" >
			<a href="<?=\Yii::$app->homeUrl?>account/my-friend" role="tab" >Friends</a>
		</li>
	  <li role="presentation" class="active">
		 <a  role="tab" >Friend Requests</a>
	  </li>
	  <!--<li role="presentation">
		 <a href="<?=\Yii::$app->homeUrl?>account/my-follow" role="tab" >Following</a>
	  </li>-->
	</ul>
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane" id="activewish">
		</div>
		<div role="tabpanel" class="tab-pane active grid" id="fullfilledwish">
			<?php if(isset($myfriend) && !empty($myfriend))
				{
				foreach($myfriend as $userid)
				{	
					if($userid->requested_by == \Yii::$app->user->id)
						$user_id = $userid->requested_to;
					else
						$user_id = $userid->requested_by;	
					
					$profile = UserProfile::find()->where(['user_id'=>$user_id])->one();					
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
					<p><a href="<?= Url::to(['friend/request-accepted','id'=>$userid->f_id]) ?>" ><span class="btn btn-info pull-right" >Accept</span>	</p>
				</div>
			</div>
			  
			<?php } } else {
				echo "Sorry, No more Friend Requested !!!.";
			} ?>	
		</div>
	  </div>
		

</div>




