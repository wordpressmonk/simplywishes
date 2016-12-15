<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Join Us';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

        <div class="row">
            <div class="col-lg-8">

                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($user, 'username')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($user, 'email') ?>

                    <?= $form->field($profile, 'firstname') ?>
					
					<?= $form->field($profile, 'lastname') ?>
					
                    <?= $form->field($profile, 'about')->textarea(['rows' => 6]) ?>
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
					
					<?= $form->field($profile, 'profile_image')->fileInput() ?>
					
					<?= $form->field($user, 'password')->passwordInput() ?>
					
					<?= $form->field($user, 'verify_password')->passwordInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>

</div>
