<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserProfile;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$profile = UserProfile::find()->where(['user_id'=>$model->user_id])->one();
			
//$this->title = $profile->firstname.' Wish Stories';
$this->title = 'My Happy Story';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="wish-view">
  <div class="container my-profile">
	<div class="col-md-12 smp-mg-bottom">
	<?php if (Yii::$app->session->hasFlash('success_happystory')): ?>

        <div class="alert alert-success" style="margin-top: 20px;">
            Your Story is Updated Successfully!!!.
        </div>
	<?php endif; ?>	
	<h3 class="smp-mg-bottom"><?=$this->title?></h3>
		<?php if(\Yii::$app->user->id == $model->user_id){ ?>
			 <?= Html::a('Update', ['update', 'id' => $model->hs_id], ['class' => 'btn btn-warning pull-right','style'=>"margin-top: 20px;"]) ?>
		<?php } ?>
		<div class="col-md-3">
			<div class="">
				<img src="<?=Yii::$app->homeUrl?><?php echo $model->story_image; ?>"   class="img-responsive" alt="my-profile-Image"><br>
				<p><i class="fa fa-thumbs-o-up fnt-green"></i> <?=$model->likesCount?> Likes &nbsp;
				<?php

				  if(!$model->isLiked(\Yii::$app->user->id))
					echo  '<span title="Like it" data-w_id="'.$model->hs_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-green"></span>';
				  else
					echo  '<span title="You liked it" data-w_id="'.$model->hs_id.'" data-a_type="like" class="like-wish glyphicon glyphicon glyphicon-thumbs-up txt-smp-pink"></span>';
				?>
				<!--<i class="fa fa-save txt-smp-orange"></i> &nbsp;
				<i class="fa fa-thumbs-o-up txt-smp-green"></i>--> </p>
				<div class="shareIcons"></div>
			</div>
		</div>
		<div class="col-md-8">
			<p><?php echo $model->story_text; ?></p>
		</div>
	</div>
</div>
</div>
<script>
	$(".shareIcons").jsSocials({
		showLabel: false,
		showCount: false,
		shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "whatsapp"]
	});
	$(document).on('click', '.like-wish', function(){ 
	//$(".like-wish, .fav-wish").on("click",function(){
		var s_id = $(this).attr("data-w_id");
		var type = $(this).attr("data-a_type");
		var elem = $(this);
		$.ajax({
			url : '<?=Url::to(['happy-stories/like'])?>',
			type: 'GET',
			data: {s_id:s_id,type:type},
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