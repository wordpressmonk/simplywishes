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
	<h3 class="smp-mg-bottom fnt-green "><?=$this->title?></h3>
		<div class="col-md-3 happystory sharefull-list">
			
				<img src="<?=\Yii::$app->homeUrl.$model->primary_image?>"  class="img-responsive" alt="my-profile-Image"><br>
				<p><i class="fa fa-thumbs-o-up fnt-blue"></i><span id="likecmt_<?= $model->w_id ?>"> <?=$model->likesCount?> </span> Likes &nbsp;
				<!--<a class="report-img" title="Report" data-id="<?= $model->w_id ?>"><img  src="<?= Yii::$app->homeUrl ?>images/report.png" alt="">-->
				</a>
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
				<i class="fa fa-thumbs-o-up txt-smp-green"></i>--> 
				<span  data-placement="top"  data-popover-content=""><img data-placement="top" class="listesinside removelistesinside"  src="<?= Yii::$app->homeUrl ?>images/Share-Icon.png"  /></span>					
				<div class="shareIcons hide" ></div>
				
				</p>
				<!--<div class="shareIcons"></div> -->

			
		</div>
		<div class="col-md-8">
			<p><b>Name : </b><span><a href="<?=Url::to(['account/profile','id'=>$model->wished_by])?>"><span><?=$model->wisherName?></span></a></span></p>
			<p><b>Wish Description : </b><span><?=$model->wish_description?></span></p>
			<p><b>Location of Wish : </b><span><?=$model->location?></span></p>
			<p><b>Date Issued : </b><span><?php echo date("m/d/Y",strtotime($model->expected_date)); ?></span></p>
			<p><b>What Do I Give In Return : </b><span><?=$model->in_return?> </span></p>
			<p><b>Who Can Potentialy Help me : </b><span><?=$model->who_can?> </span></p>
			<p><b>Recipient : </b><span><?=$model->categoryName?></span></p>
			<?php if(!is_null($model->granted_by)){ ?>	
			<p><b>Wish granted on : </b><span><?=$model->granted_date ?></span></p>			
			<p><b>Wish granted by : </b><span><a href="<?=Url::to(['account/profile','id'=>$model->granted_by])?>"><span><?=$model->GrantedWisherName?></span></a></span></p>		
			<?php } ?>			
			<?php if(is_null($model->granted_by) && !\Yii::$app->user->isGuest  && \Yii::$app->user->id!=$model->wished_by){ ?>
			 <?php if($model->non_pay_option == 0 ){ ?>
				<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
				<!-- <form action="https://www.paypal.com/cgi-bin/webscr" method="post"> -->
				  <!-- Identify your business so that you can collect the payments. -->
				  <!--<input type="hidden" name="business" value="dency@abacies.com">-->
				  <input type="hidden" name="business" value="<?=$model->wisher->email?>">
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
				  <!--<input type="image" name="submit" border="0" 
				  src="https://www.paypalobjects.com/webstatic/en_US/i/btn/png/btn_paynow_cc_144x47.png"
				  alt="Buy Now">-->
				  <button class="btn btn-success">Grant This Wish</button>
				  <img alt="" border="0" width="1" height="1"
				  src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
				</form>
			<?php } else { ?>
					<a href="<?=Url::to(['wish/fullfilled','w_id'=>$model->w_id],true)?>"><button class="btn btn-success">Grant This Wish</button></a>
			<?php } ?> 	
					
			<?php } else if(!is_null($model->granted_by)&& \Yii::$app->user->isGuest){ ?>
				<a href="<?=Url::to(['site/login','red_url'=>Yii::$app->homeUrl.'wish/view?id='.$model->w_id])?>"><button class="btn btn-success">Grant This Wish</button></a>
			<?php } else if(\Yii::$app->user->isGuest) { ?>
				<a href="<?=Url::to(['site/login','red_url'=>Yii::$app->homeUrl.'wish/view?id='.$model->w_id])?>"><button class="btn btn-success">Grant This Wish</button></a>
			<?php } ?>
			
			<?php if(is_null($model->granted_by) && !\Yii::$app->user->isGuest && \Yii::$app->user->id==$model->wished_by)
				echo '<a href="'.Url::to(['wish/update','id'=>$model->w_id]).'"><button class="btn btn-info">Update Wish</button></a>';
			?>
				<?php if(is_null($model->granted_by) && !\Yii::$app->user->isGuest && \Yii::$app->user->id==$model->wished_by)
			//	echo '<button class="btn btn-danger deletecheck">Delete </button>';
			?>
		</div>
	</div>
</div>
</div>
<script>
	$(".shareIcons").jsSocials({
		showLabel: false,
		showCount: false,
		shares: ["facebook", "googleplus", "pinterest", "linkedin" ,"twitter" ]
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
						var likecmt = $("#likecmt_"+wish_id).text();
						likecmt = parseInt(likecmt) + parseInt(1);
						$("#likecmt_"+wish_id).text(likecmt);
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
						var likecmt = $("#likecmt_"+wish_id).text();
						likecmt = parseInt(likecmt) - parseInt(1);
						$("#likecmt_"+wish_id).text(likecmt);
					}
				}

				console.log(data);
			}
		});
	});
	
	$(document).on('click', '.deletecheck', function(){ 
		if(confirm("Are Sure To Delete this Wish ?"))
		{
			$.ajax({
			url : '<?=Url::to(['wish/ajax-delete'])?>',
			type: 'POST',
			data: {id:<?= $model->w_id ?>},
			success:function(data){				
						window.location.href="<?= Url::to(['account/my-account'],true); ?>"; 
				}	
			});
		
		}
		else{
			return false;
		}
	});
</script>


	<script>	
	var isVisible = false;
var clickedAway = false;

$(document).on("click", ".listesinside", function() {
	$(function(){
		$('.listesinside').popover({   
			html: true,
			content: function () {
				var clone = $($(this).parents(".sharefull-list").find(".shareIcons")).clone(true).removeClass('hide');
				return clone;
			}
		}).click(function(e) {
			e.preventDefault();
			clickedAway = false;
			isVisible = true;
		});
	});
 
});

$(document).click(function (e) {
    if (isVisible & clickedAway) {
        $('.listesinside').popover('hide');
        isVisible = clickedAway = false;
    } else {
        clickedAway = true;
    }
});

$('body').on('hidden.bs.popover', function (e) {
    $(e.target).data("bs.popover").inState.click = false;
});


/* $(document).on('click','.jssocials-shares',function(){
		 $('.listesinside').popover('hide');
	}); */
	
/* $(document).on("click", ".report-img", function() {
	var wish_id = $(this).attr("data-id");
	 if($.trim(wish_id) !== "" )
	 {
		$.ajax({
			url : '<?=Url::to(['wish/report'])?>',
			type: 'GET',
			data: {w_id:wish_id},
			success:function(data){
				if($.trim(data) == "added")
				{
					alert(" Thanks For your Report. ");
				}
				console.log(data);
			}
		});
	 }
}); */

</script>

