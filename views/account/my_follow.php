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
	  <li role="presentation" >
		 <a  href="<?=\Yii::$app->homeUrl?>account/friend-requested" role="tab" >Friend Requests</a>
	  </li>
	  <li role="presentation" class="active">
		 <a  role="tab" >Following</a>
	  </li>
	</ul>
	
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane" id="activewish">
		</div>
		<div role="tabpanel" class="tab-pane active grid" id="fullfilledwish">
			<?php echo "Under Construction "; ?>
		</div>
	  </div>
		

</div>




