<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Wish */

$this->title = $model->wish_title;
$this->params['breadcrumbs'][] = ['label' => 'Wishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-view">
  <div class="container my-profile">
	<div class="col-md-12 smp-mg-bottom">
	<h3 class="smp-mg-bottom"><?=$this->title?></h3>
		<div class="col-md-3">
			<div class="">
				<img src="<?=\Yii::$app->homeUrl.$model->primary_image?>"  class="img-responsive" alt="my-profile-Image"><br>
				<p><i class="fa fa-thumbs-o-up fnt-blue"></i> <?=$model->likesCount?> Likes &nbsp;
				<?php
				  if(!$model->isFaved(\Yii::$app->user->id))
					echo '<span title="Save this wish" data-w_id="'.$model->w_id.'" data-a_type="fav" class="fav-wish fa fa-save txt-smp-orange"></span>&nbsp;';
				  else
					echo  '<span title="You saved it" data-w_id="'.$model->w_id.'" data-a_type="fav" class="fav-wish fa fa-save txt-smp-blue"></span>&nbsp;';

				  if(!$model->isLiked(\Yii::$app->user->id))
					echo  '<span title="Like it" data-w_id="'.$model->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-green"></span>';
				  else
					echo  '<span title="You liked it" data-w_id="'.$model->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-pink"></span>';
				?>
				<!--<i class="fa fa-save txt-smp-orange"></i> &nbsp;
				<i class="fa fa-thumbs-o-up txt-smp-green"></i>--> </p>
				<div class="shareIcons"></div>
			</div>
		</div>
		<div class="col-md-8">
			<p>Name : <span><?=$model->summary_title?></span></p>
			<p>Wish Description : <span><?=$model->wish_description?></span></p>
			<p>Iam Located In : <span><?=$model->location?></span></p>
			<p>Expected Date : <span><?=$model->expected_date?></span></p>
			<p>What Do I Give In Return : <span><?=$model->in_return?> </span></p>
			<p>Who Can Potentialy Help me : <span><?=$model->who_can?> </span></p>
			<p>Category : <span><?=$model->categoryName?></span></p>
			<?php if(is_null($model->granted_by) && !\Yii::$app->user->isGuest  && \Yii::$app->user->id!=$model->wished_by){ ?>
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				  <!-- Identify your business so that you can collect the payments. -->
				  <input type="hidden" name="business" value="dency@abacies.com">
				  <!-- Specify a Buy Now button. -->
				  <input type="hidden" name="cmd" value="_xclick">
				  <input type="hidden" name="return" value="<?=Url::to(['wish/fullfilled','w_id'=>$model->w_id],true)?>">
				  <input type="hidden" name="notify_url" value="<?=Url::to(['wish/verify-granted'],true)?>">
				  <!-- Specify details about the item that buyers will purchase. -->
				  <input type="hidden" name="item_name" value="<?=$model->wish_title?>">
				  <input type="hidden" name="item_number" value="<?=$model->w_id?>">
				  <input type="hidden" name="amount" value="<?=$model->expected_cost?>">
				  <input type="hidden" name="currency_code" value="USD">

				  <!-- Display the payment button. -->
				  <input type="image" name="submit" border="0"
				  src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_cc_144x47.png"
				  alt="Buy Now">
				  <img alt="" border="0" width="1" height="1"
				  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
				</form>
			<?php } else if(!is_null($model->granted_by)&& \Yii::$app->user->isGuest){ ?>
				<a href="<?=Url::to(['site/login'])?>"><button class="btn btn-success">Click Here To Grant</button></a>
			<?php } ?>
			
			<?php if(is_null($model->granted_by) && !\Yii::$app->user->isGuest && \Yii::$app->user->id==$model->wished_by)
				echo '<a href="'.Url::to(['wish/update','id'=>$model->w_id]).'"><button class="btn btn-info">Update Wish</button></a>';
			?>
		</div>
	</div>
</div>
<script>
	$(".shareIcons").jsSocials({
		showLabel: false,
		showCount: false,
		shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "whatsapp"]
	});
	$(document).on('click', '.like-wish, .fav-wish', function(){ 
	//$(".like-wish, .fav-wish").on("click",function(){
		var wish_id = $(this).attr("data-w_id");
		var type = $(this).attr("data-a_type");
		var elem = $(this);
		$.ajax({
			url : '<?=Url::to(['wish/like'])?>',
			type: 'GET',
			data: {w_id:wish_id,type:type},
			success:function(data){
				if(data == "added"){
					if(type=="fav"){
						elem.removeClass("txt-smp-orange");
						elem.addClass("txt-smp-blue");
					}
					if(type=="like"){
						elem.removeClass("txt-smp-green");
						elem.addClass("txt-smp-pink");
					}
				}
				if(data == "removed"){
					if(type=="fav"){
						elem.addClass("txt-smp-orange");
						elem.removeClass("txt-smp-blue");
					}
					if(type=="like"){
						elem.addClass("txt-smp-green");
						elem.removeClass("txt-smp-pink");
					}
				}

				console.log(data);
			}
		});
	});
</script>
