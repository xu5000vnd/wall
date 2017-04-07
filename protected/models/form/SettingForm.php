<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class SettingForm extends CFormModel {

    const PATH_UPLOAD_FILE = '/upload/settings/';

    public $projectName;

    public static $smtpFields = ['host' => 'smtpHost', 'username' => 'smtpUsername', 'password' => 'smtpPassword',
        'port' => 'smtpPort', 'encryption' => 'encryption'];

    /*
     * Austin added date 6/7/2014
     * First element of array is Group Name
     * Items inside are controls in each tab. You should put enough attributes as below to get rid errors
     * Now it just support control text, textarea, editor (add html class my-editor-basic or my-editor-full), image, dropdown
     * Feel free to add more
     */
    public static $settingDefine = [
        "pagesetting" => [
            'label' => 'Website',
            'htmlOptions' => [],
            'icon' => '<span class="glyphicon glyphicon-globe"></span>',
            'items' => [
                ['name' => 'projectName', 'controlTyle' => 'text', 'notes' => '', 'unit' => '', 'htmlOptions' => ['size' => 80], 'rules' => 'required'],
                
            ],
        ],
    ];

    public function rules() {
        $return = [];
        // for reuired attribute
        $requiredRule = self::getRules('required');
        if ($requiredRule != '')
            $return [] = [$requiredRule, 'required'];

        // for numerical attribute
        $numerical = self::getRules('numerical');
        if ($numerical != '')
            $return [] = [$numerical, 'numerical', 'integerOnly' => true];

        // for email attribute
        $email = self::getRules('email');
        if ($email != '')
            $return [] = array($email, 'email');

        // for file attribute
        $file = self::getRules('file');
        if ($file != '') {
            $return[] = [$file, 'file', 'on' => 'updateSettings',
                'allowEmpty' => true,
                'types' => 'jpg,gif,png,tiff',
                'wrongType' => 'Only jpg,gif,png,tiff allowed',
                'maxSize' => 1024 * 1024 * 3, // 8MB
                'tooLarge' => 'The file was larger than 3MB. Please upload a smaller file.',
            ];
            $return[] = ['$file', 'match', 'pattern' => '/^[^\\/?*:&;{}\\\\]+\\.[^\\/?*:&;{}\\\\]{3}$/', 'message' => 'Upload files name cannot include special characters: &%$#', 'on' => 'updateSettings'];
        }
        // for safe attribute
        $return[] = [implode(',', self::getAllAttributes()), 'safe'];
        return $return;
    }

    public function checkPhone($attribute, $params) {
        if ($this->$attribute != '') {
            $pattern = '/^[\+]?[\(]?(\+)?(\d{0,3})[\)]?[\s]?[\-]?(\d{0,9})[\s]?[\-]?(\d{0,9})[\s]?[x]?(\d*)$/';
            $containsDigit = preg_match($pattern, $this->$attribute);
            $lb = $this->getAttributeLabel($attribute);
            if (!$containsDigit)
                $this->addError($attribute, "$lb must be numerical and  allow input (),+,-");
        }
    }

    /*
     * Austin added date 6/7/2014
     * Override configurations.
     * This function is called in index.php and cron.php in root
     */

    public static function applySettings() {
        $attributeList = self::getAllAttributes();
        if ($attributeList && is_array($attributeList)) {
            foreach ($attributeList as $item) {
                // none SMTP fields
                if (!in_array($item, self::$smtpFields) && Yii::app()->setting->getItem($item)) {
                    Yii::app()->params[$item] = Yii::app()->setting->getItem($item);
                }
            }
        }
    }

    /*
     * Austin added date 6/7/2014
     * get all attributes from setting array
     */

    public static function getAllAttributes() {
        $attributes = [];
        if (self::$settingDefine && is_array(self::$settingDefine)) {
            foreach (self::$settingDefine as $item) {
                $itemObj = (object) $item;
                if ($itemObj->items && is_array($itemObj->items)) {
                    foreach ($itemObj->items as $setItem) {
                        $setItem = (object) $setItem;
                        $attributes[] = $setItem->name;
                    }
                }
            }
        }
        return $attributes;
    }

    /*
     * Austin added date 7/7/2014
     * Build model vaidate rule
     */

    protected static function getRules($ruleName) {
        $attributes = [];
        if (self::$settingDefine && is_array(self::$settingDefine)) {
            foreach (self::$settingDefine as $item) {
                $itemObj = (object) $item;
                if ($itemObj->items && is_array($itemObj->items)) {
                    foreach ($itemObj->items as $setItem) {
                        $setItem = (object) $setItem;
                        if (strpos($setItem->rules, $ruleName) !== false)
                            $attributes[] = $setItem->name;
                    }
                }
            }
        }
        return implode(',', $attributes);
    }

}
