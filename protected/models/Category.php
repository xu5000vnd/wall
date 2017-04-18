<?php

/**
 * This is the model class for table "{{_category}}".
 *
 * The followings are the available columns in table '{{_category}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $file_name
 * @property integer $parent_id
 * @property string $created_date
 * @property integer $status
 * @property integer $future
 */
class Category extends _BaseModel {
    public $uploadImageFolder = 'upload/category';
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{_category}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('status', 'required', 'on' => 'create, update'),
            array('name', 'unique', 'on' => 'create, update'),
            array('future, parent_id', 'numerical', 'integerOnly'=>true),
            array('name, description, file_name', 'length', 'max'=>45),
            array('created_date', 'safe'),
            ['name', 'required', 'on' => 'create, update'], 
            ['file_name','file','types'=>'jpg,png,gif', 'allowEmpty'=>false, 'on' => 'create'],
            ['file_name','file','types'=>'jpg,png,gif', 'allowEmpty'=>true, 'on' => 'update'],
            ['future', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            ['id, name, description, file_name, parent_id, created_date, status, future', 'safe', 'on'=>'search'],
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'rImage' => [self::HAS_MANY, 'Relate', 'one_id', 'condition' => 'rImage.model_one = "' . __CLASS__ . '" and rImage.model_many = "Image"' ],
            'rChildren' => [self::HAS_MANY, 'Category', 'parent_id'],
            'rRelateOne' => [self::HAS_MANY, 'Relate', 'one_id', 'condition' => 'rRelateOne.model_one = "' . __CLASS__ ],
            'rRelateMany' => [self::HAS_MANY, 'Relate', 'many_id', 'condition' => 'rRelateOne.model_many = "' . __CLASS__ ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('translation','ID'),
            'name' => Yii::t('translation','Name'),
            'description' => Yii::t('translation','Description'),
            'file_name' => Yii::t('translation','Upload'),
            'parent_id' => Yii::t('translation','Parent'),
            'status' => Yii::t('translation','Status'),
            'created_date' => Yii::t('translation','Created Date'),
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

        $criteria->compare('name',$this->name,true);
        $criteria->compare('future',$this->future);

        if(!empty($this->parent_id)) {
            $criteria->compare('parent_id', $this->parent_id);
        }

        $sort = new CSort();

        $sort->attributes = [
            '*',
            'name' => [
                'asc' => 't.id',
                'desc' => 't.id desc',
                'default' => 'asc',
            ],
        ];
        $sort->defaultOrder = 't.id asc';
                    
        return new CActiveDataProvider($this, [
            'criteria'=>$criteria,
                        'sort' => $sort,
            'pagination'=>[
                'pageSize'=> Yii::app()->setting->getItem('defaultPageSize'),
            ],
        ]);
    }

    public function searchExport()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        
        $criteria=new CDbCriteria;
    
        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('file_name',$this->file_name,true);
        $criteria->compare('parent_id',$this->parent_id);
        $criteria->compare('created_date',$this->created_date,true);
        $criteria->order = 'id DESC';
        $model = self::model()->findAll($criteria);
    
        if($model){
            return $model;
        }
        return ;
    }

    

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Category the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @author Lien Son
     * @todo: get Parent Cagetory
     */
    public static function getParentCategory() {
        return CHtml::listData(self::model()->findAll('parent_id = 0 and status = ' . STATUS_ACTIVE), 'id', 'name');
    }

    public function getNameParent() {
        if($this->parent_id) {
            $parent = self::model()->findByPk($this->parent_id);
            return $parent ? $parent->name : null;
        }

        return null;
    }


    public function behaviors() {
        return array('sluggable' => array(
            'class' => 'application.extensions.mintao-yii-behavior-sluggable.SluggableBehavior',
            'columns' => array('name'),
            'unique' => true,
            'update' => true,
        ));
    }

    protected function beforeDelete() {
        if(!empty($this->file_name)) {
            $this->deleteImage('file_name');
        }

        if(isset($this->rImage) && count($this->rImage) > 0) {
            foreach($this->rImage as $image_id) {
                $image = Image::model()->findByPk($image_id);
                if($image)
                    $image->delete();
            }
        }
        return parent::beforeDelete();
    }

    public static function getParents() {
        $criteria = new CDbCriteria;
        $criteria->compare('t.parent_id', "0");
        $criteria->compare('t.status', STATUS_ACTIVE);
        $criteria->order = 't.name ASC';

        return self::model()->findAll($criteria);
    }
}
