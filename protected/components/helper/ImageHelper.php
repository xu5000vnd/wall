<?php
/**
 * 
 * Class using for handle image. Required: EPhpThumb extension
 * @author bb
 * @example Using createThumbs function
 *
 */
class ImageHelper
{
    public $folder = 'upload';
    public $file = '';
    public $thumbs = array();
    public $createFullImage = false;//true if you need to create full size image after resize
    public $aRGB = array(255, 255, 255);//full image background

    /**
     * Create thumb images to specific folders from exist image 
     * @example 
     
        $ImageHelper = new ImageHelper();
        $ImageHelper->folder = 'upload/admin/artist';
        $ImageHelper->file = 'photo.jpg';
        $ImageHelper->thumbs =array('thumb1' => array('width'=>'1336','height'=>'768'),
                                        'thumb2' =>  array('width'=>'800','height'=>'600'));
        $ImageHelper->createThumbs();
        Bảng Mã Màu CSS: https://sites.google.com/site/wwwcaotongvn/css
     *  http://www.rapidtables.com/web/color/RGB_Color.htm 
     * @author bb
     */
    public function createThumbs()
    {       
       if(count($this->thumbs) > 0)
       {
          $pathFile = Yii::getPathOfAlias('webroot').'/'.$this->folder.'/'.$this->file;
          if(!file_exists($pathFile) || empty($this->file)) return false;
                
          self::createDirectoryByPath($this->folder);
          foreach($this->thumbs as $folderThumb => $size)
          {
               $this->createSingleDirectoryByPath($this->folder.'/'.$folderThumb);

               $thumb=new EPhpThumb();
               $thumb->init();                
               $thumb->create($pathFile)
                   ->resize($size['width'],$size['height'])
                   ->save(Yii::getPathOfAlias('webroot').'/'.$this->folder.'/'.$folderThumb.'/'.$this->file);

               self::createNoImage($size['width'], $size['height']);
               //create full image
               if($this->createFullImage)
               {
                    $source_folder = $this->folder.'/'.$folderThumb;
                    self::createFullImage($source_folder, $this->file, $size['width'], $size['height'], NULL, $this->aRGB);
               }
          }
       }
    }
    
    /**
     * @param int $width 
     * @param int $height
     * @return boolean
     * @copyright (c) 2013, bb
     */
    public static function createNoImage($width, $height, $aBackgroundRGB = array(255, 255, 255), $aTextRGB = array(0, 0, 0))
    {
        self::createDirectoryByPath('upload/noimage');
        $noimagePath = 'upload/noimage/'.$width.'x'.$height.'.jpg';
        if(!file_exists(Yii::getPathOfAlias("webroot").'/'.$noimagePath)) 
        {
            if(!file_exists(Yii::getPathOfAlias("webroot").'/upload/noimage/ARLRDBD.TTF'))
            {
                echo "Need font file ".Yii::getPathOfAlias("webroot").'/upload/noimage/ARLRDBD.TTF';
                exit;
            }
            $bg_image = @imagecreatetruecolor($width, $height);
            $bg_color = imagecolorallocate($bg_image, $aBackgroundRGB[0], $aBackgroundRGB[1], $aBackgroundRGB[2]);            
            $textColor = imagecolorallocate($bg_image, $aTextRGB[0], $aTextRGB[1], $aTextRGB[2]);           
            $grey = imagecolorallocate($bg_image, 128, 128, 128);
            imagefilledrectangle($bg_image, 0, 0, $width, $height, $bg_color);   
              
            $text = "NO IMAGE";
            $font_file = Yii::getPathOfAlias("webroot").'/upload/noimage/ARLRDBD.TTF';
            $font_size = 6; // Font size is in pixels.
            // Retrieve bounding box:
            $area = imagettfbbox($font_size, 0, $font_file, $text);

            $textwidth = $area[2] - $area[0] + 2;
            $textheight = $area[1] - $area[7] + 2;

            while($width/$textwidth > 1.5)
            {
              $font_size++;
              // Retrieve bounding box:
              $area = imagettfbbox($font_size, 0, $font_file, $text);

              $textwidth = $area[2] - $area[0] + 2;
              $textheight = $area[1] - $area[7] + 2;
            }
            
            // Add some shadow to the text
            imagettftext($bg_image, $font_size, 0, ($width-$textwidth)/2 , ($height-$textheight)/2 + $textheight/2 , $grey, $font_file, $text);

            // Add the text
            imagettftext($bg_image, $font_size, 0, ($width-$textwidth)/2, ($height-$textheight)/2 + $textheight/2, $textColor, $font_file, $text);

            imagejpeg($bg_image, Yii::getPathOfAlias('webroot') . '/'.$noimagePath, 100); 
            
            // Destroy memory handlers
            imagedestroy($bg_image);
            return true;
        }
        return false;
    }

