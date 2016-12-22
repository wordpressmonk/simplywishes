<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = 'Update Your Story';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hs_id, 'url' => ['view', 'id' => $model->hs_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="editorial-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
