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
use app\models\search\SearchWish;
use yii\data\ActiveDataProvider;
use app\models\Wish;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;

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
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
		$query = Wish::find()->where(['not', ['granted_by' => null]])->orderBy('w_id DESC');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize'=>4
            ]
        ]);
        return $this->render('index',['models'=>$dataProvider->models]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin($red_url=null)
    {
		
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			if($red_url)
				return $this->redirect($red_url);
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
		$query = Wish::find()->select(['wishes.wished_by,count(w_id) as total_wishes'])->orderBy('total_wishes DESC');
		$query->groupBy('wished_by');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize'=>50
            ]
        ]);
        return $this->render('about',[
			'dataProvider' => $dataProvider,
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
				} else {
					$profile->profile_image = $profile->dulpicate_image;

				}
							
				$profile->save();
				\Yii::$app->user->login($user,0);
				return $this->redirect('index');
			}
			else return $this->render('sign_up', [
            'user' => $user,
			'profile' => $profile,
			'countries' => $countries,
			]);
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
	
	public function actionEditorial(){
		$model = \app\models\Editorial::find()->where(['status'=>0])->orderBy()->all();		
		return $this->render('', [
            'model' => $model,	
			]);
	}
	

	public function actionRequestPasswordReset()
    {		
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post())) {
			
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->redirect(['login']);
            } else { 
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
				
            }			   
        } 
        return $this->render('requestPasswordResetToken', ['model' => $model,]);
    }
	
	 public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
			
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');			
			$model->sendEmailResetSuccess();			
            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

	/**
	 * Send test mail
	 * Only for debugging purposes
	 */
	public function actionTestMail(){
		Yii::$app->mailer->compose()
			->setTo('dency@abacies.com')
			->setFrom(['dency@abacies.com' => 'Dency G B'])
			->setSubject('Test mail from simplywishes')
			->setTextBody('Regards')
			->send();		
	}

}