    /**
     * @todo delete image file
     * @param type $source: "upload/admin/artist/photo.jpg"
     * @author bb
     */
    public static function deleteFile($source)
    {
        if(file_exists(Yii::getPathOfAlias("webroot").'/'.$source))
            @unlink(Yii::getPathOfAlias("webroot").'/'.$source);
    }
    
    /**
     * 
     * @todo RESIZE & CROP
     * @param type $fileName
     * @example
     * $ImageHelper = new ImageHelper();
        $ImageHelper->folder = 'upload/admin/artist';
        $ImageHelper->file = 'photo.jpg';
        $ImageHelper->thumbs =array('thumb1' => array('width'=>'1336','height'=>'768'),
        'thumb2' =>  array('width'=>'800','height'=>'600'));
        $ImageHelper->resizeAndCrop();
     * @author bb
     */
    public function resizeAndCrop()
    {
        if(count($this->thumbs) > 0)
        {
            $pathFile = Yii::getPathOfAlias('webroot').'/'.$this->folder.'/'.$this->file;
            if(!file_exists($pathFile) || empty($this->file)) return false;

            self::createDirectoryByPath($this->folder);
            foreach($this->thumbs as $folderThumb => $size)
            {
                $this->createSingleDirectoryByPath($this->folder.'/'.$folderThumb);

                $thumb=new EPhpThumb();
                $thumb->init();
                $thumb->create($pathFile)
                    ->adaptiveResize($size['width'],$size['height'])
                    ->save(Yii::getPathOfAlias('webroot').'/'.$this->folder.'/'.$folderThumb.'/'.$this->file);

                self::createNoImage($size['width'], $size['height']);
                //create full image
                if($this->createFullImage)
                {
                    $source_folder = $this->folder.'/'.$folderThumb;
                    self::createFullImage($source_folder, $this->file, $size['width'], $size['height'], NULL, $this->aRGB);
                }
            }
        }
    }

    
    /**
         * Useful in case of full image for SLIDING EFFECT in jquery
         * @param string $source_folder 'upload/source';
         * @param string $source_filename 'source.jpg';
         * @param string $destination_folder 'upload/source/full'. If NULL => file "source.jpg" will be override
         * @return string|boolean
         * bb
         */
        public static function createFullImage($source_folder, $source_filename, $final_width, $final_height, $destination_folder = NULL, $aRGB = array(255, 255, 255)) {
        $watermark_file = Yii::getPathOfAlias('webroot') . '/' . $source_folder . '/' . $source_filename;
        if ($destination_folder == NULL)
            $destination_folder = $source_folder;

        self::createDirectoryByPath($destination_folder);

        $finalExtension = 'jpg';
//            $bg_image_link = Yii::getPathOfAlias('webroot') . 'upload/test/bg.jpg';
        if (!file_exists($watermark_file))
            return FALSE;

        list($source_width, $source_height, $source_type) = getimagesize($watermark_file);

        if ($source_type === NULL) {
            return false;
        }

        switch ($source_type) {
            case "1":
                $watermark = imagecreatefromgif($watermark_file);
                $finalExtension = 'gif';
                break;
            case "2":
                $watermark = imagecreatefromjpeg($watermark_file);
                $finalExtension = 'jpg';
                break;
            case "3":
                $watermark = imagecreatefrompng($watermark_file);
                $finalExtension = 'png';
                break;
            default:
                return false;
        }

        $bg_image = @imagecreatetruecolor($final_width, $final_height);
        if ($finalExtension == 'gif' || $finalExtension == 'png') {
            imagecolortransparent($bg_image, imagecolorallocatealpha($bg_image, 0, 0, 0, 127));
            imagealphablending($bg_image, false);
            imagesavealpha($bg_image, true);
        } else {
            $bg_color = imagecolorallocate($bg_image, $aRGB[0], $aRGB[1], $aRGB[2]);
            imagefilledrectangle($bg_image, 0, 0, $final_width, $final_height, $bg_color);
        }
//            $white = imagecolorallocate($bg_image, 255, 255, 255);
//            $black = @imagecolorallocate($bg_image, 0, 0, 0);



        $imageWidth = imageSX($bg_image);
        $imageHeight = imageSY($bg_image);
        $watermarkWidth = $source_width;
        $watermarkHeight = $source_height;

        $coordinate_X = ( $imageWidth - $watermarkWidth) / 2;
        $coordinate_Y = ( $imageHeight - $watermarkHeight) / 2;

        // Merge the watermark onto base image
        imagecopymerge(
                $bg_image, $watermark, $coordinate_X, $coordinate_Y, 0, 0, $watermarkWidth, $watermarkHeight, 100
        );

        // Save to new location as jpg file
        $filename = pathinfo($watermark_file, PATHINFO_FILENAME);
        $final_name = $filename . '.' . $finalExtension;
        $dst_ext = $finalExtension;
        
        /*if ($dst_ext == 'jpg' || $dst_ext == 'jpeg')
            imagejpeg($bg_image, Yii::getPathOfAlias('webroot') . '/' . $destination_folder . '/' . $final_name, 100);
        else if ($dst_ext == 'png')
            imagepng($bg_image, Yii::getPathOfAlias('webroot') . '/' . $destination_folder . '/' . $final_name, 9);
        else if ($dst_ext == 'gif')
            imagegif($bg_image, Yii::getPathOfAlias('webroot') . '/' . $destination_folder . '/' . $final_name);*/

        // Destroy memory handlers
        imagedestroy($bg_image);
        imagedestroy($watermark);

        // Return new file name
        return $final_name;
    }
      
