<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>

/**
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends _BaseModel <?php //echo $this->baseClass."\n"; ?>
{
	<?php

	$uploadFields = [];
	$uploadArray = '';

	if (isset($modelUploadColumns) && $modelUploadColumns != '') {
		$uploadFields = explode(",", str_replace(' ', '', $modelUploadColumns));
		foreach ($uploadFields as $value) {
			$value = trim($value);
		}
	}
	foreach ($uploadFields as $uploadField) {
		echo 'public $'.$uploadField.";\n\t";
		
		if (isset($customConfigs['ModelCodeImage']) && in_array($uploadField, $customConfigs['ModelCodeImage'])) {
			$strFullImage = 'false';
			if (isset($customConfigs['ModelCodeFullImage']) && in_array($uploadField, $customConfigs['ModelCodeFullImage'])) {
				$strFullImage = 'true';
			} 
			
			$uploadArray .= "\t\t\t'$uploadField' => [
				'uploadType' => 'image',
				'maxUploadFileSize' => 3145728,
				'allowUploadType' => 'jpg,gif,png,jpeg',
				'uploadFolder' => '$modelClass/$uploadField', //All files be on \"medias\" folder
				'defineImageSize' => [
					'images' => [
						['alias' => 'small', 'size' => '70x70','createFullImage'=>$strFullImage],
						['alias' => 'thumbs', 'size' => '242x200','createFullImage'=>$strFullImage],
						['alias' => 'large', 'size' => '242x200','createFullImage'=>$strFullImage],
					]
				],
				'recommendedSize'=>'800px x 600px',
				'createFullImage'=>$strFullImage,
			],\n";
		} else {
			$uploadArray .= "\t\t\t'$uploadField' => [
				'uploadType' => 'file',
				'maxUploadFileSize'=>3145728,
				'allowUploadType'=>'pdf,doc,docx',
				'uploadFolder'=>'$modelClass/$uploadField', //All files be on \"medias\" folder
			],\n";
		}
	}

	if (!empty($uploadFields)) {
		echo 'public $uploadArray = ['."\n" . $uploadArray . "\t];\n";
	}
	?>
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '<?php echo $tableName; ?>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
<?php 
			$required ='';
			if (isset($customConfigs['ModelCodeRequired']))
			{
				$required = implode(',', $customConfigs['ModelCodeRequired']);
				echo "\t\t ['$required', 'required', 'on' => 'create, update'], \n";
			}
			
			$email ='';
			if (isset($customConfigs['ModelCodeEmail']))
			{
				$email = implode(',', $customConfigs['ModelCodeEmail']);
				echo "\t\t ['$email', 'email', 'on' => 'create, update'], \n";
			}
			
			$unique ='';
			if (isset($customConfigs['ModelCodeUnique']))
			{
				$unique = implode(',', $customConfigs['ModelCodeUnique']);
				echo "\t\t ['$unique', 'unique', 'on' => 'create, update'], \n";
			}
?>
			['<?php echo implode(',', $uploadFields) ; ?>', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'],
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
	
<?php 
if (isset($customConfigs['relationTable'])):
	$i = 1;
	foreach($customConfigs['relationTable'] as $name): ?>
				<?php if($name != '' && isset($customConfigs['relationName'][$i]) && isset($customConfigs['relationField'][$i])): ?>
				<?php echo "'" .  $model->generateClassName($name) . "' => array(self::" . $customConfigs['relationName'][$i] . ", '" . $model->generateClassName($name) . "', '" . $customConfigs['relationField'][$i] . "'),\n"; ?>
	<?php 
				endif;
	$i++;
	endforeach; 
endif;
?>
<?php if (!empty($uploadFields)) { ?>
			'rFiles' => [self::HAS_MANY, 'FilesUpload', 'parent_id'],
<?php } ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
<?php foreach($labels as $name=>$label): ?>
			<?php echo "'$name' => Yii::t('translation','$label'),\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

<?php
$hasStatus = false;
foreach($columns as $name=>$column)
{
	if ($name == 'status')
		$hasStatus = true;
	if($column->type==='string')
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
	}
	else
	{
		echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
	}
}
?>
		<?php 
		//for default sort field
		if (isset($customConfigs['sortfield']) && $customConfigs['sortfield'] != ''):?>
		$sort = new CSort();

        $sort->attributes = [
			'*',
            'name' => [
                'asc' => 't.<?php echo $customConfigs['sortfield'];?>',
                'desc' => 't.<?php echo $customConfigs['sortfield'];?> desc',
                'default' => 'asc',
            ],
        ];
		$sort->defaultOrder = 't.<?php echo $customConfigs['sortfield'];?> asc';
		<?php
		endif;
		?>
			
		 
		return new CActiveDataProvider($this, [
			'criteria'=>$criteria,
                        'sort' => $sort,
			'pagination'=>[
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ],
		]);
	}

	public function searchExport()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.
		
		$criteria=new CDbCriteria;
	
		<?php
		foreach($columns as $name=>$column)
		{
			if($column->type==='string') {
				echo "\t\t\$criteria->compare('$name',\$this->$name,true);\n";
			} else {
				echo "\t\t\$criteria->compare('$name',\$this->$name);\n";
			}
		}
		echo "\t\t\$criteria->order = 'id DESC';\n";
		?>
		$model = self::model()->findAll($criteria);
	
		if($model){
			return $model;
		}
		return ;
	}

<?php if($connectionId!='db'):?>
	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()-><?php echo $connectionId ?>;
	}

<?php endif?>
	
<?php if ($hasStatus): ?>
	public function activate()
    {
        $this->status = 1;
        $this->update();
    }



    public function deactivate()
    {
        $this->status = 0;
        $this->update();
    }
<?php endif; ?>
<?php if (isset($customConfigs['slugfield']) && $customConfigs['slugfield'] != ''):?>
	public function behaviors() {
        return array('sluggable' => array(
                'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
                'columns' => array('<?php echo $customConfigs['slugfield'];?>'),
                'unique' => true,
                'update' => true,
            ),);
    }
	
	public function getDetailBySlug($slug)
	{
		$criteria = new CDbCriteria;
        $criteria->compare('t.slug', $slug);
        return <?php echo $modelClass; ?>::model()->find($criteria);
	}
	
<?php endif;?>

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return <?php echo $modelClass; ?> the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    /**
    * In case you use displayed order to identify the sequence. Let set this number to create form 
    *
    */
	public function nextOrderNumber()
	{
		return <?php echo $modelClass; ?>::model()->count() + 1;
	}
}
