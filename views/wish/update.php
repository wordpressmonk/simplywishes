<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Wish */

$this->title = 'Update Wish: ' . $model->wish_title;
$this->params['breadcrumbs'][] = ['label' => 'Wishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->w_id, 'url' => ['view', 'id' => $model->w_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="wish-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'categories' => $categories,
		'countries' => $countries,
		'states' => $states,
		'cities' => $cities
    ]) ?>

</div>
