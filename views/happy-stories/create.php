<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = 'Tell us Your Story';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="happy-stories-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
