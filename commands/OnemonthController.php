<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Wish;
use app\models\User;
use app\models\MailContent;
use yii\db\Query;


use Yii;


class OnemonthController extends Controller {

    public function actionIndex() {	
		
		/* $quickemail = Wish::find()->where(['process_status'=>1,'email_status'=>0])->andWhere(["<","process_granted_date",(CURRENT_DATE() - INTERVAL 1 MONTH)])->all(); */
		$connection = \Yii::$app->db;
		
		$model = $connection->createCommand('SELECT * FROM wishes 
			WHERE ((process_status = 1) 
			AND (email_status = 0) AND process_granted_date < (CURRENT_DATE() - INTERVAL 1 MONTH) AND process_granted_date != "" 
			)');
		$quickemail = $model->queryAll();
	
		if($quickemail)
		{	
			
			
			
			 foreach($quickemail as $tmp)
			{					
			
		   
		   
			   $mailcontent = MailContent::find()->where(['m_id'=>11])->one();
				$editmessage = $mailcontent->mail_message;		
				$subject = $mailcontent->mail_subject;
				if(empty($subject))
					$subject = 	'SimplyWishes '; 
				
				 
				  $user = User::findOne([
					'status' => User::STATUS_ACTIVE,
					'id' => $tmp['wished_by'],
				]);
					
				if (!$user) {
					return false;
				}
				  $message = \Yii::$app
					->mailer
					->compose(
						['html' => 'cronalertwishSuccess-html'],
						['user' => $user, 'editmessage' => $editmessage ]
					)
					->setFrom([\Yii::$app->params['supportEmail'] => 'SimplyWishes '])
					->setTo( $user->email)
					->setSubject($subject);			
					
				$message->getSwiftMessage()->getHeaders()->addTextHeader('MIME-version', '1.0\n');
				$message->getSwiftMessage()->getHeaders()->addTextHeader('charset', ' iso-8859-1\n');
				
				$message->send();
		
		
		
					
			  $model = Wish::findOne($tmp['w_id']);
			  $model->email_status = 1;
			  $model->save(false);  		  
			} 
		}	     		
    }


}