<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>
<script src="<?= Yii::$app->request->baseUrl?>/src/masonry.js" type="text/javascript"></script>
<script src="<?= Yii::$app->request->baseUrl?>/src/imagesloaded.js" type="text/javascript"></script>	
	<?php echo $this->render('_profile',['user'=>$user,'profile'=>$profile])?>
	<!-- To replace tab as link remove data-toggle=tab and replace href with link-->
	<ul class="nav nav-tabs smp-mg-bottom" role="tablist">
	  <li role="presentation" class="active">
		<a href="#activewish" role="tab" data-toggle="tab">Active Wishes</a>
	  </li>
	  <li role="presentation">
		<a href="<?=\Yii::$app->homeUrl?>account/my-fullfilled?id=<?=$user->id?>" role="tab" >Fullfilled Wishes</a>
	  </li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active grid" id="activewish">
			<?php foreach($dataProvider->models as $wish){
				echo $wish->htmlForProfileOther;
			}?>
		</div>
		<div role="tabpanel" class="tab-pane" id="fullfilledwish">
			
		</div>
	  </div>
	<script>
	
		var $container = $('.grid');
  					$container.imagesLoaded(function(){
  						$container.animate({ opacity: 1 });
						$(".shareIcons").each(function(){
								var elem = $(this);
									elem.jsSocials({
									showLabel: false,
									showCount: false,
									shares: ["facebook","googleplus", "pinterest", "linkedin", 
									{
										share: "twitter",           // name of share
										via: "simply_wishes",       // custom twitter sharing param 'via' (optional)
										hashtags: "simplywishes,dream_come_true"   // custom twitter sharing param 'hashtags' (optional)
									}],
									url : elem.attr("data_url"),
									text: elem.attr("data_text"),
								});
							});
							$container.masonry();
  					});
					
	/* var $container = $('.grid');
  	$container.masonry();
	$(".shareIcons").jsSocials({
		showLabel: false,
		showCount: false,
		shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin"]
	}); */
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