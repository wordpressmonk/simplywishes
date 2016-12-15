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
		<img src="<?=Yii::$app->homeUrl?>images/logo.jpg" >
		</div>
		<div class="col-md-8">

		<div class="row" style="padding:28px 0px;">
		<?php if(\Yii::$app->user->isGuest){ ?>
			<div class="btn-group pull-right">
			  <button class="btn btn-smp-blue smpl-brdr" type="button">
				<a href="<?=Yii::$app->homeUrl?>/site/login">Login</a>
			  </button>
			  <button class="btn btn-smp-green smpl-brdr" type="button">
				<a href="<?=Yii::$app->homeUrl?>/site/sign-up">Join Today</a>
			  </button>
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
			<li class="active"><a href="#">Home</a></li>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Find a Wish</a></li>
			<li><a href="#">iWish</a></li>
			<li><a href="#">iGrant</a></li>
			<li><a href="#">Happy stories</a></li>
			<li><a href="#">Editorial</a></li>
			<?php if(!\Yii::$app->user->isGuest){  ?>
			<li class="dropdown"><a href="#">Hello,<?php echo substr(\Yii::$app->user->identity->username,0,5)?>..!</a>
				<ul class="dropdown-menu nav nav-stacked">
					<li><a href="#"><i class="fa fa-inbox fa-lg"></i> Inbox</a></li>
					<li><a href="<?=Yii::$app->homeUrl?>/site/my-account"><i class="fa fa-user-circle-o fa-lg"></i> Account Info</a></li>
					<li><a href="<?=Yii::$app->homeUrl?>/wish/create"><i class="fa fa-clone fa-lg"></i>Add Wish</a></li>
					<li><a href="#"><i class="fa fa-heart fa-lg"></i>My Wishes</a></li>
					<li><a href="#"><i class="fa fa-commenting-o fa-lg"></i>Tell Your Story</a></li>
					<li><a href="#"><i class="fa fa-smile-o fa-lg"></i>My Happy Story</a></li>
					<li><a href="#"><i class="fa fa-save fa-lg"></i>Saved Wishes</a></li>
				</ul>
			</li>
			<?php } ?>
		  </ul>
		</nav>
		</div>
	</div>
</div>
<!--***** Header Ends*****-->
<div class="container">
	<?=$content?>
</div>
<!--***** Footer Starts*****-->
<div class="smp-foot">
	<footer class="container-fluid">
	<div class="col-md-12">
		<div class="col-md-4">
		<p class="pull-right"> &copy; Simply Wishes 2016, ALL Rights Reserved</p>
		</div>
		<div class="col-md-8">
			<ul class="smp-footer-links">
				<li>Privacy Policy</li>
				<li>Terms Of Us</li>
				<li>Community Guidelines</li>
				<li>About Us</li>
				<li>Contact Us</li>
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
