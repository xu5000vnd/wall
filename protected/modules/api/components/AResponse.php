<?php 
class AResponse { 

	const DEFAULT_CONTENT_TYPE = 'application/json';

	public $errorCode = AConstants::HTTP_STATUS_200;
	public $message;
	public $description;
	public $contentType = 'json';
	public $data = [];
	public static $CONTENT_TYPE = [
        'json' => 'application/json',
        'xml' => 'application/xml'
    ];

    /**
     * @author Lien Son
     * @todo: send
     * @return: json
     */
    public function send() {
    	$this->beforeSend();
    	$this->setHeader();

    	$res = [];
    	echo CJSON::encode($res);
        Yii::app()->end();

    }

    /**
     * @author Lien Son
     * @todo: before send
     */
    private function beforeSend() {

    }

    /**
     * @author Lien Son
     * @todo: set header
     */
    private function setHeader() {
    	$statusHeader = 'HTTP/1.1 ' . $this->errorCode . ' ' . $this->getHttpStatusMessage();
        header($statusHeader);
        header('Content-type: ' . $this->getContentType());
    }

    /**
     * @author Lien Son
     * @param int $status
     * @return string
     * @todo get http status message
     */
    private function getHttpStatusMessage() {
        return isset(AConstants::$ARR_HTTP_CODES[$this->errorCode]) ? AConstants::$ARR_HTTP_CODES[$this->errorCode] : '';
    }

    /**
     * @author Lien Son
     * @return stromg
     * @todo get content type
     */
    private function getContentType() {
        return isset(self::$CONTENT_TYPE[$this->contentType]) ? self::$CONTENT_TYPE[$this->contentType] : self::DEFAULT_CONTENT_TYPE;
    }


}
?>