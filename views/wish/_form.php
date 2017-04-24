<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Wish */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
<div class="col-md-12">
    <?php $form = ActiveForm::begin(['id' => 'draft_form']); ?>

    <?= $form->field($model, 'category')->dropDownlist($categories,['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'wish_title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'summary_title')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'wish_description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]); ?>

	<?php if(!empty($model->primary_image)) {  ?>
		 <img src="<?= \Yii::$app->homeUrl.$model->primary_image;?>" width="150" height="150" />
	<?php } ?>	
	

    <?php  echo $form->field($model, 'primary_image')->fileInput(['class' => 'form-control',"onChange"=>"upload();return false;"]) ?>

	<?php echo $form->field($model, 'primary_image_name')->hiddenInput(['value'=>(!empty($model->primary_image))?$model->primary_image:""])->label(false); ?>
		
	<div class="row">
					<div class="col-lg-4">
						<?= $form->field($model, 'country')->dropDownList($countries,[
							'prompt'=>'--Select Country--',
							'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/get-states?country_id=').'"+$(this).val(), function( data ) 
							{
								$( "select#state_select" ).html( data ).change();
										
							});'
							]) ?>
					</div>
					<div class="col-lg-4">
						<?= $form->field($model, 'state')->dropDownList($states,[
							'id' => 'state_select',
							'prompt'=>'--Select State--',
							'onchange'=>'$.post( "'.Yii::$app->urlManager->createUrl('site/get-cities?state_id=').'"+$(this).val(), function( data ) 
							{
								$( "select#city_select" ).html( data ).change();
										
							});'
						]); ?>
					</div>
					<div class="col-lg-4">
						<?= $form->field($model, 'city')->dropDownList($cities,[
							'id' => 'city_select',
							'prompt'=>'--Select City--',
						]); ?>
					</div>
	</div>
	<div class="row">
			<div class="col-lg-6">
		<?php //echo '<label class="control-label" for="wish-expected_date">Issue Date</label>'; ?>
				<?php /*DatePicker::widget([
						'model' => $model, 
						'attribute' => 'expected_date',
						'options' => ['placeholder' => 'Select issue date ...'],
						'pluginOptions' => [
							'format' => 'dd-mm-yyyy',
							'todayHighlight' => true
						]
					]) */ ?>
					
			<?= $form->field($model, 'expected_date')->widget(
                    DatePicker::className(),
                    [
						'attribute' => 'expected_date',
						'options' => ['placeholder' => 'Select issue date ...'],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
							'todayHighlight' => true
                        ]
                    ]
                ); ?>
				
			</div>
			<div class="col-lg-6">
				
			</div>
			
	</div>
	
	 <?php  echo $form->field($model, 'non_pay_option')->radioList(['0'=>'Financial','1'=>'Non-financial','2'=>'Decide Later'],['onclick' => "$(this).val($('input:radio:checked').val())"])->label(false); ?>
	 
	<!-- Financial Begin --->
	
		<?= $form->field($model, 'expected_cost')->textInput(['maxlength' => true])?>
		
	<!-- Financial End --->
	
	<!-- NON Financial Begin --->
		
	<?= $form->field($model, 'show_mail_status')->checkbox(['value' => '1']);	?>
	<?= $form->field($model, 'show_mail')->textInput(['maxlength' => true,'class'=>'form-control test']) ?>
	
	<?= $form->field($model, 'show_person_status')->checkbox(['value' => '1']);	?>
	<div class="row">
			<div class="col-lg-6">
	<?= $form->field($model, 'show_person_location')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-lg-6">
		
	<?= $form->field($model, 'show_person_date')->widget(
                    DatePicker::className(),
                    [
						'attribute' => 'expected_date',
						'options' => ['placeholder' => 'Select issue date ...'],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
							'todayHighlight' => true
                        ]
                    ]
                ); ?>
			
	</div>
			</div>
	<?= $form->field($model, 'show_reserved_status')->checkbox(['value' => '1']);	?>
	<?= $form->field($model, 'show_reserved_name')->textInput(['maxlength' => true]) ?>
	<div class="row">
	<div class="col-lg-6">
	<?= $form->field($model, 'show_reserved_location')->textInput(['maxlength' => true]) ?>
	</div>
	<div class="col-lg-6">
	<?= $form->field($model, 'show_reserved_date')->widget(
                    DatePicker::className(),
                    [
						'attribute' => 'expected_date',
						'options' => ['placeholder' => 'Select issue date ...'],
                        'pluginOptions' => [
                            'format' => 'dd-mm-yyyy',
							'todayHighlight' => true
                        ]
                    ]
                ); ?>
				
	</div>
			</div>
	<?= $form->field($model, 'show_other_status')->checkbox(['value' => '1']);	?>
	<?= $form->field($model, 'show_other_specify')->textInput(['maxlength' => true]) ?>
	
	<div class="form-group" id="agree_check" >			
		<input type="checkbox" checked="checked" disabled="disabled" class="msg" name="i_agree_decide" id="i_agree_decide" value="1" > I understand that the grantor will fulfill this wish in the manner specified by you within one month of the date that the grantor accepts this wish. In the meanwhile, this wish will be marked as "In Progress" and after one month, it will be marked as "Fulfilled". You should update or ressubmit your wish if it has not been fulfilled after one month. </input>
	</div>
			
	<!-- NON Financial End --->

	
	<?= $form->field($model, 'who_can')->textArea()?>
	<?= $form->field($model, 'in_return')->textArea()?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

	<?php 
		 if($model->isNewRecord)
			echo $form->field($model, 'auto_id')->hiddenInput()->label(false)  
	?>
	
    <?php ActiveForm::end(); ?>
