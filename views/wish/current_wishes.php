<?php 
use yii\helpers\Html;
use yii\helpers\Url;
?>
    <div class="col-md-12">
		<div class="col-md-3">
			<h3>Find A Wish</h3>
			<ul class="nav list list-group">
				<li class="list-group-item"><a href="#mostpopular" data-toggle="tab">Most Popular Wishes</a></li>
				<li class="list-group-item"><a href="#fullfilled" data-toggle="tab">Fullfilled Wishes</a></li>
				<li class="active list-group-item"><a href="#current" data-toggle="tab">Current Wishes</a></li>
				<li class="list-group-item"><a data-toggle="tab" href="#recipient">Recipient</a></li>
			</ul>
			</br>
			<p>Search By Keyword Or Location</p>
			<div class="input-group">
				<input type="text" class="form-control" placeholder="City, State, Country.....other">
				<span class="input-group-btn">
				  <button class="btn btn-default" type="button">
					<span class="glyphicon glyphicon-search"></span>
				  </button>
				</span>
			</div>
		</div>
		<div class="col-md-9">
			<div class="tab-content">
				<div class="tab-pane" id="mostpopular">
					<h3 style="color:#006699;">Most Popular Wishes</h3>
				</div>
				<div class="tab-pane" id="fullfilled">
				</div>
				<div class="tab-pane active" id="current">
					<h3 style="color:#006699;">Current Wishes</h3>
					<?php 
					\yii2masonry\yii2masonry::begin([
						'clientOptions' => [
							'columnWidth' => 50,
							'itemSelector' => '.item'
						]
					]); 
					
					foreach($dataProvider->models as $wish){
						echo '<div class="item col-md-4"><div class="thumbnail">';
						echo '<img src="'.\Yii::$app->homeUrl.$wish->primary_image.'" class="img-responsive" alt="Image">';
						/////activities///
						if(!$wish->isFaved(\Yii::$app->user->id))
							echo '<div class="smp-links"><span title="Add to favourites" data-w_id="'.$wish->w_id.'" data-a_type="fav" class="fav-wish glyphicon glyphicon-heart-empty txt-smp-orange"></span></br>';
						else 
							echo '<div class="smp-links"><span title="You favourited it" data-w_id="'.$wish->w_id.'" data-a_type="fav" class="fav-wish glyphicon glyphicon-heart-empty txt-smp-blue"></span></br>';
						
						if(!$wish->isLiked(\Yii::$app->user->id))
							echo '<span title="Like it" data-w_id="'.$wish->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-green"></span></div>';
						else
							echo '<span title="You liked it" data-w_id="'.$wish->w_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-pink"></span></div>';
						//////////////////
						echo '<div class="smp-wish-desc">';
							echo '<p>Name : <span>'.$wish->wisher->username.'</span></p>
							<p>Wish For : <span>'.$wish->wish_title.'</span></p>
							<p>Location : <span>Location1</span></p>
							<p><a class="fnt-green" href="#">Read Happy Story</a> 
							&nbsp;<i class="fa fa-thumbs-o-up fnt-blue"></i> 2,432 Likes</p>';
						echo '</div>
						<div class="shareIcons"></div>';
						echo '</div></div>';
					} 
					\yii2masonry\yii2masonry::end(); ?>
				</div>
				<div class="tab-pane" id="recent">
				</div>
			</div>
		</div>
	</div>
	<script>
		$(".shareIcons").jsSocials({
			showLabel: false,
			showCount: false,
			shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "whatsapp"]
		});
		$(".like-wish, .fav-wish").on("click",function(){
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