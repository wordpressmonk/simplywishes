<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$profile = UserProfile::find()->where(['user_id'=>$model->user_id])->one();
			
$this->title = $profile->firstname.' Wish Stories';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

	
<div class="editorial-create">
 <?php if (Yii::$app->session->hasFlash('success_happystory')): ?>

        <div class="alert alert-success" style="margin-top: 20px;">
            Your Story is Updated Successfully!!!.
        </div>
	<?php endif; ?>	
	
	<div class="row">	
		<div class="form-group col-md-6">
			<h1><?= $this->title ?></h1>
		</div>
		<div class="form-group col-md-6 ">	
		   <?php if(\Yii::$app->user->id == $model->user_id){ ?>
			 <?= Html::a('Update', ['update', 'id' => $model->hs_id], ['class' => 'btn btn-warning pull-right','style'=>"margin-top: 20px;"]) ?>
		   <?php } ?>
		</div>
	</div>	
	<?php	
		if(isset($model) && !empty($model))
		{		
			?>
				
			<div class="row">		
				<div class="form-group col-md-2">			
					<img src="<?=Yii::$app->homeUrl?><?php echo $model->story_image; ?>" height="100px"/>				
				</div>
				<div class="form-group col-md-10">					
				<p><?php echo $model->story_text; ?></p>				
				</div>								
			</div> 
			
			<?php			
		}
	?>
	
</div>