</div>
</div>

<script type="text/javascript" >
$( document ).ready(function() {
	// Temp this Option is avaliable
	//$(".field-wish-non_pay_option").hide();	
/* 	$("#wish-expected_cost").removeAttr("readonly");	
	
	
     $("#wish-non_pay_option").change(function(){
		 if($(this).prop("checked") == true){
			$("#wish-expected_cost").attr("readonly","readonly");	
		 }
		 else if($(this).prop("checked") == false){
			 $("#wish-expected_cost").removeAttr("readonly");	
		 }
	}); */
	
	$(".field-wish-expected_cost").hide();
	$(".field-wish-show_mail_status").hide();
	$(".field-wish-show_person_status").hide();
	$(".field-wish-show_reserved_status").hide();
	$(".field-wish-show_other_status").hide();
	$(".field-wish-show_mail").hide();
	$(".field-wish-show_person_location").hide();
	$(".field-wish-show_person_date").hide();
	$(".field-wish-show_reserved_name").hide();
	$(".field-wish-show_reserved_location").hide();
	$(".field-wish-show_reserved_date").hide();
	$(".field-wish-show_other_specify").hide();
	$("#agree_check").hide();
			
	$(".field-wish-show_mail").css("margin", " 0 0 0 50px");
	$(".field-wish-show_person_location").css("margin", " 0 0 0 50px");
	$(".field-wish-show_person_date").css("margin", " 0 0 0 50px");
	$(".field-wish-show_reserved_name").css("margin", " 0 0 0 50px");
	$(".field-wish-show_reserved_location").css("margin", " 0 0 0 50px");
	$(".field-wish-show_reserved_date").css("margin", " 0 0 0 50px");
	$(".field-wish-show_other_specify").css("margin", " 0 0 0 50px");
	
     $("#wish-non_pay_option").on("change",function(){
			var pay_option = $(this).val();
			if(parseInt(pay_option) == parseInt('0'))
			{
				$(".field-wish-expected_cost").show();
				$(".field-wish-show_mail_status").hide();
				$(".field-wish-show_person_status").hide();
				$(".field-wish-show_reserved_status").hide();
				$(".field-wish-show_other_status").hide();
				$(".field-wish-show_mail").hide();
				$(".field-wish-show_person_location").hide();
				$(".field-wish-show_person_date").hide();
				$(".field-wish-show_reserved_name").hide();
				$(".field-wish-show_reserved_location").hide();
				$(".field-wish-show_reserved_date").hide();
				$(".field-wish-show_other_specify").hide();
				$("#agree_check").hide();
			} else if(parseInt(pay_option) == parseInt('1'))
			{
				$(".field-wish-expected_cost").hide();
				$(".field-wish-show_mail_status").show();
				$(".field-wish-show_person_status").show();
				$(".field-wish-show_reserved_status").show();
				$(".field-wish-show_other_status").show();
				$(".field-wish-show_mail").show();
				$(".field-wish-show_person_location").show();
				$(".field-wish-show_person_date").show();
				$(".field-wish-show_reserved_name").show();
				$(".field-wish-show_reserved_location").show();
				$(".field-wish-show_reserved_date").show();
				$(".field-wish-show_other_specify").show();
				$("#agree_check").show();  
				
			} else if(parseInt(pay_option) == parseInt('2'))
			{
				
				$(".field-wish-expected_cost").hide();
				$(".field-wish-show_mail_status").hide();
				$(".field-wish-show_person_status").hide();
				$(".field-wish-show_reserved_status").hide();
				$(".field-wish-show_other_status").hide();
				$(".field-wish-show_mail").hide();
				$(".field-wish-show_person_location").hide();
				$(".field-wish-show_person_date").hide();
				$(".field-wish-show_reserved_name").hide();
				$(".field-wish-show_reserved_location").hide();
				$(".field-wish-show_reserved_date").hide();
				$(".field-wish-show_other_specify").hide();
				$("#agree_check").hide();
			}				
			
		});
	
	
	<?php if($model->non_pay_option == 0)
			{ ?>
			$(".field-wish-expected_cost").show();	
	<?php } else if($model->non_pay_option == 1){ ?>
			$(".field-wish-expected_cost").hide();
			$(".field-wish-show_mail_status").show();
			$(".field-wish-show_person_status").show();
			$(".field-wish-show_reserved_status").show();
			$(".field-wish-show_other_status").show();
			$(".field-wish-show_mail").show();
			$(".field-wish-show_person_location").show();
			$(".field-wish-show_person_date").show();
			$(".field-wish-show_reserved_name").show();
			$(".field-wish-show_reserved_location").show();
			$(".field-wish-show_reserved_date").show();
			$(".field-wish-show_other_specify").show();
				
	<?php } else if($model->non_pay_option == 2){ ?>
			$(".field-wish-expected_cost").hide();
			$(".field-wish-show_mail_status").hide();
			$(".field-wish-show_person_status").hide();
			$(".field-wish-show_reserved_status").hide();
			$(".field-wish-show_other_status").hide();
			$(".field-wish-show_mail").hide();
			$(".field-wish-show_person_location").hide();
			$(".field-wish-show_person_date").hide();
			$(".field-wish-show_reserved_name").hide();
			$(".field-wish-show_reserved_location").hide();
			$(".field-wish-show_reserved_date").hide();
			$(".field-wish-show_other_specify").hide();
	<?php } ?>
});
</script>

<script type="text/javascript" >
 function upload(){
  data = new FormData();
  data.append('file', $('#wish-primary_image')[0].files[0]);
  var imgname  =  $('#wish-primary_image').val();
  var size  =  $('#wish-primary_image')[0].files[0].size;
  var ext =  imgname.substr( (imgname.lastIndexOf('.') +1) );
  var display_name = imgname.substr( (imgname.lastIndexOf('\\') +1) );
  $.ajax({
        url: 'upload-file',
        type: "POST",
        data: data,
        enctype: 'multipart/form-data',
        processData: false,  // tell jQuery not to process the data
        contentType: false,
        success: function(json){      
			$("#wish-primary_image_name").val(json);
			
        }
  });
}
 
</script>

<style>
#wish-non_pay_option label{
	margin-left : 25px  !important
}

</style>
