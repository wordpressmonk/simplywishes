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
use app\models\FriendRequest;

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
		$id = \Yii::$app->user->id;
		$user = User::findOne(\Yii::$app->user->id);
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		$countries = \yii\helpers\ArrayHelper::map(\app\models\Country::find()->all(),'id','name');	
		$states = \yii\helpers\ArrayHelper::map(\app\models\State::find()->where(['country_id'=>$profile->country])->all(),'id','name');	
		$cities = \yii\helpers\ArrayHelper::map(\app\models\City::find()->where(['state_id'=>$profile->state])->all(),'id','name');	
		
		$current_image = $profile->profile_image;
		if ($user->load(Yii::$app->request->post()) && $profile->load(Yii::$app->request->post())){
			
			if($user->password)
				$user->setPassword($user->password);
			//print_r($user);die;
			if($user->save()){
				
					$profile->user_id = $user->id;
					
				/************* Image Upload Part Begin ********************/

		
		
		/* if(!empty($profile->profile_image))
		{
		$file_path=Yii::$app->basePath.'/web/uploads/';
		$image =  json_decode($profile->profile_image);
		
		if (strpos($image->data, 'data:image/jpeg;base64,') !== false) {
			$img = str_replace('data:image/jpeg;base64,', '', $image->data);
		}
		if (strpos($image->data, 'data:image/png;base64,') !== false) {
			$img = str_replace('data:image/png;base64,', '', $image->data);
		}	
		

		
		$img = str_replace(' ', '+', $img);
	    $image_data = base64_decode($img);
	    $profile->profile_image = 'uploads/'.$image_name='rand_'.rand(0000,9999).'time_'.time().'.JPG';
	    $file = $file_path .$image_name;
	    $success = file_put_contents($file, $image_data); */
				
				/************* Image Upload Part End ********************/
			
			
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
		$senduser = UserProfile::find()->where(['!=','user_id',\Yii::$app->user->id])->all();
		//print_r($messages);die;
		return $this->render('messages', 
						['user' => $user,
						 'profile' => $profile,
						 'messages' => $messages,
						 'senduser' => $senduser,
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
	
	public function actionSendMessageInbox(){
		
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
		}
	}
	
/* 	public function actionSendResetPassword(){
		if(isset(\Yii::$app->request->post()['email'])){
			$user = User::find()->where(['email'=>\Yii::$app->request->post()['email']])->one();
			if($user != null){
				$user->generatePasswordResetToken();
				$user->save();
				
				Yii::$app->mailer->compose('password-reset',['key'=>$user->password_reset_token]) // a view rendering result becomes the message body here
				->setFrom(Yii::$app->params['adminEmail'])
				->setTo($user->email)
				->setSubject('SimplyWishes : Reset Your Password')
				->send();
			}
		}
	}
	public function actionResetPassword(){
		
	} */
	
	public function actionMyFriend(){
		$user = User::findOne(\Yii::$app->user->id);		
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		$myfriend = FriendRequest::find()->where(["requested_by"=>\Yii::$app->user->id])->orWhere(["requested_to"=>\Yii::$app->user->id])->andWhere(["status"=>1])->all();	
		
		return $this->render('my_friend', 
						[
						 'user' => $user,	
						 'profile' => $profile,
						 'myfriend' => $myfriend,
						]);		
	}
	
	
	public function actionFriendRequested(){
		$user = User::findOne(\Yii::$app->user->id);		
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		$myfriend = FriendRequest::find()->Where(["requested_to"=>\Yii::$app->user->id])->andWhere(["status"=>0])->orderBy("f_id DESC")->all();	
		
		return $this->render('my_friend_requested', 
						[
						 'user' => $user,	
						 'profile' => $profile,
						 'myfriend' => $myfriend,
						]);		
	}
	
	
	public function actionMyFollow(){
		$user = User::findOne(\Yii::$app->user->id);		
		$profile = UserProfile::find()->where(['user_id'=>\Yii::$app->user->id])->one();
		$myfriend = FriendRequest::find()->where(["requested_by"=>\Yii::$app->user->id])->orWhere(["requested_to"=>\Yii::$app->user->id])->andWhere(["status"=>1])->all();	
		
		return $this->render('my_follow', 
						[
						 'user' => $user,	
						 'profile' => $profile,
						 'myfriend' => $myfriend,
						]);		
	}
	
}