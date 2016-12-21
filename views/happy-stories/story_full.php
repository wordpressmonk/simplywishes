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

    <h1><?= $this->title ?></h1>
	

	<?php
	
		if(isset($model) && !empty($model))
		{		
			?>
				
			<div class="row">		
				<div class="form-group col-md-2">			
					<img src="<?=Yii::$app->homeUrl?><?php echo $model->story_image; ?>" height="100px"/>				
				</div>
				<div class="form-group col-md-8">
					
				<p><?php echo $model->story_text; ?></p>
				
				</div>
				
				
			</div> 
			
			<?php			
		}
	?>
	
</div>