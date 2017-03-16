<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl('site/login');
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Welcome to SimplyWishes, <br> You Got Grant For Your Wish </p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
