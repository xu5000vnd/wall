<?php

class Utils {

    /**
     * @Author Haidt <haidt3004@gmail.com>
     * @copyright 2015 Verz Design 	 	 
     * @param string $modelName
     * @param id $parent_id
     * @param string $fieldName
     * @Todo: delete all record of model by parent id
     */
    public static function deleteAllRecordOfModel($modelName, $parent_id, $fieldName) {
        $criteria = new CDbCriteria();
        $criteria->compare($fieldName, $parent_id);
        $models = $modelName::model()->findAll($criteria);
        foreach ($models as $model) {
            $model->delete();
        }
    }

    /**
     * @Author Haidt <haidt3004@gmail.com>
     * @copyright 2015 Verz Design 	 	 
     * @param string $modelName
     * @param array $condition array('field_name' => 'value')
     * @Todo: delete all record of model by parent id
     */
    public static function deleteMultiRecord($modelName, $condition = array('id' => 0)) {

        $criteria = new CDbCriteria();
        foreach ($condition as $field => $value) {
            $criteria->compare($field, $value);
        }
        $models = $modelName::model()->findAll($criteria);
        foreach ($models as $model) {
            $model->delete();
        }
    }

    public static function getField($modelName, $condition = array('id' => 0), $fieldname = '') {

        $criteria = new CDbCriteria();
        foreach ($condition as $field => $value) {
            $criteria->compare($field, $value);
        }
        $model = $modelName::model()->find($criteria);
        
        return !empty($model) ? $model->{$fieldname} : null;
    }

    /**
     * copy from ActiveRecord in RealProperty project 
     * @param type $portal_code
     * @return string
     */
    public static function geocode($portal_code) {
        $portal_code = trim('' . $portal_code);
        $portal_code = 'Singapore ' . $portal_code;
        $addressclean = str_replace(" ", "+", $portal_code);
        $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=" . $addressclean . "&sensor=false";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $details_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $geoloc = json_decode(curl_exec($ch), true);

        if (!isset($geoloc['results'][0]))
            return '1.352083,103.819836';
        else
            return $geoloc['results'][0]['geometry']['location']['lat'] . ',' . $geoloc['results'][0]['geometry']['location']['lng'];
    }

    /**
     * Get path to a specific upload folder
     * @param string $subPath
     */
    public static function uploadPath($subPath = null) {
        $path = Yii::getPathOfAlias('webroot') . '/upload/';
        return empty($subPath) ? $path : ($path . $subPath);
    }

    /**
     * Get tmp upload path
     */
    public static function uploadTmpPath($subPath = null) {
        return self::uploadPath('tmp/' . $subPath);
    }

    /**
     * Get upload url
     */
    public static function uploadUrl($subPath = null) {
        $url = Yii::app()->request->baseUrl . '/upload/';
        return empty($subPath) ? $url : ($url . $subPath);
    }

    /**
     * createThumb function
     * @param type $path
     * @param type $fileName
     * @param type $size
     * @param type $bgColor
     */
    public static function createThumb($path, $fileName, $size, $bgColor = 'ffffff') {
        $desPath = $path . '/' . $size;
        @mkdir($desPath, 0777, true);

        if (!class_exists('phpThumb', false)) {
            Yii::import("application.extensions.phpThumb.*");
            require_once("phpthumb.class.php");
        }

        $size = explode('x', $size);
        $realPath = realpath($path . '/' . $fileName);

        $thumbGenerator = new phpThumb();
        $thumbGenerator->setSourceFilename($realPath);
        $thumbGenerator->setParameter('w', $size[0]);
        $thumbGenerator->setParameter('h', $size[1]);
        $thumbGenerator->setParameter('bg', $bgColor);
        $thumbGenerator->setParameter('far', 'C');

        if ($thumbGenerator->GenerateThumbnail()) {
            $thumbGenerator->RenderToFile($desPath . '/' . $fileName);
        } else {
            dump($thumbGenerator);
        }
    }

    /**
     * Create thumb files with sizes configured in params.php
     */
    public static function createThumbFiles($source, $path, $thumbs = array(), $autoPath = true) {
        if ($autoPath)
            $path = Utils::uploadPath($path);

        if (!is_dir($path)) {
            @mkdir($path, 0777, true);
        }

        if (!empty($thumbs)) {
            foreach ($thumbs as $size) {
                Utils::createThumb($path, $source, $size);
            }
        }
    }

    /**
     * Delete original file and its thumb files
     */
    public static function deleteFiles($source, $path, $thumbs = array()) {
        $path = self::uploadPath($path);
        @unlink($path . '/' . $source);
        if (!empty($thumbs)) {
            foreach ($thumbs as $size) {
                @unlink($path . '/' . $size . '/' . $source);
            }
        }
    }

    /**
     * @desc remove folder
     * @param type $dir
     */
    public static function removeDir($dir, $rmRoot = true) {
        foreach (glob($dir . '/*') as $file) {
            if (is_dir($file))
                self::removeDir($file);
            else
                @unlink($file);
        }
        if ($rmRoot)
            rmdir($dir);
    }

