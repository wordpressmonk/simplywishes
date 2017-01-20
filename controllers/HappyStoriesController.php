<?php

namespace app\controllers;

use Yii;
use yii\web\UploadedFile;
use app\models\HappyStories;
use app\models\StoryActivity;

class HappyStoriesController extends \yii\web\Controller
{
    public function actionIndex()
    {		
		$stories = HappyStories::find()->orderBy('hs_id Desc')->all();				
        return $this->render('index', ['stories' => $stories]);
	
    }

	
	 public function actionMyStory()
    {			
		$stories = HappyStories::find()->where(['user_id'=>\Yii::$app->user->id])->orderBy('hs_id Desc')->all();
		return $this->render('my-story', ['stories' => $stories]);
		
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
				    return $this->redirect(['my-story']);
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
					//return $this->redirect(['story-details', 'id' => $model->hs_id]);
					return $this->redirect(['my-story']);
				} else {
					
					return $this->render('update', ['model' => $model,]);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	/**
	 * Like a story
	 * User has to be logged in to like a wish
	 * Param: wish id
	 * @return boolean
	 */
	public function actionLike($s_id,$type)
	{
		if(\Yii::$app->user->isGuest)
			return $this->redirect(['site/login','red_url'=>Yii::$app->request->referrer]);
		$story = $this->findModel($s_id);
		$activity = StoryActivity::find()->where(['story_id'=>$story->hs_id,'activity'=>$type,'user_id'=>\Yii::$app->user->id])->one();
		if($activity != null){
			$activity->delete();
			return "removed";
		}
			$activity = new StoryActivity();
		$activity->story_id = $story->hs_id;
		$activity->activity = $type;
		$activity->user_id = \Yii::$app->user->id;
		if($activity->save())
			return "added";
		else return false;
	}
	
    /**
     * Finds the story model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HappyStories::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 public function actionDelete($id)
    {
         $this->findModel($id)->delete();
        return $this->redirect(['my-story']); 
    }
	
	
}
