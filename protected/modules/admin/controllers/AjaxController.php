<?php 
class AjaxController extends AdminController {

	public function actionToggleMenu() {
        try {

            if(isset($_SESSION['TOGGLE']) && $_SESSION['TOGGLE'] == 'close') {
                $_SESSION['TOGGLE'] = 'open';
            } else {
                $_SESSION['TOGGLE'] = 'close';
            }

            var_dump($_SESSION['TOGGLE']);

        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }

}
?>