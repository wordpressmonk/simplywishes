<?php 
use yii\helpers\Url;
use app\models\UserProfile;
use yii\helpers\Html;

$this->title = 'About Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about smp-mg-bottom">
    <h1 style="color:#99cc33"><?= Html::encode($this->title) ?></h1>

    <p>
       If you have a wish, or you want to make someone’s dream come true, you’re at the right place. SimplyWishes connects
	   people from around the globe or around the corner to partner with one another in fulfilling wishes. If you have a wish,post it! There’s no dream too little or too big. If you find joy in enhancing the lives of others, then browse through our list of wishes and start making someone’s dream a reality!
	</p>
	<p>
	   We are environmentalists, journalists, urbane villagers, entrepreneurs, inventors, physicists, engineers, software gurus, soccer-players, roller derby dolls, cat lovers, dog admirers, bee keepers, natives, immigrants, travelers,
	   homesteaders, do gooders, Well Wishers!

    </p>
	<div class="smp_about_slide">
		<div class="about-arw-link"><img src="<?=\Yii::$app->homeUrl?>images/left-arrow.jpg"></div>
		<?php foreach($dataProvider->models as $model){
			$userProfile = UserProfile::find()->where(['user_id'=>$model->wished_by])->one();
			echo '<a href="'.Url::to(['account/profile','id'=>$userProfile->user_id]).'"><img src="'.\Yii::$app->homeUrl.$userProfile->profile_image.'"/></a>';
		}?>
		<div class="about-arw-link"><img src="<?=\Yii::$app->homeUrl?>images/right-arrow.jpg"></div>
	</div>

</div>