    /**
     * 
     * @todo Create single directory. 
     *          Create directory from the last path.
     *          You have to make sure that the parent directorry already exists
     * @param string $path: 'upload/admin/artist/thumb'
     * @author bb
     * 
     */
    public function createSingleDirectoryByPath($path)
    {
        $path = Yii::getPathOfAlias('webroot').'/'.$path;
        if(!is_dir($path))
            mkdir($path);
    }
    
    /**
     * 
     * @todo create directory from path
     * @param type $path: 'upload/admin/artist'
     * @author bb
     */
    public static function createDirectoryByPath($path)
    {
        $aFolder = explode('/',$path);
        if(is_array($aFolder))
        {
            self::removeEmptyItemFromArray($aFolder);
            $root = Yii::getPathOfAlias('webroot');
            $currentPath = $root;
            foreach($aFolder as $key =>$folder)
            {
                $currentPath =  $currentPath.'/'.$folder;
                if(!is_dir($currentPath))
                {
                    mkdir($currentPath);
                    chmod($currentPath, 0777); 
                }
            }
        }
    }

    public static function removeEmptyItemFromArray(&$arr)
    {
        foreach($arr as $key=>$value)
        if (is_null($value)) {
              unset($arr[$key]);
            }
    }
     /** 
      * 
      * Return absolute url by relative path. If no image exist. It will return noimage url
      * Require an exist noimage in format:   "upload/noimage/200x300.jpg"
      * 
      * @param string $path relative path "upload/noimage/200x300.jpg"
      * @param int $width 
      * @param int $height          * 
      * 
      * @copyright (c) 12/6/2013, bb Verz Design
      * @author bb  <quocbao1087@gmail.com>
      */
     public static function getImageUrl($model, $fieldName, $imageSizeAlias, $uploadFolder = "")
	{
		//has image in database
		$defaultSize = '200X200';
		//$baseNoneImage = Yii::app()->theme->baseUrl . '/js/holder.js/';
		$baseNoneImage = 'holder.js/';
		if ($model && $model->$fieldName != "")
		{
      // Xuan Tinh: custom add upload folder dynamic if has
      $uploadImageFolder = $model->uploadImageFolder;
      if ($uploadFolder != "") {
          $uploadImageFolder = $uploadFolder;
      }
			if (array_key_exists($fieldName, $model->defineImageSize) && is_array($model->defineImageSize[$fieldName]))
			{
				foreach ($model->defineImageSize[$fieldName] as $item)
				{
					if(!empty($imageSizeAlias) && $item['alias'] == $imageSizeAlias)
					{
						$image  = $uploadImageFolder . '/' . $model->id . '/' . $item['alias'] . '/' . $model->$fieldName;
						$rootImage = $uploadImageFolder . '/' . $model->id . '/' . $model->$fieldName;
						// if (!file_exists($image) && file_exists($rootImage)) 
							// $model->resizeImage($fieldName);
						if (file_exists($image))
							return Yii::app()->createAbsoluteUrl($image);
                        else if(file_exists($rootImage)) 
    						return Yii::app()->createAbsoluteUrl($rootImage);
                        else
                            return $baseNoneImage . $item['size'];
                    }
				}
			}
		}
		else //don't have image in database
		{
			if (array_key_exists($fieldName, $model->defineImageSize) && is_array($model->defineImageSize[$fieldName]))
			{
				foreach ($model->defineImageSize[$fieldName] as $item)
				{
					if($item['alias'] == $imageSizeAlias)
						return $baseNoneImage . $item['size'];
					
				}
			}
		}
		
		return $baseNoneImage . $defaultSize;
	}

