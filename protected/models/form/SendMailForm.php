<?php 
class SendMailForm extends CFormModel
{
	
	public $subject;
	public $body;
	public $sendCCEMail;
	public $sendToEMail;


	public function rules()
    {
        return [
        	['subject, body, sendToEMail', 'required', 'on' => 'create'],
        	['sendToEMail', 'email', 'on' => 'create'],
        	['sendCCEMail', 'safe']
        ];
    }

}
?>