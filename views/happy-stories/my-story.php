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

<?php echo $this->render('@app/views/account/_profilenew',['user'=>$user,'profile'=>$profile])?>
	
<div class="col-md-8 editorial-create smp-mg-bottom">

    <h3 class="fnt-green smp-mg-bottom"  > My Happy Stories</h3>
	
	<?php if (Yii::$app->session->hasFlash('success_happystory')): ?>

        <div class="alert alert-success" style="margin-top: 20px;">
            Your Story is Updated Successfully!!!.
        </div>
	<?php endif; ?>	
	
	<?php if (Yii::$app->session->hasFlash('success_adminhappystory')): ?>

        <div class="alert alert-success" style="margin-top: 20px;">
            Your Story is Created Successfully waiting for Site Approvel !!!.
        </div>
	<?php endif; ?>	

		<a class='btn btn-success pull-right newtest' style="margin-top: -50px;" href="<?=Yii::$app->homeUrl?>happy-stories/create">Tell Your Story</a> 
		
		<?php
	if(isset($stories) && !empty($stories))
	{
		foreach($stories as $story)
		{
		$profile = UserProfile::find()->where(['user_id'=>$story->user_id])->one();				
		?>
			<div class="col-md-12 happystory smp-mg-bottom">
				<div class="media"> 
					<div class="media-left"> 
						<img alt="64x64" src="<?=Yii::$app->homeUrl?><?= $story->story_image; ?>" class="media-object"   style="width: 200px;border: solid 2px #0cb370;">
						<span ><i class="fa fa-thumbs-o-up fnt-green"></i>  <?=$story->likesCount?>  Likes </span>
					</div> 
					<div class="media-body"> 
		<?php if(\Yii::$app->user->id == $story->user_id){ ?>
			<div class="pull-right" >
			 <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> Update', ['update', 'id' => $story->hs_id], ['class' => 'btn btn-warning']) ?>
			 
			 <?php /* = Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Delete', ['delete', 'id' => $story->hs_id], ['class' => 'btn btn-danger deletecheck'])  */?>
			 
			 <!--<button class="btn btn-danger deletecheck" for="<?= $story->hs_id ?>" ><i class="fa fa-trash" aria-hidden="true"></i> Delete </button> -->
			</div> 
		<?php } ?>
						<!--<h4 class="media-heading">Top aligned media</h4>-->
						<a href="<?= Url::to(["account/profile","id"=>$story->user_id]) ?>">Author: <?= $story->author->fullname; ?></a>
						<p> <?=substr($story->story_text,0,450)?></p>
						<a href="<?=Yii::$app->homeUrl?>happy-stories/story-details?id=<?= $story->hs_id; ?>" ><h5>Read More</h5></a>
					</div> 
				</div>
			</div>

		<?php
		}
	} else {
		echo "Sorry, No more Story from you!!!.";
	}	
		?>
	
</div>
</div>
<script type="text/javascript">
$(document).on('click', '.deletecheck', function(){ 
		var checkmsg = confirm("Are Sure To Delete this Happy Story ?");	
		if(checkmsg == false)
		{
			return false;
		}	
		var id = $(this).attr('for');
		$.ajax({
			url : '<?=Url::to(['happy-stories/delete'])?>',
			type: 'POST',
			data: { id:id },
			success:function(data){
				location.reload();
			}
		});
	});
</script>
