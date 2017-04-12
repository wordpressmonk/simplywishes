<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models\Category;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\SearchEditorial */
/* @var $dataProvider yii\data\ActiveDataProvider */
$categories =  ArrayHelper::map(Category::find()->all(), 'cat_id', 'title');

$this->title = 'My Drafts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editorial-index">

    <h1 class="fnt-green"  ><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

			  [
				'attribute' => 'category',
				'value' => 'categoryName',
				'filter' => Html::activeDropDownList($searchModel, 'category', $categories,['class'=>'form-control input-sm','prompt' => 'Select Recipient']),
			],
			
              'wish_title',
          
            	[
  'class' => 'yii\grid\ActionColumn',
  'template' => '{view}{update}{delete}',
  'buttons' => [
    'view' => function ($url, $model) {
        return Html::a('<span style="margin-left:5px" class="glyphicon glyphicon-eye-open"></span>', 'view-draft?id='.$model->w_id, [
                    'title' => Yii::t('app', 'View'),
        ]);
    },
	'update' => function ($url, $model) {
        return Html::a('<span style="margin-left:5px" class="glyphicon glyphicon-pencil"></span>', 'update-draft?id='.$model->w_id, [
                    'title' => Yii::t('app', 'Update'),
        ]);
    },
	'delete' => function ($url, $model) {
        return Html::a('<span style="margin-left:5px" class="glyphicon glyphicon-trash"></span>', 'delete-draft?id='.$model->w_id, [
                    'title' => Yii::t('app', 'Delete'),
					'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                   ],
        ]);
    },
  ],
],
        ],
    ]); ?>
</div>
