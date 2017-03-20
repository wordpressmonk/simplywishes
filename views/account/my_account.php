<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'My Account';
$this->params['breadcrumbs'][] = $this->title;
?>

<!--<script src="<?= Yii::$app->request->baseUrl?>/js/html5imageupload.js" type="text/javascript"></script>
 <link href="<?= Yii::$app->request->baseUrl?>/css/html5imageupload.css" rel="stylesheet">-->
 
<?php echo $this->render('_profilenew',['user'=>$user,'profile'=>$profile])?>
 
<div class="site-contact">
    <h1 class="fnt-green" ><?= Html::encode($this->title) ?></h1>

        <div class="row">

            <div class="col-lg-8">
		<?php if(Yii::$app->session->getFlash('success')!='') {?>
			<!--<div class="alert alert-success" role="alert">
				<strong> <?= Yii::$app->session->getFlash('success'); ?>.</strong>
			</div>-->
	
		<?php }
					$form = ActiveForm::begin(['id' => 'contact-form','options' => ['enctype'=>'multipart/form-data']]); ?>

                    <?= $form->field($user, 'username')->textInput(['autofocus' => true,'disabled' => true]) ?>

                    <?= $form->field($user, 'email') ?>

                    <?= $form->field($profile, 'firstname') ?>
					
					<?= $form->field($profile, 'lastname') ?>
					
                    <?= $form->field($profile, 'about')->textarea(['rows' => 6]) ?>
					
					<div class="col-lg-4">
						<?= $form->field($profile, 'country')->dropDownList($countries,[
							'prompt'=>'--Select Country--',
							'id' => 'country_select',
							'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/get-states?country_id=').'"+$(this).val(), function( data ) 
							{
								$( "select#state_select" ).html( data ).change();
										
							});'
							]) ?>
					</div>
					
					<div class="col-lg-4">
						<?= $form->field($profile, 'state')->dropDownList($states,[
							'id' => 'state_select',
							'prompt'=>'--Select State--',
							'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/get-cities?state_id=').'"+$(this).val(), function( data ) 
							{
								$( "select#city_select" ).html( data ).change();
										
							});'
						]); ?>
					</div>
					
					<div class="col-lg-4">
						<?= $form->field($profile, 'city')->dropDownList($cities,[
							'id' => 'city_select',
							'prompt'=>'--Select State--',
						]); ?>
					</div>
					<img src="<?= \Yii::$app->homeUrl.$profile->profile_image;?>" width="150" height="150" />
					
					<?php  echo $form->field($profile, 'profile_image')->fileInput(['class' => 'form-control'])->label('Upload Profile Image')   ?>
					
					
		<!--<div class="form-group field-userprofile-profile_image">
		<label class="control-label" for="userprofile-profile_image">Upload Profile Image</label>
		<br></br>
		<input type="hidden" name="UserProfile[profile_image]" value="">

		
		
		 <div class="dropzone" data-smaller="true" data-canvas-image-only="true" data-button-done="true"  data-originalsize="false" id="for_image" data-width="300" data-ajax="false" data-height="300" data-button-zoomout="false">
           <input type="file"  id="userprofile-profile_image" class="form-control" name="UserProfile[profile_image]"  />
		   
		  
		</div>
	
		<p class="help-block help-block-error"></p>
	 </div>-->
	 
	 
					</br>
      <span>Or Choose One</span>         
      <div class="gravatar thumbnail">
       <a class="profilelogo" for="images/lady1.jpg" ><img  src="<?=Yii::$app->homeUrl?>images/lady1.jpg"/></a>
		<a class="profilelogo" for="images/man1.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man1.jpg"/></a>
		<a class="profilelogo" for="images/lady2.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady2.jpg"/></a>
		<a class="profilelogo" for="images/man2.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man2.jpg"/></a>
		<a class="profilelogo" for="images/lady3.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady3.jpg"/></a>
		<a class="profilelogo" for="images/man3.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man3.jpg"/></a>
		<a class="profilelogo" for="images/lady4.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady4.jpg"/></a>
		<a class="profilelogo" for="images/man4.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man4.jpg"/></a>
		<a class="profilelogo" for="images/lady5.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady5.jpg"/></a>
	  </div>
	
   <?= $form->field($profile, 'dulpicate_image')->hiddenInput()->label(false) ?>	
   
					<h3  class="fnt-green" > Change Password </h3>
					<p> Change password if you want to, or leave it empty</p>
					
					<?= $form->field($user, 'password')->passwordInput() ?>
					
					<?= $form->field($user, 'verify_password')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Update', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

</div>

</div>

<script type="text/javascript" >
$('.profilelogo').click(function(){
 $('.profilelogo').find( "img" ).removeClass('selected'); 
  var val = $(this).attr('for');
  $(this).find( "img" ).addClass('selected'); 
  $("#userprofile-dulpicate_image").val(val);
});


/* 
$('.dropzone').html5imageupload({
		ghost: false,
	}); */

</script>


