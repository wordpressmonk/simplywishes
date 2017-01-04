<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<title>Simply Wishes</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?= Html::csrfMetaTags() ?>
	<link rel="shortcut icon" type="image/png" href="<?=Yii::$app->homeUrl?>images/favicon.png"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!--***** Header Starts*****-->
<div class="row smp-head">
	<div class="container">
		<div class="col-md-4 smp-logo">
		<img src="<?=Yii::$app->homeUrl?>images/logo.png" >
		</div>
		<div class="col-md-8">
		<div class="row" style="padding:4px 0px;">
		<?php if(\Yii::$app->user->isGuest){ ?> 
			<div class="btn-group pull-right">
			  <a href="<?=Yii::$app->homeUrl?>site/login"><button class="btn btn-smp-blue smpl-brdr-left" type="button">
				Login
			  </button></a>
			  <a href="<?=Yii::$app->homeUrl?>site/sign-up"><button class="btn btn-smp-green smpl-brdr-right" type="button">
				Join Today
			  </button></a>
			</div>
		<?php  } else { ?>
			<div class="btn-group pull-right">
			  <?php
			  echo Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout',
                    ['class' => 'btn btn-smp-green smpl-brdr']
                )
                . Html::endForm(); ?>
			</div>		
		<?php } ?>
		</div>
		
		<hr style="border-color:#1085bf;">
		<nav>
		  <ul class="nav nav-pills smp-pills">
			<li><a href="<?=Yii::$app->homeUrl?>">Home</a></li>
			<li><a href="<?=Yii::$app->homeUrl?>site/about">About Us</a></li>
			<li><a href="<?=Yii::$app->homeUrl?>wish/index">Find a Wish</a></li>

			<li><a href="<?=Yii::$app->homeUrl?>wish/top-wishers">iWish</a></li>
			<li><a href="<?=Yii::$app->homeUrl?>wish/top-granters">iGrant</a></li>
			<li><a href="<?=Yii::$app->homeUrl?>happy-stories/index">Happy stories</a></li>
			<li> 
				<?php if(isset(\Yii::$app->user->identity->role) && (\Yii::$app->user->identity->role == 'admin')){ ?>
					<a href="<?=Yii::$app->homeUrl?>editorial/index">Editorial</a>
				<?php } else { ?> 
					<a href="<?=Yii::$app->homeUrl?>editorial/editorial">Editorial</a>
				<?php } ?>			
			</li>

			<?php if(!\Yii::$app->user->isGuest){  ?>
			<li class="dropdown"><a href="#">Hello,<?php echo substr(\Yii::$app->user->identity->username,0,5)?>..!</a>
				<ul class="dropdown-menu nav nav-stacked">
					<li><a href="<?=Yii::$app->homeUrl?>account/inbox"><i class="fa fa-inbox fa-lg"></i> Inbox</a></li>
					<li><a href="<?=Yii::$app->homeUrl?>account/my-account"><i class="fa fa-user-circle-o fa-lg"></i> Account Info</a></li>
					<li><a href="<?=Yii::$app->homeUrl?>wish/create"><i class="fa fa-clone fa-lg"></i>Add Wish</a></li>
					<li><a href="<?=Yii::$app->homeUrl?>account/my-account"><i class="fa fa-heart fa-lg"></i>My Wishes</a></li>
					<li><a href="#"><i class="fa fa-commenting-o fa-lg"></i>Tell Your Story</a></li>
					<li><a href="#"><i class="fa fa-smile-o fa-lg"></i>My Happy Story</a></li>
					<li><a href="<?=Yii::$app->homeUrl?>account/my-saved"><i class="fa fa-save fa-lg"></i>Saved Wishes</a></li>
				</ul>			
			</li>
			<?php } ?>			
		  </ul>
		</nav>
		</div>
	</div>
</div>
<!--***** Header Ends*****-->
<div class="row" style="background-image:url('<?=Yii::$app->homeUrl?>images/bgimage.jpg');">
	<div class="container" style="padding: 25px 0px 50px 36px;">
		<h1 class="slide_header">Make Someone </br>
		Happy Today</h1>  
		<a href="<?=Yii::$app->homeUrl?>site/sign-up"><button class="btn btn-smp-orange smpl-brdr" type="button">JOIN TODAY!</button></a>
	</div>
</div> 
<div class="container">
	<?=$content?>
</div>
<!--***** Footer Starts*****-->
<div class="smp-foot">
	<footer class="container-fluid">
	<div class="col-md-12">
		<div class="col-md-4">
		<p class="pull-right"> &copy; SimplyWishes 2016, ALL Rights Reserved</p>
		</div>
		<div class="col-md-8">
			<ul class="smp-footer-links">
				<a href="<?=\Yii::$app->homeUrl?>page/view?id=1"><li>Privacy Policy</li></a>
				<a href="<?=\Yii::$app->homeUrl?>page/view?id=2"><li>Terms Of Use</li></a>
				<a href="<?=\Yii::$app->homeUrl?>page/view?id=3"><li>Community Guidelines</li></a>
				<!--<a href="<?=\Yii::$app->homeUrl?>site/about"><li>About Us</li></a>-->
				<a href="<?=\Yii::$app->homeUrl?>site/contact"><li>Contact Us</li></a>
			</ul>
		</div>
	</div>
	</footer>
</div>
<!--***** Footer Ends *****-->
<?php $this->endBody() ?>
</body>
<script>
jQuery(document).ready(function(){
$('ul.nav li.dropdown').hover(function() {
	$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
	});
});
</script>
</html>
<?php $this->endPage() ?>


