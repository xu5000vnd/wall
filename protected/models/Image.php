<?php

/**
 * This is the model class for table "{{_image}}".
 *
 * The followings are the available columns in table '{{_image}}':
 * @property integer $id
 * @property string $name
 * @property string $file_name
 * @property string $description
 * @property string $created_date
 */
class Image extends _BaseModel {
    
    public $category;
    public $arrCategory;
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{_image}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'length', 'max'=>100),
            array('file_name', 'length', 'max'=>255),
            array('description, created_date', 'safe'),
             ['name,arrCategory', 'required', 'on' => 'create, update'], 
            ['arrCategory', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            ['id, name, file_name, description, created_date, catetory', 'safe', 'on'=>'search'],
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
            'rCategory' => [self::HAS_MANY, 'Relate', 'one_id', 'condition' => 'rCategory.model_one = "' . get_class($this) . '" and rCategory.model_many = "Category"' ],
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
            'file_name' => Yii::t('translation','File Name'),
            'description' => Yii::t('translation','Description'),
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

        $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('file_name',$this->file_name,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('created_date',$this->created_date,true);
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
                'pageSize'=> Yii::app()->params['defaultPageSize'],
            ],
        ]);
    }

    public function searchExport()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        
        $criteria=new CDbCriteria;
    
                $criteria->compare('id',$this->id);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('file_name',$this->file_name,true);
        $criteria->compare('description',$this->description,true);
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
     * @return Image the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }


    public function renderImage($fieldName = 'file_name', $imageRoot = false, $w = 100) {
        if(!empty($this->$fieldName)) {
            if($imageRoot) {
                return CHtml::Image($this->getImage($fieldName), $this->$fieldName);
            } else {
                return CHtml::Image($this->getImage($fieldName), $this->$fieldName, ['style' => "width = {$w}px"]);
            }
        }
        return null;
    }

    public function renderListCheckboxCategory() {
        $listChecked = [];
        if(!empty($this->arrCategory)) {
            $listChecked = $this->arrCategory;
        }
        $html = '';
        $parents = Category::getParents();
        if(count($parents) > 0) {
            foreach ($parents as $parent) {
                $parentChecked = '';
                if(in_array($parent->id, $listChecked)) {
                    $parentChecked = 'checked="checked"';
                }

                $child = '';
                if(isset($parent->rChildren) && count($parent->rChildren) > 0) {
                    foreach ($parent->rChildren as $children) {
                        $chilChecked = '';
                        if(in_array($children->id, $listChecked)) {
                            $chilChecked = 'checked="checked"';
                        }

                        $child .= "
    <li>
        <input type='checkbox' id='id-{$children->slug}' name='category[]' value='{$children->id}' {$chilChecked} />
        <label for='id-{$children->slug}'>{$children->name}</label>
    </li>
                        ";
                    }
                }

                $html .= "
    <ul>
        <li>
            <a role='button' data-toggle='collapse' href='#collage-{$parent->slug}' aria-expanded='false' aria-controls='collage-{$parent->slug}'>+</a> 
            <input type='checkbox' id='id-{$parent->slug}' name='category[]' value='{$parent->id}' {$parentChecked} />
            <label for='id-{$parent->slug}'>{$parent->name}</label>
            <ul class='collapse in' id='collage-{$parent->slug}'>
               {$child} 
            </ul>
        </li>
    </ul>
                ";
            }
        }

        echo $html;

    }
}
