<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Wish;
use dosamigos\ckeditor\CKEditor;
/* @var $this yii\web\View */
/* @var $model app\models\Editorial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="happy-stories-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>

   
		<?php
		$user_id = \Yii::$app->user->id;
		$wish = ArrayHelper::map(Wish::find()->where(['wished_by'=>$user_id])->orderBy('wish_title')->all(), 'w_id', 'wish_title');
			echo $form->field($model, 'wish_id')->dropDownList(
            $wish,           // Flat array ('id'=>'label')
            ['prompt'=>'--Wishes List--']    // options
        )->label('Wishes');  ?>
		
		 
		<?= $form->field($model, 'story_text')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]); ?>		 
   

   
	
	<?php if($model->isNewRecord){ 
		  echo $form->field($model, 'story_image')->fileInput(['class'=>'form-control'])->label('Image');
	 } else if($model->story_image != '' ) { ?>	
		<div class="form-group field-company-logo" >
			<label class="control-label" >Image</label>
				<img id='imagesorce' src="<?=Yii::$app->homeUrl.$model->story_image ?>" height="100px" />
				<a style="cursor:pointer" class="removelogo" >Change Image</a>
		</div>	
	<?php 	
			
			echo $form->field($model, 'story_image')->fileInput(['class'=>'form-control','style'=>'display:none'])->label(False);
		} else { 	
			echo $form->field($model, 'story_image')->fileInput(['class'=>'form-control'])->label('Image');
	} ?>
		 

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

 <script type="text/javascript"> 
  $(function(){	
			$('#happystories-story_image').change( function(event) {
				var tmppath = URL.createObjectURL(event.target.files[0]);
				$("#imagesorce").fadeIn("fast").attr('src',tmppath);
			});
  });  
  </script>
  
<script>
$(".removelogo").click(function() {	
				$( "#happystories-story_image" ).click();
		  });
</script>