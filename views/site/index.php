<?php 
use yii\helpers\Url;
?>
	
<script src="<?= Yii::$app->request->baseUrl?>/assets/slider/slick.min.js" type="text/javascript"></script>
<link href="<?= Yii::$app->request->baseUrl?>/assets/slider/slick.css" />
<link href="<?= Yii::$app->request->baseUrl?>/assets/slider/slick-theme.css" />
	<div class="simply-head"><h3 class="fnt-green">Fullfilled Wishes</h3></div>
	<div class="container-fluid">    
		<div class="col-md-1 arrow-links"><img src="<?=\Yii::$app->homeUrl?>/images/left-arrow.jpg" class="img-responsive" alt="Image"></div>
		<div class="col-md-10">
			<?php foreach($models as $model){
				echo '<div class="smpl-wish-block thumbnail">';
				echo '<div><img src="'.\Yii::$app->homeUrl.$model->primary_image.'" class="img-responsive" alt="Image"></div>';
				  /////activities///
				  if(!$model->isFaved(\Yii::$app->user->id))
					echo  '<div class="smp-links"><span title="Save this wish" data-w_id="'.$model->w_id.'" data-a_type="fav" class="fav-wish fa fa-save txt-smp-orange"></span></br>';
				  else
					echo  '<div class="smp-links"><span title="You saved it" data-w_id="'.$model->w_id.'" data-a_type="fav" class="fav-wish fa fa-save txt-smp-blue"></span></br>';

				  if(!$model->isLiked(\Yii::$app->user->id))
					echo  '<span title="Like it" data-w_id="'.$model->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-green"></span></div>';
				  else
					echo  '<span title="You liked it" data-w_id="'.$model->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-pink"></span></div>';
				  //////////////////
				  echo  '<div class="smp-wish-desc">';
					echo  '<p>Name : <a href="'.Url::to(['account/profile','id'=>$model->wished_by]).'"><span>'.$model->wisherName.'</span></a></p>
					<p>Wish For : <span>'.$model->wish_title.'</span></p>
					<p>Location : <span>'.$model->location.'</span></p>
					<p><a class="fnt-green" href="'.Url::to(['wish/view','id'=>$model->w_id]).'">Read More</a>
					&nbsp;<i class="fa fa-thumbs-o-up fnt-blue"></i> '.$model->likesCount.' Likes</p>';
				  echo  '</div>
				  <div class="shareIcons"></div>';
				  echo  '</div>';
			}?>
		</div>
		<div class="col-md-1 arrow-links"><img src="<?=\Yii::$app->homeUrl?>/images/right-arrow.jpg" class="img-responsive" alt="Image"></div>
	</div>
	<div class="simply-head">
		<!--<a href="<?=\Yii::$app->homeUrl?>wish/popular"><button class="btn btn-smp-green smpl-brdr" type="button">SEE ALL POPULAR WISHES</button></a>-->
		<a href="<?=\Yii::$app->homeUrl?>wish/granted"><button class="btn btn-smp-green smpl-brdr" type="button">SEE MORE FULFILLED WISHES</button></a>
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
	
	
	
	$('.smp_grid_slider').slick({
	 dots: true,
	 infinite: false,
	 speed: 300,
	 slidesToShow: 4,
	 slidesToScroll: 2,
	 responsive: [
		{
		 breakpoint: 1024,
		 settings: {
			slidesToShow: 3,
			slidesToScroll: 1,
			infinite: true,
			dots: true
		 }
		},
		{
		 breakpoint: 600,
		 settings: {
			slidesToShow: 2,
			slidesToScroll: 1
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
	
</script>