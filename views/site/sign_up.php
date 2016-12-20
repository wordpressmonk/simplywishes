<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Join Today';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row page-header">
  <div class="container join-taday">
	<h3 class="smp-mg-bottom"><?= Html::encode($this->title) ?></h3>
  
<?php $form = ActiveForm::begin(['id' => 'contact-form','options' => ['class' => 'col-md-8']]); ?>
  
	   <?= $form->field($user, 'username')->textInput(['autofocus' => true])?>
	   
	   <?= $form->field($user, 'email')->label("Email Address") ?>
	 
	   <?= $form->field($profile, 'firstname')->label('First Name') ?>

	   <?= $form->field($profile, 'lastname')->label('last Name') ?>
	
	   <?= $form->field($profile, 'about')->textarea(['rows' => 6])?>
		
	   <div class="col-lg-4">
						<?= $form->field($profile, 'country')->dropDownList($countries,[
							'prompt'=>'--Select Country--',
							'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/get-states?country_id=').'"+$(this).val(), function( data ) 
							{
								$( "select#state_select" ).html( data ).change();
										
							});'
							]) ?>
		</div>
		<div class="col-lg-4">
						<?= $form->field($profile, 'state')->dropDownList([],[
							'id' => 'state_select',
							'prompt'=>'--Select State--',
							'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/get-cities?state_id=').'"+$(this).val(), function( data ) 
							{
								$( "select#city_select" ).html( data ).change();
										
							});'
						]); ?>
		</div>
		<div class="col-lg-4">
						<?= $form->field($profile, 'city')->dropDownList([],[
							'id' => 'city_select',
							'prompt'=>'--Select State--',
						]); ?>
					</div>
					

				<?= $form->field($user, 'password')->passwordInput() ?>
					
				<?= $form->field($user, 'verify_password')->passwordInput() ?>
					

	
	 <?= $form->field($profile, 'profile_image')->fileInput(['class' => 'form-control'])->label('Upload Profile Image') ?>
	  
	  </br>
      <span>Or Choose One</span>         
      <div class="gravatar thumbnail">
       <a class="profilelogo" for="images/lady1.jpg" ><img class="selected" src="<?=Yii::$app->homeUrl?>images/lady1.jpg"/></a>
		<a class="profilelogo" for="images/man1.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man1.jpg"/></a>
		<a class="profilelogo" for="images/lady2.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady2.jpg"/></a>
		<a class="profilelogo" for="images/man2.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man2.jpg"/></a>
		<a class="profilelogo" for="images/lady3.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady3.jpg"/></a>
		<a class="profilelogo" for="images/man3.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man3.jpg"/></a>
		<a class="profilelogo" for="images/lady4.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady4.jpg"/></a>
		<a class="profilelogo" for="images/man4.jpg" ><img src="<?=Yii::$app->homeUrl?>images/man4.jpg"/></a>
		<a class="profilelogo" for="images/lady5.jpg" ><img src="<?=Yii::$app->homeUrl?>images/lady5.jpg"/></a>
	  </div>
	
   <?= $form->field($profile, 'dulpicate_image')->hiddenInput(['value'=>'images/lady1.jpg'])->label(false) ?>	
   
	<div class="checkbox">
	
		<label class="checkbox-inline"><input data-toggle="modal" data-target="#termsmodal" type="checkbox" required class="terms" value="">
			Terms Of Use
		</label>

		<label  class="checkbox-inline"><input data-toggle="modal" data-target="#communitymodal" type="checkbox" required class="community" value="">
			Community Guidlines
		
		</label>
		<label  class="checkbox-inline"><input data-toggle="modal" data-target="#policymodal"  type="checkbox" required class="policy" value="">
			Privacy Policy	
		</label>
	</div></br>
	
	<!-- Terms modal Starts -->
	<div class="modal fade" id="termsmodal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Acceptance of Terms of Use; Modifications</h4>
		  </div>
		  <div class="modal-body">
			<p>SimplyWishes, Inc. (“SimplyWishes” “we” or “us” or “our”) owns and operates the website, 
			<a href="http://www.simplywishes.com">http://www.simplywishes.com</a>, the mobile and touch version and any websites or mobile applications 
			we have now or in the future that reference these Terms of Use (collectively, “Site”). 
			By using the Site and the services available via the Site accesses or uses the Site with crawlers, 
			robots, data mining or extraction tools or any other functionality.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary agree" data-cat="terms" data-id="#termsmodal">Agree</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Terms modal Ends -->
	
	<!-- Community modal Starts -->
	<div class="modal fade" id="communitymodal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Acceptance of Community Guidelines; Modifications</h4>
		  </div>
		  <div class="modal-body">
			<p>By using the Site and the services available via the Site, you agree to this Privacy Policy 
			and any additional terms applicable to certain programs in which you may elect to participate. You also 
			agree to the SimplyWishesTerms of Use, located at <a href="http://www.simplywishes.com/termsofuse">http://www.simplywishes.com/termsofuse</a>, which is 
			incorporated herein by reference and any reference to these Terms of Use herein shall be deemed to reference 
			and include the Terms of Use.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary agree" data-cat="community" data-id="#communitymodal">Agree</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Community modal Ends -->
	
	<!-- Privacy Policy Modal Starts -->
	<div class="modal fade" id="policymodal" tabindex="-1" role="dialog">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title">Acceptance of Privacy Modifications</h4>
		  </div>
		  <div class="modal-body">
			<p>By using the Site and the services available via the Site, you agree to this Privacy Policy and any additional
			terms applicable to certain programs in which you may elect to participate. You also agree to the SimplyWishesTerms
			of Use, located at <a href="http://www.simplywishes.com">http://www.simplywishes.com</a>, which is incorporated herein by reference and any 
			reference to these Terms of Use herein shall be deemed to reference and include the Terms of Use.</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-primary agree" data-cat="policy" data-id="#policymodal">Agree</button>
		  </div>
		</div>
	  </div>
	</div>
	<!-- Privacy Policy Modal Ends -->
	
	  <div class="form-group">
            <?= Html::submitButton('Join', ['class' => 'btn btn-success', 'name' => 'contact-button']) ?>
      </div>
	  
 <?php ActiveForm::end(); ?>

  </div>
</div>


<script type="text/javascript"  >
jQuery(document).ready(function(){
 $('ul.nav li.dropdown').hover(function() { 
	$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
		}, function() { 
		$(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
	}); 
});
 $('.agree').click(function(){ 
 	var cat = $(this).data('cat');
	var id = $(this).data('id');
	 $('.'+cat).prop('checked', true);
	$(id).modal('hide'); 
}); 

$('.profilelogo').click(function(){
 $('.profilelogo').find( "img" ).removeClass('selected'); 
  var val = $(this).attr('for');
  $(this).find( "img" ).addClass('selected'); 
  $("#userprofile-dulpicate_image").val(val);
});

</script>

