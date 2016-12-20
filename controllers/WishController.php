<?php

namespace app\controllers;

use Yii;
use app\models\Wish;
use app\models\Activity;
use app\models\Category;
use app\models\search\SearchWish;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
/**
 * WishController implements the CRUD actions for Wish model.
 */
class WishController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Wish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchWish();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$dataProvidermostpopular = $searchModel->searchmostpopular(Yii::$app->request->queryParams);
        return $this->render('current_wishes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvidermostpopular' => $dataProvidermostpopular,
        ]);
    }

    /**
     * Displays a single Wish model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Wish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Wish();
		$model->scenario = 'create';
		$categories =  ArrayHelper::map(Category::find()->all(), 'cat_id', 'title');
        if ($model->load(Yii::$app->request->post())) {
			$model->primary_image = UploadedFile::getInstance($model, 'primary_image');
			if(!empty($model->primary_image)) {
				if(!$model->uploadImage())
					return;
			}
			$model->wished_by = \Yii::$app->user->id;
			$model->save();
            return $this->redirect(['view', 'id' => $model->w_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
				'categories' => $categories
            ]);
        }
    }

    /**
     * Updates an existing Wish model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$categories =  ArrayHelper::map(Category::find()->all(), 'cat_id', 'title');
		$current_image = $model->primary_image;
        if ($model->load(Yii::$app->request->post())) {
			//check for a new image
			$model->primary_image = UploadedFile::getInstance($model, 'primary_image');
			if(!empty($model->primary_image)) {
				if(!$model->uploadImage())
					return;
			}			
			else
				$model->primary_image = $current_image;
			//save model
			$model->wished_by = \Yii::$app->user->id;
			$model->save();
            return $this->redirect(['view', 'id' => $model->w_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'categories' => $categories
            ]);
        }
    }

    /**
     * Deletes an existing Wish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

	/**
	 * Like a wish
	 * User has to be logged in to like a wish
	 * Param: wish id
	 * @return boolean
	 */
	public function actionLike($w_id,$type)
	{
		$wish = $this->findModel($w_id);
		$activity = Activity::find()->where(['wish_id'=>$wish->w_id,'activity'=>$type,'user_id'=>\Yii::$app->user->id])->one();
		if($activity != null){
			$activity->delete();
			return "removed";
		}
			$activity = new Activity();
		$activity->wish_id = $wish->w_id;
		$activity->activity = $type;
		$activity->user_id = \Yii::$app->user->id;
		if($activity->save())
			return "added";
		else return false;
	}
	 
    /**
     * Finds the Wish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Wish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Wish::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
