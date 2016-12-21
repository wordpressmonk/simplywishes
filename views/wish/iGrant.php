<?php 
use yii\helpers\Url;
use app\models\UserProfile;
?>
<div class="smp-igrant">
<h3 class="smp-mg-bottom">iWish Our Grantors</h3>
	<div class="col-md-12 smp-mg-bottom">
	
		<?php 
		foreach($dataProvider->models as $model){
			$userProfile = UserProfile::find()->where(['user_id'=>$model->granted_by])->one();
			echo '<a href="'.Url::to(['account/profile','id'=>$userProfile->user_id]).'"><img src="'.\Yii::$app->homeUrl.$userProfile->profile_image.'"/></a>';
		}?>
	</div>
</div>