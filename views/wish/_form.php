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
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->dropDownlist($categories,['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'wish_title')->textInput(['maxlength' => true]) ?>

    <?php // $form->field($model, 'summary_title')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'wish_description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]); ?>


    <?php // $form->field($model, 'primary_image')->fileInput(['class' => 'form-control',"onChange"=>"upload();return false;"]) ?>
    <?= $form->field($model, 'primary_image')->fileInput(['class' => 'form-control']) ?>
	
	<?php // $form->field($model, 'primary_image_name')->textInput() ?>
		
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
				<?= $form->field($model, 'expected_cost')->textInput(['maxlength' => true ])?>
			</div>
			
	</div>
	<?= $form->field($model, 'non_pay_option')->checkbox(['value' => '1']);	?>
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
	$("#wish-expected_cost").removeAttr("readonly");	
	
	
     $("#wish-non_pay_option").change(function(){
		 if($(this).prop("checked") == true){
			$("#wish-expected_cost").attr("readonly","readonly");	
		 }
		 else if($(this).prop("checked") == false){
			 $("#wish-expected_cost").removeAttr("readonly");	
		 }
	});
	<?php if($model->non_pay_option == 1)
	 { ?>
		$("#wish-expected_cost").attr("readonly","readonly");			
	<?php } ?>	 
	
});
</script>

<script type="text/javascript" >
/* function upload(){
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
 */
</script>
