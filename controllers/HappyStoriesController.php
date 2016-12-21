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
			
			 $model->user_id = \Yii::$app->user->identity->id;
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
}