    //Lien Son
    //todo: delete all folder with file
    public static function deleteAll($path){
      
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

              foreach ($files as $file)
              {
                  self::deleteAll(realpath($path) . '/' . $file);
              }

              return rmdir($path);

        }

        else if (is_file($path) === true)
        {
          return unlink($path);
        }

        return false;
    }
    // Lien Son 
    //todo: delete file tmp have date modify more than a day
    public static function deleteAllFile($path, $time = 0){
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));

              foreach ($files as $file)
              {
                  self::deleteAllFile(realpath($path) . '/' . $file, $time);
              }

        }

        else if (is_file($path) === true)
        {
            if (!empty($time)) {
              $currentTime = strtotime('now');
              $dateModifyFile = strtotime(date ("Y-m-d H:i:s", filemtime($path)));
              $date = $currentTime - $dateModifyFile;
              if ($date > 24*60*60*$time) {
                return unlink($path);
              }

            } else {
              return unlink($path);
            }
        }

        return false;
    }


    public static function getRootImageUrl($model, $fieldName, $uploadFolder = "")
  {

    if ($model && $model->$fieldName != "")
    {
      // Xuan Tinh: custom add upload folder dynamic if has
      $uploadImageFolder = $model->uploadImageFolder;
      if ($uploadFolder != "") {
          $uploadImageFolder = $uploadFolder;
      }
      $rootImage = $uploadImageFolder . '/' . $model->id . '/' . $model->$fieldName;
      if(file_exists($rootImage)){
        return Yii::app()->createAbsoluteUrl($rootImage);
      } 
      
    }
    
    return false;
  }

  //Lien Son
  //resize image after crop image
  public static function resizeImageCrop($imgUrl, $fileName, $folder, $id, $nameThumbs, $width = '400', $height = '400', $fullImage = true){
      // $pathFile = Yii::getPathOfAlias('webroot').'/'. $folder .'/'. $id . '/' . $fileName;
      $imageHelper = new ImageHelper();
      $imageHelper->createDirectoryByPath($folder . '/' . $id . '/' . $nameThumbs );
      $imageHelper->createFullImage = $fullImage;
      $thumb=new EPhpThumb();
      $thumb->init();                
      $thumb->create($imgUrl)
          ->resize($width,$height)
          ->save(Yii::getPathOfAlias('webroot').'/'. $folder .'/'. $id . '/' . $nameThumbs . '/' . $fileName);

      if($imageHelper->createFullImage){
          $source_folder = $folder . '/' . $id . '/' . $nameThumbs;
          ImageHelper::createFullImage($source_folder, $fileName, $width, $height, NULL, array(255, 255, 255));
      }
  }

  //LienSon 
  //Save overwirte Image
  public static function saveOverWriteImg($imageFrom, $imageTo) {
    //Get the file
      $content = file_get_contents($imageFrom);
      //Store in the filesystem.
      $fp = fopen($imageTo, "w");
      fwrite($fp, $content);
      fclose($fp);
  }

}
