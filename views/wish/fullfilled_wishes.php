<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<script src="<?= Yii::$app->request->baseUrl?>/src/masonry.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl?>/src/imagesloaded.js" type="text/javascript"></script>
    <div class="col-md-12 smp-mg-bottom">
		<div class="col-md-3">
			<h3 class="fnt-green" >Find A Wish</h3>
			<ul class="nav list list-group">
				<li class="list-group-item"><a href="<?=\Yii::$app->homeUrl?>wish/popular">Most Popular Wishes</a></li>
				<li class="active list-group-item"><a href="#fullfilled" data-toggle="tab">Fullfilled Wishes</a></li>
				<li class="list-group-item"><a href="<?=\Yii::$app->homeUrl?>wish/index">Current Wishes</a></li>
				<li class="list-group-item dropdown">
					<a data-toggle="collapse" data-target="#demo">Recipient 
						<i class="fa fa-plus text-success pull-right"></i>
						<i class="fa fa-minus text-success pull-right" style="display:none;"></i>
					</a>
					<ul id="demo" class="nav nav-stacked collapsed collapse">
						<?php
							$categories = \app\models\Category::find()->all();
							foreach($categories as $cat){
								echo "<li id='cat_".$cat->cat_id."'><a href='".\Yii::$app->homeUrl."wish/index?cat_id=$cat->cat_id'> $cat->title</a></li>";
							}
						?>
					</ul>
				</li>
			</ul>
			</br>
			<p>Search By Keyword Or Location</p>
			<div class="input-group">
				<input name="searh_field" type="text" class="form-control" placeholder="City, State, Country.....other">
				<span class="input-group-btn">
				  <button class="search-wish btn btn-default" type="button">
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
				<div class="tab-pane active" id="fullfilled">
					<h3 class="fnt-green" >Fullfilled Wishes</h3>
					<div class="grid"  data-masonry='{ "itemSelector": ".grid-item" }' id="current">
					<?php

					foreach($dataProvider->models as $wish){
						echo $wish->wishAsCard;;
					}
?>
					</div>
					<div style="display:none" align="center" id="loader_img" ><img src="<?= Yii::$app->homeUrl?>images/loading2.gif"></div>
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
  		//if ($(document).height() - win.height()-1 == scroll_top ) {
		if($(win).scrollTop() + $(win).height() == $(document).height()){
			console.log("scrolld");
			$("#loader_img").show();
  			$.ajax({
  				url: '<?=Url::to(['wish/scroll-granted'], true);?>',
  				dataType: 'html',
  				data: {'page':page},
  				success: function(html) {
  					var el = $(html);
  					//$(".grid").append(el).masonry( 'appended', el, false );
  					var $newElems = $( html ).css({ opacity: 0 });
  					$newElems.imagesLoaded(function(){
  						$newElems.animate({ opacity: 1 });
  						$(".grid").append(el);
							$(".shareIcons").each(function(){
								var elem = $(this);
									elem.jsSocials({
									showLabel: false,
									showCount: false,
									shares: ["facebook","googleplus", "pinterest", "linkedin", "whatsapp",
									{
										share: "twitter",           // name of share
										via: "simply_wishes",       // custom twitter sharing param 'via' (optional)
										hashtags: "simplywishes,dream_come_true"   // custom twitter sharing param 'hashtags' (optional)
									}],
									url : elem.attr("data_url"),
									text: elem.attr("data_text"),
								});
							});
	
						$(".grid").masonry( 'appended', el, true )
  					});
					if(html == '')
						page = false;
					else
						page = page+1;
					
						$("#loader_img").hide();
  				},
  				error:function(){
					$("#loader_img").hide();
  				}
  			});
			
  			//$container.masonry();
  			//page = page+1;
	}}
		});

	});
	
		$(".shareIcons").each(function(){
		var elem = $(this);
			elem.jsSocials({
			showLabel: false,
			showCount: false,
			shares: ["facebook","googleplus", "pinterest", "linkedin", "whatsapp",
			{
				share: "twitter",           // name of share
				via: "simply_wishes",       // custom twitter sharing param 'via' (optional)
				hashtags: "simplywishes,dream_come_true"   // custom twitter sharing param 'hashtags' (optional)
			}],
			url : elem.attr("data_url"),
			text: elem.attr("data_text"),
		});
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
	
		//search srcipt
	$(".search-wish").on("click",function(){		
		if($("input[name=searh_field]").val() != ''){
			var url = "<?=Url::to(['wish/search'])?>";
			window.location.href = url+"?match="+$("input[name=searh_field]").val();
		}
		else{
			var url = "<?=Url::to(['wish/granted'])?>";
			window.location.href = url;			
		}		
	});
	
	</script>
