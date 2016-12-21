<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\UserProfile;
use yii\web\UploadedFile;
use app\models\search\SearchWish;
use app\models\Message;

class AccountController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['edit-account','my-account','inbox'],
                'rules' => [
                    [
                        'actions' => ['edit-account','my-account','inbox'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
	
	public function actionProfile($id){
		if($id==\Yii::$app->user->id)
			return $this->redirect('my-account');
		$user = User::findOne($id);
		$profile = UserProfile::find()->where(['user_id'=>$id])->one();
		
        $searchModel = new SearchWish();
        $dataProvider = $searchModel->searchUserWishes(Yii::$app->request->queryParams,$id,'active');
		
		return $this->render('other_profile', [
            'user' => $user,
			'profile' => $profile,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);		
	}
	public function actionMyAccount(){
		
		$user = User::findOne(\Yii::$app->user->id);
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		
        $searchModel = new SearchWish();
        $dataProvider = $searchModel->searchUserWishes(Yii::$app->request->queryParams,\Yii::$app->user->id,'active');
		
		return $this->render('profile', [
            'user' => $user,
			'profile' => $profile,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);		
	}
	public function actionMyFullfilled($id=null){
		if(!$id)
			$id = \Yii::$app->user->id;
		$user = User::findOne($id);
		$profile = UserProfile::find()->where(['user_id'=>$id])->one();
		
        $searchModel = new SearchWish();
        $dataProvider = $searchModel->searchUserWishes(Yii::$app->request->queryParams,$id,'fullfilled');
		if($id == \Yii::$app->user->id)
			return $this->render('my_fullfilled', [
				'user' => $user,
				'profile' => $profile,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);	
		else
			return $this->render('other_fullfilled', [
				'user' => $user,
				'profile' => $profile,
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);			
	}
	public function actionMySaved($id=null){
		if(!$id)
			$id = \Yii::$app->user->id;		
		$user = User::findOne($id);
		$profile = UserProfile::find()->where(['user_id'=>$id])->one();
		
        $searchModel = new SearchWish();
        $dataProvider = $searchModel->searchSavedWishes(Yii::$app->request->queryParams,\Yii::$app->user->id);
		
		return $this->render('my_saved', [
            'user' => $user,
			'profile' => $profile,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);			
	}
	public function actionEditAccount()
	{		
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
					
					if(!empty($profile->dulpicate_image) && ($profile->dulpicate_image != $current_image ))
					{
						$profile->profile_image = $profile->dulpicate_image;
					} else {
						$profile->profile_image = $current_image;
					}
					
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
	
	public function actionSendMessage(){
		
		$from = \Yii::$app->request->post()['send_from'];
		$to = \Yii::$app->request->post()['send_to'];
		$msg = \Yii::$app->request->post()['msg'];
		
		if($from != '' && $to != '' && $msg != ''){
			$message = new Message();
			$message->sender_id = $from;
			$message->recipient_id = $to;
			$message->parent_id = 0;
			$message->text = $msg;
			if($message->save()){
				Yii::$app->session->setFlash('messageSent');
			}
				return $this->redirect(['profile','id'=>$to]);
		}
	}
	public function actionReplyMessage(){
		
		$from = \Yii::$app->request->post()['send_from'];
		$to = \Yii::$app->request->post()['send_to'];
		$msg = \Yii::$app->request->post()['msg'];
		
		if($from != '' && $to != '' && $msg != ''){
			$message = new Message();
			$message->sender_id = $from;
			$message->recipient_id = $to;
			$message->parent_id = 0;
			$message->text = $msg;
			if($message->save()){
				return json_encode([
					'status'=>true
				]);
			}
			else return json_encode([
					'status'=>false
				]);
		}
	}	
	public function actionInbox(){
		$user = User::findOne(\Yii::$app->user->id);
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		$messages = $this->getThreads();
		//print_r($messages);die;
		return $this->render('messages', 
						['user' => $user,
						 'profile' => $profile,
						 'messages' => $messages,
						]);		
	}
	public function getThreads(){
		//first send
		$threads = [];
		$send_messages = Message::find()->where(['sender_id'=>\Yii::$app->user->id])->orderBy('m_id DESC')->all();
		foreach($send_messages as $send_message){
			if(!array_key_exists($send_message->recipient_id,$threads))
				$threads[$send_message->recipient_id] = [
					'm_id' => $send_message->m_id,
					'text' => $send_message->text,
					'created_at' => $send_message->created_at,
					'send_by' => $send_message->sender_id,
					'threads' => [
						[
						'm_id' => $send_message->m_id,
						'text' => $send_message->text,
						'created_at' => $send_message->created_at,
						'send_by' => $send_message->sender_id,]
						]
				];
			else
				$threads[$send_message->recipient_id]['threads'][] = [
					'm_id' => $send_message->m_id,
					'text' => $send_message->text,
					'created_at' => $send_message->created_at,
					'send_by' => $send_message->sender_id
				];
		}
		$recievd_messages = Message::find()->where(['recipient_id'=>\Yii::$app->user->id])->orderBy('m_id DESC')->all();
		foreach($recievd_messages as $message){
			if(!array_key_exists($message->sender_id,$threads))
				$threads[$message->sender_id] = [
					'm_id' => $message->m_id,
					'text' => $message->text,
					'created_at' => $message->created_at,
					'send_by' => $message->sender_id,
					'threads' => [[
						'm_id' => $message->m_id,
						'text' => $message->text,
						'created_at' => $message->created_at,
						'send_by' => $message->sender_id,]]
				];
			else
				$threads[$message->sender_id]['threads'][] = [
					'm_id' => $message->m_id,
					'text' => $message->text,
					'created_at' => $message->created_at,
					'send_by' => $message->sender_id,
				];
		}
		arsort($threads);
		return $threads;
	}
	
}