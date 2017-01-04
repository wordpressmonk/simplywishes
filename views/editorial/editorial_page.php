<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Editorial */

$this->title = 'Editorials';
$this->params['breadcrumbs'][] = ['label' => 'Editorials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="editorial-create">

    <h1 class="fnt-green" >Editorial</h1>
	
	<?php
	
		if(isset($model) && !empty($model))
		{
			foreach($model as $tmp)
			{
				?>
			<div class="row">		
				<div class="form-group col-md-2">
					<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>">
					<img src="<?=Yii::$app->homeUrl?><?php echo $tmp->e_image; ?>" height="100px"/></a>				
				</div>
				<div class="form-group col-md-8">
				<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>"><?php echo $tmp->e_title; ?></a>
				<p><?php echo substr($tmp->e_text,0,250)?>..!</p>
				</div>
			</div>
			<?php
			}
		}
	?>
	
</div>
