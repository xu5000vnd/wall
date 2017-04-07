<?php

class LoginModalWidget extends CWidget {

	public function run() {
		$this->getLogin();
	}

	public function getLogin() {
		$model = new LoginForm();
        $model->login_by = 'username';

		$this->render("login_modal", array(
			'model' => $model,
		));
	}

}
