<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = $model->wish_title;
$this->params['breadcrumbs'][] = $this->title;
$wishstatus = array('0'=>"Active",'1'=>"In-Active");
$payoption = array('0'=>"Financial",'1'=>"Non-financial");

?>

<div class="editorial-view">

    <h1 class="fnt-green"  ><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-draft', 'id' => $model->w_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete-draft', 'id' => $model->w_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		
		 <?= Html::a('Back', ['my-drafts',], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [          
		  'categoryName',
		  'wish_title',

		   [
				 'label'=>'Expected cost',
				 'value' =>($model->non_pay_option == 1)?"-":$model->expected_cost,
		  ],
		  
		  'expected_date',
		  'in_return',
		  'who_can',
		  
		  [
				 'label'=>'Country',
				 'value' =>($model->country != 0)?$model->countryModel->name:"-",
		  ],
		  [
				 'label'=>'State',
				 'value' =>($model->state != 0)?$model->stateModel->name:"-",
		  ],
		  [
				 'label'=>'City',
				 'value' =>($model->city != 0)?$model->cityModel->name:"-",
		  ],
	
		 // 'non_pay_option',
		  [
				 'label'=>'Pay Option',
				 'value' =>$payoption[$model->non_pay_option],
		  ],
		  
		  
		  //'wish_status',
		  [
				 'label'=>'Status',
				 'value' =>$wishstatus[$model->wish_status],
		  ],
		  
        ],
    ]) ?>

</div>
