<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Wish */

$this->title = 'Add a Wish';
$this->params['breadcrumbs'][] = ['label' => 'Wishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wish-create">

    <h1  class="fnt-green" ><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'categories' => $categories,
		'countries' => $countries,
		'states' => $states,
		'cities' => $cities
    ]) ?>

</div>
