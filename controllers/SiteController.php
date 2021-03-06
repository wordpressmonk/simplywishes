<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\User;
use app\models\UserProfile;
use yii\web\UploadedFile;


class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','my-account'],
                'rules' => [
                    [
                        'actions' => ['logout','my-account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
		$this->layout = "home";
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
		
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
	
	public function actionMyAccount(){
		
		$user = User::findOne(\Yii::$app->user->id);
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		$countries = \yii\helpers\ArrayHelper::map(\app\models\Country::find()->all(),'id','name');	
		$states = \yii\helpers\ArrayHelper::map(\app\models\State::find()->all(),'id','name');	
		$cities = \yii\helpers\ArrayHelper::map(\app\models\City::find()->all(),'id','name');	
		
		$current_image = $profile->profile_image;
		if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())){
			if($user->password)
				$user->setPassword($user->password);
			//print_r($user);die;
			if($user->save()){
				$profile->user_id = $user->id;
				//save profile image here
				$profile->profile_image = UploadedFile::getInstance($profile, 'profile_image');
				//print_r($profile);die;
				if(!empty($profile->profile_image)) {
					if(!$profile->uploadImage())
						return;
				}else{
					$profile->profile_image = $current_image;
				}
				$profile->save();
				\Yii::$app->getSession()->setFlash('success', 'Account details have been changed successfully');
				return $this->redirect('my-account');
			}
		}		
		else return $this->render('my_account', [
            'user' => $user,
			'profile' => $profile,
			'countries' => $countries,
			'states' => $states,
			'cities' => $cities
        ]);
	}
	
	public function actionSignUp()
	{
		$user = new User();
		$user->scenario = 'sign-up';
		$profile = new UserProfile();
		$countries = \yii\helpers\ArrayHelper::map(\app\models\Country::find()->all(),'id','name');	
		if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())){
			$user->setPassword($user->password);
			$user->generateAuthKey();
			//print_r($profile);die;
			if($user->save()){
				$profile->user_id = $user->id;
				//save profile image here
				$profile->profile_image = UploadedFile::getInstance($profile, 'profile_image');
				if(!empty($profile->profile_image)) {
					if(!$profile->uploadImage())
						return;
				}
				$profile->save();
				\Yii::$app->user->login($user,0);
				return $this->redirect('index');
			}
		}
        else return $this->render('sign_up', [
            'user' => $user,
			'profile' => $profile,
			'countries' => $countries,
        ]);
	}
	public function actionGetStates($country_id){
		$states = \app\models\State::find()->where(['country_id'=>$country_id])->all();
		if(count($states)>0){
			echo "<option value=''>--Select State--</option>";
			foreach($states as $state){
				echo "<option value='".$state->id."'>".$state->name."</option>";
			}			
		}
		else{
			echo "<option value=''>-</option>";
		}
	}
	public function actionGetCities($state_id){
		$cities = \app\models\City::find()->where(['state_id'=>$state_id])->all();
		if(count($cities)>0){
			echo "<option value=''>--Select City--</option>";
			foreach($cities as $city){
				echo "<option value='".$city->id."'>".$city->name."</option>";
			}			
		}
		else{
			echo "<option value=''>-</option>";
		}
	}
}
