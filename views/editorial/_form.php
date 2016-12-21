<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\Editorial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="editorial-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

    <?= $form->field($model, 'e_title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'e_text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]); ?>		
    <?php // $form->field($model, 'e_image')->fileInput(['class' => 'form-control']) ?>

	
	<?php if($model->isNewRecord){ 
		  echo $form->field($model, 'e_image')->fileInput(['class'=>'form-control']);
	 } else if($model->e_image != '' ) { ?>	
		<div class="form-group field-company-logo" >
			<label class="control-label" >Image</label>
				<img id='imagesorce' src="<?=Yii::$app->homeUrl.$model->e_image ?>" height="100px" />
				<a style="cursor:pointer" class="removelogo" >Change Image</a>
		</div>	
	<?php 	
			
			echo $form->field($model, 'e_image')->fileInput(['class'=>'form-control','style'=>'display:none'])->label(False);
		} else { 	
			echo $form->field($model, 'e_image')->fileInput(['class'=>'form-control']);
	} ?>
		 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 <script type="text/javascript"> 
  $(function(){	
			$('#editorial-e_image').change( function(event) {
				var tmppath = URL.createObjectURL(event.target.files[0]);
				$("#imagesorce").fadeIn("fast").attr('src',tmppath);
			});
  });  
  </script>
  
<script>
$(".removelogo").click(function() {	
				$( "#editorial-e_image" ).click();
		  });
</script>