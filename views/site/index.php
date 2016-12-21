<?php 
use yii\helpers\Url;
?>
	
	<div class="simply-head"><h3>Fullfilled Wishes</h3></div>
	<div class="container-fluid">    
		<div class="col-md-1 arrow-links"><img src="<?=\Yii::$app->homeUrl?>/images/left-arrow.jpg" class="img-responsive" alt="Image"></div>
		<div class="col-md-10">
			<?php foreach($models as $model){
				echo '<div class="smpl-wish-block thumbnail">';
				echo '<img src="'.\Yii::$app->homeUrl.$model->primary_image.'" class="img-responsive" alt="Image">';
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
					echo  '<p>Name : <span>'.$model->wisherName.'</span></p>
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
		<a href="<?=\Yii::$app->homeUrl?>wish/popular"><button class="btn btn-smp-green smpl-brdr" type="button">SEE ALL POPULAR WISHES</button></a>
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