    /**
     *
     * Create a folder if it not exist
     * @param string $path
     */
    public static function mkdir($path) {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
            chmod($path, 0777);
        }
    }

    /**
     * @author haidt <haidt3004@gmail.com>
     * @copyright 2015 VerzDesign 	 	 
     * @param string $path folder path : upload/folder
     * @todo delete all file in a folder
     */
    public static function deleteAllFilesInFolder($path) {
        $files = glob($path . '/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file))
                @unlink($file); // delete file
        }
    }

    /**
     * @author haidt <haidt3004@gmail.com>
     * @copyright 2015 VerzDesign 	 	 
     */
    public static function getImageUrlProfile($model, $fieldName, $size = 'original') {
        $originalUrl = $model->uploadImageFolder . '/' . $model->id . '/' . $fieldName;
        $imageUrl = '';
        if ($size != 'original') {
            $imageUrl = $model->uploadImageFolder . '/' . $model->id . '/manual/' . $fieldName;
        }
        if (file_exists($imageUrl)) {
            return Yii::app()->createAbsoluteUrl($imageUrl);
        } else {
            return Yii::app()->createAbsoluteUrl($originalUrl);
        }
    }

    /**
     * @author haidt <haidt3004@gmail.com>
     * @copyright 2015 VerzDesign 	 	 
     */
    public static function deletePictureProfile($model, $fileName) {
//delete manual image size
        ImageHelper::deleteFile($model->uploadImageFolder . '/' . $model->id . '/manual/' . $fileName);
        if (file_exists($model->uploadImageFolder . '/' . $model->id . '/manual')) {
            rmdir($model->uploadImageFolder . '/' . $model->id . '/manual');
        }
// delete original image
        ImageHelper::deleteFile($model->uploadImageFolder . '/' . $model->id . '/' . $fileName);
        if (file_exists($model->uploadImageFolder . '/' . $model->id))
            rmdir($model->uploadImageFolder . '/' . $model->id);
    }

    /**
     * @author Xuan Tinh
     * @copyright 2015 VerzDesign 	 	 
     */
    public static function getImageUrlDiningGuide($model, $fieldName, $size = 'original') {
        $originalUrl = $model->uploadImageFolder . '/' . $model->id . '/' . $fieldName;
        $imageUrl = '';
        if ($size != 'original') {
            $imageUrl = $model->uploadImageFolder . '/' . $model->id . '/' . $size . '/' . $fieldName;
        }
        if (file_exists($imageUrl)) {
            return Yii::app()->createAbsoluteUrl($imageUrl);
        } else {
            return Yii::app()->createAbsoluteUrl($originalUrl);
        }
    }

    public function writeLog($data) {
        $file = Yii::app()->basePath . '/mylog.txt';
        $s = json_encode($data) . "<---->";
        file_put_contents($file, $s, FILE_APPEND);
    }

    /**
     * @author haidt <haidt3004@gmail.com>
     * @copyright 2016 Haidt
     * @param double $value 
     * @param int $gst 
     * @return double
     * @todo calculate gst
     */
    public static function calculateGst($value, $gst) {
        return ($value * $gst) / 100;
    }

    public static function getDistanceTwoPoints($address1, $address2) {

        $params = 'origins="' + $address1 + '"&destinations="' + $address2 + '"';
        $api = 'https://maps.googleapis.com/maps/api/distancematrix/output?' + $params;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        return $data;
    }

    public static function fixObject(&$object)
    {
      if (!is_object ($object) && gettype ($object) == 'object')
        return ($object = unserialize (serialize ($object)));
      return $object;
    }

    /**
     * 
     * @param int $length
     * @param string $type: all, alphabet, uppercase, lowercase, number
     * @return string random
     * @copyright (c) 9/6/2013, bb
     * @author bb  <quocbao1087@gmail.com>
     */
    public static function getRandomString($length = 8, $type = 'all') {
        if ($type == 'all')
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        elseif ($type == 'alphabet')
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        elseif ($type == 'uppercase')
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        elseif ($type == 'lowercase')
            $characters = 'abcdefghijklmnopqrstuvwxyz';
        elseif ($type == 'number')
            $characters = '0123456789';

        $string = '';

        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    //get link image barcode
    public static function getBarcode($code) {
        //remove image yesterday or 2 days
        $pathDel = self::uploadPath() . "tmp/barcode/";
        self::deleteByDay($pathDel, 2);

        Yii::import('application.extensions.barcode.*');
        require_once('BarcodeCustom.php');
        return BarcodeCustom::run($code);
    }

    public static function deleteByDay($path, $day = 1) {
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) { 
                $filelastmodified = filemtime($path . $file);
                //24 hours in a day * 3600 seconds per hour
                if((time() - $filelastmodified) > 24*3600*$day)
                {
                   @unlink($path . $file);
                }

            }

            closedir($handle); 
        }
    }

    public static function getLocation($ip) {
        $location = file_get_contents('http://freegeoip.net/json/'.$ip);
        $data = json_decode($location);
        
        if ( !empty($data) && isset($data->city)) {
            return $data->city;
        }
        
        return null;

    }

}
