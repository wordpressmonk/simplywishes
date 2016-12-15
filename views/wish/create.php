<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Wish */

$this->title = 'Add Wish';
$this->params['breadcrumbs'][] = ['label' => 'Wishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'categories' => $categories
    ]) ?>

</div>
