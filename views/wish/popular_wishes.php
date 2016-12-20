<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<script src="<?= Yii::$app->request->baseUrl?>/src/masonry.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl?>/src/imagesloaded.js" type="text/javascript"></script>
    <div class="col-md-12">
		<div class="col-md-3">
			<h3>Find A Wish</h3>
			<ul class="nav list list-group">
				<li class="active list-group-item"><a href="#mostpopular" data-toggle="tab">Most Popular Wishes</a></li>
				<li class="list-group-item"><a href="<?=\Yii::$app->homeUrl?>wish/granted">Fullfilled Wishes</a></li>
				<li class="list-group-item"><a href="<?=\Yii::$app->homeUrl?>wish/index">Current Wishes</a></li>
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
				<div class="tab-pane active" id="mostpopular">
					<h3 style="color:#006699;">Most Popular Wishes</h3>
					<div class="grid"  data-masonry='{ "itemSelector": ".grid-item" }'>
					<?php

					foreach($dataProvider->models as $wish){
						echo $wish->wishAsCard;;
					}
					?>
					</div>
				</div>
				<div class="tab-pane" id="fullfilled">
				</div>
				<div class="tab-pane"  id="current">
					<h3 style="color:#006699;">Current Wishes</h3>

				</div>
				<div class="tab-pane" id="recent">
				</div>
			</div>
		</div>
	</div>
	<script>
  $(window).load(function() {
  	var win = $(window);
  	var page = 1;
  	var $container = $('.grid');
  	$container.masonry();
  	// Each time the user scrolls
  	win.scroll(function() {
		console.log($(document).height() - win.height(),"total");
		var scroll_top = Math.round(win.scrollTop());
		console.log(scroll_top,"top");
  		// End of the document reached?
		if(page){
  		if ($(document).height() - win.height()-1 == scroll_top ) {
			console.log("scrolld");
  			$.ajax({
  				url: '<?=Url::to(['wish/scroll-popular'], true);?>',
  				dataType: 'html',
  				data: {'page':page},
  				success: function(html) {
  					var el = $(html);
  					//$(".grid").append(el).masonry( 'appended', el, false );
  					var $newElems = $( html ).css({ opacity: 0 });
  					$newElems.imagesLoaded(function(){
  						$newElems.animate({ opacity: 1 });
  						$(".grid").append(el);
						$(".shareIcons").jsSocials({
							showLabel: false,
							showCount: false,
							shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "whatsapp"]
						});
						$(".grid").masonry( 'appended', el, true )
  					});
					if(html == '')
						page = false;
					else
						page = page+1;
  				},
  				error:function(){
  				}
  			});
  			//$container.masonry();
  			
			}}
		});

	});
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
