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
			<!--<div class="row happystory">
				<div class="form-group col-md-8">
				<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>"><?php echo $tmp->e_title; ?></a>
				<p><?php echo substr($tmp->e_text,0,250)?>..!</p>
				<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>">Read More...!</a>
				</div>
				
				<div class="form-group col-md-2">
					<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>">
					<img src="<?=Yii::$app->homeUrl?><?php echo $tmp->e_image; ?>" height="100px"/></a>				
				</div>
				
			</div>-->
			
			<div class="row edit">
				<div class="form-group col-md-8">
					<p><?php echo $tmp->e_title; ?></p>
					<p><img src="<?=Yii::$app->homeUrl?><?php echo $tmp->e_image; ?>" height="100px"/></a>Author: Lella & Irina</p>
					<p>Date: 	<?php echo date("d/m/Y",strtotime($tmp->created_at)); ?></p>					
					<p><?php echo substr($tmp->e_text,0,250)?></p>
					<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>">Read More...!</a>
				</div>
				<div class="form-group col-md-1"></div>
				<div class="form-group col-md-2">				
					<a href="<?=Yii::$app->homeUrl?>editorial/editorial-page?id=<?php echo $tmp->e_id; ?>">
					<div class="shareIcons" data_text="" data_url=""></div>
					<div class="editrightimg">
					<img src="<?=Yii::$app->homeUrl?><?php echo $tmp->e_image; ?>" height="100px"/></a>	
					</div>					
				</div>
				
			</div>
			
			<?php
			}
		}
	?>
	
</div>


