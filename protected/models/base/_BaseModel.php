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

    public $createFullImage = true;

    public $uploadImageFolder = 'upload/media';
    
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

    public function saveImage($fieldName, $object = null) {
        $uploaded = CUploadedFile::getInstance($this, $fieldName);

        if(!empty($object)) {
            $uploaded = $object;
        }

        if (array_key_exists($fieldName, $this->attributesBeforeSave))
            $oldImage = $this->attributesBeforeSave[$fieldName];

        if (is_null($uploaded)) {
            if (!empty($oldImage)) {
                $this->$fieldName = $oldImage;
                $this->update(array($fieldName));
            }
            return false;
        }

        // if (!empty($oldImage))
        //     $this->deleteImage($oldImage);

        $ext = $uploaded->getExtensionName();
        $fileName = time() . '_' . $this->id . '_' . StringHelper::stripUnicode($uploaded->getName());
        $fileName = str_replace('.' . $ext, '.' . strtolower($ext), $fileName);
        $imageHelper = new ImageHelper();
        $imageHelper->createDirectoryByPath($this->uploadImageFolder . "/" . $this->id);
        $uploaded->saveAs($this->uploadImageFolder . '/' . $this->id . '/' . $fileName);
        $this->$fieldName = $fileName;
        $this->update(array($fieldName));
    }

    public function deleteImage($oldImage) {
        if (!empty($oldImage)) {
            ImageHelper::deleteFile($this->uploadImageFolder . '/' . $this->id . '/' . $oldImage);
        }
    }

    public function getImage($field_file = 'file_name') {
        if(isset($this->$field_file) &&!empty($this->$field_file)) {
            $path = $this->uploadImageFolder . '/' . $this->id . "/" . $this->$field_file;
            return Yii::app()->createAbsoluteUrl($path);
        }

        return null;
    }

    protected function beforeDelete() {
        //check and delete relate
        // if(isset($this->rRelateOne) && !empty($this->rRelateOne)) {
        //     foreach ($this->rRelateOne as $record) {
        //         $record->delete();
        //     }
        // }

        // if(isset($this->rRelateMany) && !empty($this->rRelateMany)) {
        //     foreach ($this->rRelateMany as $record) {
        //         $record->delete();
        //     }
        // }

        return parent::beforeDelete();
    }

    public function getArrIdByRelate($relName) {
        if(isset($this->$relName) && is_array($this->$relName)) {
            return array_keys(CHtml::getData($this->$relName, 'id','id'));
        }

        return isset($this->$relName) ? $this->{$relName}->id : null;
    }
}
?>