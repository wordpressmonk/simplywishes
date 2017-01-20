<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

?>
<div class="password-reset">
    <p>Hi, Hello!!!.</p>

    <p><?= Html::encode($body) ?></p>
	<?php if($phonenumber){ ?>
		<p>Contact Number :- <?=  Html::encode($phonenumber) ?></p>
	<?php } ?>
</div>
