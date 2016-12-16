<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\Wish */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
<div class="col-md-8">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->dropDownlist($categories,['prompt'=>'--Select--']) ?>

    <?= $form->field($model, 'wish_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'summary_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'wish_description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'primary_image')->fileInput() ?>

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
							'prompt'=>'--Select State--',
						]); ?>
					</div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
</div>
