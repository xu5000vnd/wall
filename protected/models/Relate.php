<?php

/**
 * This is the model class for table "{{_relate}}".
 *
 * The followings are the available columns in table '{{_relate}}':
 * @property integer $id
 * @property integer $one_id
 * @property integer $many_id
 * @property string $model_one
 * @property string $model_many
 * @property string $created_date
 */
class Relate extends _BaseModel {
	
	const NAME_CATEGORY = 'Category';
	const NAME_IMAGE = 'Image';
	const NAME_TAG = 'Tag';
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{_relate}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('one_id, many_id', 'numerical', 'integerOnly'=>true),
			array('model_one, model_many', 'length', 'max'=>200),
			array('created_date', 'safe'),
			['one_id, many_id, model_one, model_many, created_date', 'safe'],
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			['id, one_id, many_id, model_one, model_many, created_date', 'safe', 'on'=>'search'],
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return []; 
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('translation','ID'),
			'one_id' => Yii::t('translation','One'),
			'many_id' => Yii::t('translation','Many'),
			'model_one' => Yii::t('translation','Model One'),
			'model_many' => Yii::t('translation','Model Many'),
			'created_date' => Yii::t('translation','Created Date'),
		);
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Relate the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @author Lien Son
	 * @todo: save Relate
	 */
	public static function saveRelate($data = []) {
		if(is_array($data) && !empty($data)) {
			$one_id = isset($data['one_id']) ? $data['one_id'] : 0;
			$many_id = isset($data['many_id']) ? $data['many_id'] : [];
			$model_one = isset($data['model_one']) ? $data['model_one'] : 0;
			$model_many = isset($data['model_many']) ? $data['model_many'] : 0;

			if(is_array($many_id) && count($many_id) > 0) {
				Relate::deleteOldData($one_id, $model_one, $model_many);
				foreach ($many_id as $mId) {
					$model = new Relate();
					$model->one_id = $one_id;
					$model->many_id = $mId;
					$model->model_one = $model_one;
					$model->model_many = $model_many;
					$model->save();
				}
			}
		}
	}

	/**
	 * @author Lien Son
	 * @todo: delete old data
	 */
	public static function deleteOldData($one_id, $model_one, $model_many) {
		if(empty($one_id) || empty($model_one) || empty($model_many)) {
			return false;
		}

		$criteria = new CDbCriteria();
		$criteria->compare('t.one_id', $one_id);
		$criteria->compare('t.model_one', $model_one);
		$criteria->compare('t.model_many', $model_many);
		$models = self::model()->findAll($criteria);
		if($models) {
			foreach ($models as $model) {
				$model->delete();
			}
		}
	}
	
}
