<?php 
class AFavorite {
	public static function getListFav($ctrl) {
		$email = $ctrl->request->getParam('email');
		$data = [];
		if(!empty($email)) {
			$models = Favorite::findByEmail($email);
			if($models) {
				$data = array_keys(CHtml::listData($models, 'image_id', 'image_id'));
			}
		}

        $ctrl->response->data = $data;
		$ctrl->response->send();
	}

	public static function deleteFav($ctrl) {
		$email_user = $ctrl->request->getParam('email_user');
		$data = [];
		$data['status'] = AConstants::ERROR;
		$image_id = $ctrl->request->getParam('image_id');
		$model = Favorite::model()->findByAttributes(['email_user' => $email_user, 'image_id' => $image_id]);
		if($model) {
			$model->delete();
			$data['status'] = AConstants::SUCCESS;
		}
        $ctrl->response->data = $data;
		$ctrl->response->send();
	}
}
?>