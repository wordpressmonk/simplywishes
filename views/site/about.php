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
	   We are environmentalists, journalists, urbane, villagers, entrepreneurs, inventors, physicists, engineers, software gurus, soccer-players, roller derby dolls, cat lovers, dog admirers, bee keepers, natives, immigrants, travelers,
	   homesteaders, do gooders, Well Wishers!

    </p>
	<div class="smp_about_slide">
		<section class="regular slider">
		<?php foreach($dataProvider->models as $model){
			$userProfile = UserProfile::find()->where(['user_id'=>$model->wished_by])->one();
			echo '<div><a href="'.Url::to(['account/profile','id'=>$userProfile->user_id]).'"><img style="width: 200px; !important"  src="'.\Yii::$app->homeUrl.$userProfile->profile_image.'"/></a></div>';
		}?>
		</section>
	</div>

</div>

<!--------------- SLIDER CHECK Function ---------------------->
  <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl?>src/slick/slick.css">
  <link rel="stylesheet" type="text/css" href="<?= Yii::$app->homeUrl?>src/slick/slick-theme.css"> 
  <script src="<?= Yii::$app->homeUrl?>src/slick/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="<?= Yii::$app->homeUrl?>src/slick/slick.js" type="text/javascript" charset="utf-8"></script>
  
  
  
  <script type="text/javascript">
  var js = $.noConflict();
   js(document).on('ready', function() {
      js(".regular").slick({
         dots: false,
	 infinite: true,
	 speed: 300,
	 slidesToShow: 5,
	 slidesToScroll: 5,
	 responsive: [
		{
		 breakpoint: 1024,
		 settings: {
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
			dots: false
		 }
		},
		{
		 breakpoint: 600,
		 settings: {
			slidesToShow: 2,
			slidesToScroll: 2
		 }
		},
		{
		 breakpoint: 480,
		 settings: {
			slidesToShow: 1,
			slidesToScroll: 1
		 }
		}
	 ]
      });
     
	 
    });
  </script>
  
 
  
  <!--------------- SLIDER CHECK Function END ---------------->
 
