<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl('site/login');
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Welcome to SimplyWish, <br> Your Registration has been Successfully Completed !!!.  </p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>