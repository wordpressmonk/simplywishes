<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\UserProfile;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$profile = UserProfile::find()->where(['user_id'=>$model->user_id])->one();

if(\Yii::$app->user->id == $model->user_id)	
	$this->title = 'My Happy Story';
else	
	$this->title = ucfirst($profile->firstname)."'s".' Happy Story ';

$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

	    \Yii::$app->view->registerMetaTag([
			'name' => 'og:title',
			'property' => 'og:title',
			'content' =>"Happy Story"
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'og:description',
			'property' => 'og:description',
			'content' =>$model->story_text
		]);
		\Yii::$app->view->registerMetaTag([
			'name' => 'og:image',
			'property' => 'og:image',
			'content' =>Url::to([$model->story_image],true)
		])
?>

<div class="wish-view">
  <div class="container my-profile">
	<div class="col-md-12 smp-mg-bottom">
	<?php if (Yii::$app->session->hasFlash('success_happystory')): ?>

        <div class="alert alert-success" style="margin-top: 20px;">
            Your Story is Updated Successfully!!!.
        </div>
	<?php endif; ?>	
	<h3 class="smp-mg-bottom fnt-green"><?=$this->title?></h3>
	
		<?php if(\Yii::$app->user->id == $model->user_id){ ?>
			<div class="pull-right" >
			 <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i> Update', ['update', 'id' => $model->hs_id], ['class' => 'btn btn-warning ','style'=>"margin-top: 20px;"]) ?>
			 
			 
			 <?= Html::a('<i class="fa fa-trash" aria-hidden="true"></i> Delete', ['delete', 'id' => $model->hs_id], ['class' => 'btn btn-danger deletecheck','style'=>"margin-top: 20px;"]) ?>
			</div>			 
		<?php } ?>
		<div class="col-md-3 happystory">
			
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
				
			<div class="shareIcons" data_text="Happy Story" data_url="<?= Url::to(['happy-stories/story-details','id'=>$model->hs_id],true)?>" ></div>


		</div>
		<div class="col-md-8">
			<p><?php echo $model->story_text; ?></p>
		</div>
	</div>
</div>
</div>
<script>
/* 	$(".shareIcons").jsSocials({
		showLabel: false,
		showCount: false,
		shares: ["facebook", "twitter", "googleplus", "pinterest", "linkedin", "whatsapp"]
	});
	 */
	$(".shareIcons").each(function(){
		var elem = $(this);
		elem.jsSocials({
		showLabel: false,
		showCount: false,
		shares: ["facebook","googleplus", "pinterest", "linkedin", "whatsapp",
		{
			share: "twitter",           // name of share
			via: "simply_wishes",       // custom twitter sharing param 'via' (optional)
			hashtags: "simplywishes,dream_come_true"   // custom twitter sharing param 'hashtags' (optional)
		}],
		url : elem.attr("data_url"),
		text: elem.attr("data_text"),
		});
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
	
	
	$(document).on('click', '.deletecheck', function(){ 
		if(confirm("Are Sure To Delete this Happy Story ?"))	
		else
			return false;		
	});
	
</script>