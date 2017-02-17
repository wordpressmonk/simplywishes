<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserProfile;
use app\models\EditorialComments;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = 'Editorials';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editorial-create">

    <h1 class="fnt-green" >Editorial</h1>
    <?php if (Yii::$app->session->hasFlash('error_comments')): ?>

        <div class="alert alert-success">
            Oops!Something went wrong. Plesae try again later.
        </div>
	<?php endif; ?>	
    <?php if(Yii::$app->session->hasFlash('login_to_comment')): ?>

        <div class="alert alert-success">
            Please login to post a comment!
        </div>

    <?php endif; ?>		
	<?php
	
		if(isset($model) && !empty($model))
		{			
				?>
			<!---<div class="row">		
				<div class="form-group col-md-2">
					<img src="<?=Yii::$app->homeUrl?><?= $model->e_image; ?>" height="100px"/>				
				</div>
				<div class="form-group col-md-8">
				<h4><?= $model->e_title; ?></h4>
				<p><?= $model->e_text ?></p>				
				</div>
			</div>-->
			
			
			<div class="row edit">
				<div class="form-group col-md-8">
					<p>Compassionate Acts</p>
					<p><img src="<?=Yii::$app->homeUrl?><?php echo $model->e_image; ?>" height="100px"/></a>Author:Lella & Irina</p>
					<p>Date:2/17/2017</p>
					<p>"Not all of us can do great things.But, we can do small things with great love."(Mother Teresa)</p>
					<p>Throughout her life, Mother Teresa was guided by compassion which she embodled through serving
					"the poorest of the people" Throughout her life, Mother Teresa was guided by compassion which she embodled through serving
					"the poorest of the people" Throughout her life, Mother Teresa was guided by compassion which she embodled through serving
					"the poorest of the people"</p>
				</div>
				<div class="form-group col-md-1"></div>
				<div class="form-group col-md-2">				
					<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $model->e_id; ?>">
					<div class="shareIcons" data_text="" data_url=""></div>
					<div class="editrightimg">
					<img src="<?=Yii::$app->homeUrl?><?php echo $model->e_image; ?>" height="100px"/></a>	
					</div>
				</div>
				
			</div>
			
			<div class="row">
			<h3 class="left fnt-green" >Comments:</h3>
				
			<?php $form = ActiveForm::begin(['action' =>['editorial/editorial-comments']]); ?>
				 
					 <?= $form->field($listcomments, 'comments')->textarea(['rows' => 6])->label(false) ?>			
					 <?= $form->field($listcomments, 'e_id')->hiddeninput(['value'=>$model->e_id])->label(false) ?>			
						
					<div class="form-group">
						<?= Html::submitButton('Post', ['class' =>'btn btn-primary']) ?>
					</div>
					
				<?php ActiveForm::end(); ?>
					
			</div>
			
			<?php if(isset($comments) && !empty($comments)){ 
					foreach($comments as $user)
					{
						$profile = UserProfile::find()->where(['user_id'=>$user->user_id])->one();						
				?>
				  <div class="row">		
						<div class="form-group col-md-2">
							<img src="<?=Yii::$app->homeUrl?><?= $profile->profile_image; ?>" height="100px"/>				
						</div>
						<div class="form-group col-md-8">	
							<h4><?= $profile->firstname.' '.$profile->lastname ?></h4>						
							<p><?= $user->comments ?></p>
				<span class="on-reply" style="cursor: pointer;" for="<?= $user->e_comment_id ?>" ><b><u>Reply<u></b></span>
				
				<div  style="display:none;" id="<?php echo "replylist_".$user->e_comment_id ?>" class="comment-form2 reply full" data-plugin="comment-reply">	
					<a class="close" data-action="comment-close">X</a>
					<?php $form = ActiveForm::begin(['action' =>['editorial/commentreply']]); ?>				 
					 <?= $form->field($listcomments, 'comments')->textarea(['rows' => 3])->label(false) ?>			
					 <?= $form->field($listcomments, 'e_id')->hiddeninput(['value'=>$model->e_id])->label(false) ?>			
					 <?= $form->field($listcomments, 'parent_id')->hiddeninput(['value'=>$user->e_comment_id])->label(false) ?>
					 <div class="form-group">
						<?= Html::submitButton('Reply-Post', ['class' =>'btn btn-primary']) ?>
					</div>					
					<?php ActiveForm::end(); ?>
				</div>
				
						<?php 
							$replycomments = EditorialComments::find()->where(['parent_id'=>$user->e_comment_id])->orderBy('e_comment_id Desc')->all();
							
							if($replycomments)
							{
								foreach($replycomments as $replyuser)
								{
									$replyprofile = UserProfile::find()->where(['user_id'=>$replyuser->user_id])->one();	
									?>
						<div class="row">		
							<div class="form-group col-md-1">
							<img src="<?=Yii::$app->homeUrl?><?= $replyprofile->profile_image; ?>" height="50px"/>				
						</div>
						<div class="form-group col-md-10">	
							<h5><?= $replyprofile->firstname.' '.$replyprofile->lastname; ?></h5>						
							<p><?= $replyuser->comments ?></p>
						</div>	
						</div>	
									<?php
								}
							}		
						?>
				
				
						</div>
				  </div>
			
				<?php } } ?>
				
			<?php			
		}
	?>
	
</div>


<script>
$(document).ready(function(){
    $(".on-reply").click(function(){ 
		var id = $(this).attr("for");		
		$("#replylist_"+id).show();
    });
	$(".close").click(function(){ 
		$(this).parent().hide();
    });
});
</script>
<script>
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
</script>

