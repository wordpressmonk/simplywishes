<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>	
	<?php echo $this->render('_profile',['user'=>$user,'profile'=>$profile])?>
	<h3 class="smp-mg-bottom">Inbox</h3>
	<div class="message">
		<ul class="list-group">
		<?php 		
			foreach($messages as $key=>$msg){
				$profile = \app\models\Userprofile::find()->where(['user_id'=>$key])->one();
				echo '<li class="list-group-item">
					<a class="smp_expand" data-toggle="collapse" title="Click here To View Conversation">
						<div class="list-icon">
							<img src="'.\Yii::$app->homeUrl.$profile->profile_image.'" alt="">
						</div>
						<div class="list-group-item-heading">'.$profile->fullname.'</div>
						<p class="list-group-item-text">
						<span class="label label-primary pull-right">Date:'.$msg['created_at'].'</span></p>
					</a>
					<ul class="collapse detail">';
						echo '<li class="media media_textbox">
							<div class="form-group">
								<label for="message">Enter Your Message</label>
								<textarea id="'.$key.'_msg" class="form-control" rows="2"></textarea>
							</div>
						</li>
						<li class="media media_button"><button type="button" data-send_to="'.$key.'" class="send-msg btn btn-primary ">Reply</button></li>';
					foreach($msg['threads'] as $thread){
						$profile = \app\models\Userprofile::find()->where(['user_id'=>$thread['send_by']])->one();
						echo '<li class="media">
						  <div class="media-left list-icon">
							 <img src="'.\Yii::$app->homeUrl.$profile->profile_image.'" alt="">
						  </div>
						  <div class="media-body">
							<h4 class="media-heading">'.$profile->fullname.'</h4>
							<p class="list-group-item-text">'.$thread['text'].'</p>
							<span class="label label-primary pull-right">Date:'.$thread['created_at'].'</span>
						  </div>
						</li>';
					}
						
					
					echo '</ul>
					</li>';
			}
		?>

		</ul>
	</div>
	<script>
	//jQuery(document).ready(function(){
	$('ul.nav li.dropdown').hover(function() {
		$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
			}, function() {
			$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
		});
		$(".shareIcons").jsSocials({
			showLabel: false,
			showCount: false,
			shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "whatsapp"]
		});
		$(".smp_expand").on( "click", function() {
			$(this).next().slideToggle(200);
			$(this).parent().siblings().children().next().slideUp();
			$('li').removeClass('active');
			$(this).parent('li').addClass('active');
		});

		$(".send-msg").on("click",function(){			
			var send_to = $(this).attr('data-send_to');
			var msg = $('#'+send_to+'_msg').val();
			console.log(msg);
			var send_from = "<?=\Yii::$app->user->id?>";
			$.ajax({
				url : '<?=Url::to(['account/reply-message'])?>',
				type : 'POST',
				data : {msg:msg,send_from:send_from,send_to:send_to},
				success: function(response){
					console.log("response");
				}
			});
		});
	

	//});
	</script>