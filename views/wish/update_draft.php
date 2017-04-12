
	
<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\Wish */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Update Wish: ' . $model->wish_title;
$this->params['breadcrumbs'][] = ['label' => 'Wishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->w_id, 'url' => ['view', 'id' => $model->w_id]];
$this->params['breadcrumbs'][] = 'Update';

$wishstatus = array('0'=>"Active",'1'=>"In-Active");
?>

<?php echo $this->render('@app/views/account/_profilenew',['user'=>$user,'profile'=>$profile])?>

<div class=" col-md-8 wish-update">

    <h1 class="fnt-green"  ><?= Html::encode($this->title) ?></h1>
	
<div class="row">
<div class="col-md-12">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->dropDownlist($categories,['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'wish_title')->textInput(['maxlength' => true]) ?>

	<?= $form->field($model, 'wish_description')->widget(CKEditor::className(), [
        'options' => ['rows' => 6],
        'preset' => 'basic'
    ]); ?>


    <?= $form->field($model, 'primary_image')->fileInput(['class' => 'form-control']) ?>
	
	
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
	
	<?= $form->field($model, 'wish_status')->dropDownList($wishstatus) ?>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

	<?php 
		 if($model->isNewRecord)
			echo $form->field($model, 'auto_id')->textInput()->label(false)  
	?>
	
    <?php ActiveForm::end(); ?>
</div>
</div>

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
