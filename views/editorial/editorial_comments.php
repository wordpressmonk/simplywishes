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
			<div class="row">		
				<div class="form-group col-md-2">
					<img src="<?=Yii::$app->homeUrl?><?= $model->e_image; ?>" height="100px"/>				
				</div>
				<div class="form-group col-md-8">
				<h4><?= $model->e_title; ?></h4>
				<p><?= $model->e_text ?></p>				
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


