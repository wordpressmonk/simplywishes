<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = "View Happy Stories";
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editorial-view">

    <h1 class="fnt-green"  ><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update-new', 'id' => $model->hs_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->hs_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
		
		 <?= Html::a('All Sotries', ['permission',], ['class' => 'btn btn-success']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'user_id',
            'wish_id',
			
            'story_text:ntext',
           // 'e_image',
			[
                'attribute'=>'Image',
				'value'=>!empty($model->story_image)?Yii::$app->homeUrl.$model->story_image:'',
				 'format' => !empty($model->story_image)?['image',['height'=>'100px']]:'text',
				
            ],	
           
        ],
    ]) ?>

</div>
