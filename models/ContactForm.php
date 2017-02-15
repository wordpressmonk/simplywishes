<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $phone_number;
    public $body;
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body','phone_number'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            [['phone_number'],'integer'],
    
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param string $email the target email address
     * @return bool whether the model passes validation
     */
    public function contact($email)
    {	
        if ($this->validate()) {
			  $message = Yii::$app
            ->mailer
            ->compose(
                ['html' => 'contactMail-html'],
                ['body' => $this->body,'phonenumber'=>$this->phone_number]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => 'SimplyWishes '])
            ->setTo($this->email)
            ->setSubject('SimplyWishes '.$this->subject);			
            
		$message->getSwiftMessage()->getHeaders()->addTextHeader('MIME-version', '1.0\n');
		$message->getSwiftMessage()->getHeaders()->addTextHeader('charset', ' iso-8859-1\n');
		
		$message->send();
		
		return true;
		
        }
        return false;
    }
	
	
}
