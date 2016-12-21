<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\UserProfile;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = 'Happy Wish Stories';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

	
<div class="editorial-create">

    <h1>Happy Wish Stories</h1>
	
		<a class='btn btn-success pull-right' href="<?=Yii::$app->homeUrl?>happy-stories/create">Tell Us Your Story</a> 
	<?php
	
		if(isset($model) && !empty($model))
		{
			foreach($model as $user)
			{
				$profile = UserProfile::find()->where(['user_id'=>$user->user_id])->one();
			
					
				?>
				
			<div class="row">		
				<div class="form-group col-md-2">			
					<img src="<?=Yii::$app->homeUrl?><?= $user->story_image; ?>" height="100px"/>				
				</div>
				<div class="form-group col-md-8">
					
				<p> <?php echo substr($user->story_text,0,250)?>..!</p>
				<a href="<?= Url::to(["account/profile","id"=>$user->user_id]) ?>">By <?= $profile->firstname; ?> >></a>
				<a href="<?=Yii::$app->homeUrl?>happy-stories/story-details?id=<?= $user->hs_id; ?>" >Read More</a>
				
				</div>
				
				
			</div> 
			<?php
			}
		}
	?>
	
</div>