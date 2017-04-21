<?php 
class ARequest { 
	public $params;
	public $header;
	public $server;
	public $get;
	public $post;
	public $files;

	public function __construct() {
		$this->header = getallheaders();
		$this->server = $_SERVER;
		$this->get = $_GET;
		$this->post = $_POST;
		$this->files = $_FILES;

		//bind params
		$this->bindParams();
	}

	/**
	 * @author Lien Son 
	 * @todo: parse input data
	 */
	protected function bindParams() {
		foreach ($this->get as $key => $value) {
			$this->setParam($key, $value);
		}

		foreach ($this->post as $key => $value) {
			$this->setParam($key, $value);
		}
	}

	/**
	 * @author Lien Son
	 * @todo: set a param
	 * @param: string 
	 */
	public function setParam($key, $value) {
		$this->params[$key] = $this->cleanInput($value);
	}

	/**
	 * @author Lien Son
	 * @todo: get param
	 * @param: string 
	 */
	public function getParam($key) {
		if (array_key_exists($key, $this->params)) {
			return $this->params[$key];
		}
		return null;
	}

    /**
	 * @author Lien Son
     * @param string $value
     * @return string
     * @todo clean potential sql injection
     * allow number,alphabet,space,under line
     */
    public function cleanInput($value) {
        $value = urldecode($value);
        return preg_replace('/[^0-9a-zA-Z_\/ ,.-]/', '', $value);
    }

}
?>