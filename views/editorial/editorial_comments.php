<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = 'Editorials';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editorial-create">

    <h1>Editorial</h1>
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
					<img src="<?=Yii::$app->homeUrl?><?php echo $model->e_image; ?>" height="100px"/>				
				</div>
				<div class="form-group col-md-8">
				<h4><?php echo $model->e_title; ?></h4>
				<p><?php echo $model->e_text ?></p>
				</div>
			</div>
			
			
			<div class="row">
			<h3 class="left" >Comments:</h3>
				
			<?php $form = ActiveForm::begin(['action' =>['editorial/editorial-comments']]); ?>
				 
					 <?= $form->field($listcomments, 'comments')->textarea(['rows' => 6])->label(false) ?>			
					 <?= $form->field($listcomments, 'e_id')->hiddeninput(['value'=>$model->e_id])->label(false) ?>			
						
					<div class="form-group">
						<?= Html::submitButton('Post', ['class' =>'btn btn-primary']) ?>
					</div>
					
				<?php ActiveForm::end(); ?>
					
			</div>
			
			<?php if(isset($comments) && !empty($comments)){ 
					foreach($comments as $tmp)
					{
						$profile = UserProfile::find()->where(['user_id'=>$tmp->user_id])->one();						
				?>
				  <div class="row">		
						<div class="form-group col-md-2">
							<img src="<?=Yii::$app->homeUrl?><?php echo $profile->profile_image; ?>" height="100px"/>				
						</div>
						<div class="form-group col-md-8">	
							<h4><?php echo $profile->firstname.' '.$profile->lastname ?></h4>						
							<p><?php echo $tmp->comments ?></p>
						</div>
				  </div>
			
				<?php } } ?>
				
			<?php			
		}
	?>
	
</div>
