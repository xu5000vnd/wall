<?php

class _BaseModel extends CActiveRecord {
	public $attributesBeforeSave = array(); 
    public $arrStatus = array(
        STATUS_ACTIVE => 'Active',
        STATUS_INACTIVE => 'Inactive',
    );
    public $arrYesNo = array(
        TYPE_YES => 'Yes',
        TYPE_NO => 'No',
    );
    
	protected function beforeSave() {
        if (!$this->isNewRecord) {
            if (count($this->attributesBeforeSave) == 0) {
                $model = call_user_func(array(get_class($this), 'model'));
                $mBeforeSave = $model->findByPk($this->id);
                $this->attributesBeforeSave = $mBeforeSave->attributes;
            }
        }
        if ($this->isNewRecord) {
            if ($this->hasAttribute('created_date')) {
                if (empty($this->created_date))
                    $this->created_date = date('Y-m-d H:i:s');
            }
        }

        if ($this->hasAttribute('created_date')) {
            if($this->created_date == '0000-00-00 00:00:00') {
                $this->created_date = date('Y-m-d H:i:s');
            }
        }

        if ($this->hasAttribute('updated_date')) {
            $this->updated_date = date('Y-m-d H:i:s');
        }

        return parent::beforeSave();
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
?>