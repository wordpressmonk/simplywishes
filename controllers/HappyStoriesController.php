<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use app\models\HappyStories;

class HappyStoriesController extends \yii\web\Controller
{
    public function actionIndex()
    {		
		$model = HappyStories::find()->orderBy('hs_id Desc')->all();				
        return $this->render('index', ['model' => $model]);
	
    }

	
	public function actionCreate()
    {
		 $model = new HappyStories();
	
		  
         if ($model->load(Yii::$app->request->post())) {
			
			 $model->user_id = \Yii::$app->user->id;
			$model->story_image = UploadedFile::getInstance($model, 'story_image');
				if(!empty($model->story_image)) {
					if(!$model->uploadImage())
						return;
				}
				
				if($model->save())
				    return $this->redirect(['index']);
				else 
					return $this->render('create', ['model' => $model]);
					
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	 public function actionStoryDetails($id)
    {		
		$model = HappyStories::findOne($id);		
        return $this->render('story_full', ['model' => $model]);
	
    }
	
	public function actionUpdate($id)
    {
        $model = HappyStories::findOne($id);
		$current_image = $model->story_image;
		$model->scenario = 'update_by_happystory_user';
        if ($model->load(Yii::$app->request->post())){
			
			/**		Image Uploaded for Update function Line 
			**/		
			$model->story_image = UploadedFile::getInstance($model, 'story_image');										
				if(!empty($model->story_image)){ 
					if(!$model->uploadImage())
						return;
				}else
					$model->story_image = $current_image;
				if($model->save())
				{	Yii::$app->session->setFlash('success_happystory');
					return $this->redirect(['story-details', 'id' => $model->hs_id]);
				} else {
					
					return $this->render('update', ['model' => $model,]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
}
