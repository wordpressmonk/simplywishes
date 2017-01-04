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

	
<div class="editorial-create smp-mg-bottom">

    <h3 class="fnt-green smp-mg-bottom"  >Happy Wish Stories</h3>
	
		<a class='btn btn-success pull-right' href="<?=Yii::$app->homeUrl?>happy-stories/create">Tell Us Your Story</a> 
		<?php
	
		foreach($stories as $story)
		{
		$profile = UserProfile::find()->where(['user_id'=>$story->user_id])->one();				
		?>
			<div class="col-md-10 happystory smp-mg-bottom">
				<div class="media"> 
					<div class="media-left"> 
						<img alt="64x64" src="<?=Yii::$app->homeUrl?><?= $story->story_image; ?>" class="media-object"   style="width: 200px;border: solid 2px #0cb370;">
						<span class="fnt-green"><i class="fa fa-thumbs-o-up fa-3x fnt-green"></i><?=$story->likesCount?>  likes</span>
					</div> 
					<div class="media-body"> 
						<!--<h4 class="media-heading">Top aligned media</h4>-->
						<a href="<?= Url::to(["account/profile","id"=>$story->user_id]) ?>">Author: <?= $story->author->fullname; ?></a>
						<p> <?=substr($story->story_text,0,450)?>..!</p>
						<a href="<?=Yii::$app->homeUrl?>happy-stories/story-details?id=<?= $story->hs_id; ?>" ><h5>Read More>></h5></a>
					</div> 
				</div>
			</div>

		<?php
		}
		?>
	
</div>