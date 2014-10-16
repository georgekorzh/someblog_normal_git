<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property integer $id
 * @property string $comment
 * @property integer $post_id
 * @property integer $author_id
 * @property integer $parent
 */
class Comments extends CActiveRecord
{
    private $_parent_tree = array();
    public $return_tree = array();
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('comment, post_id, author_id', 'required'),
			array('post_id, author_id, parent', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, comment, post_id, author_id, parent', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
        // children - вывод потомков текущего комментария
		return array(
            'author' => array(self::BELONGS_TO, 'Users', 'author_id'),
            //'children' => array(self::HAS_MANY, 'Comments', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'comment' => 'Comment',
			'post_id' => 'Post',
			'author_id' => 'Author',
			'parent' => 'Parent',
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
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('post_id',$this->post_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('parent',$this->parent);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Comments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getSomeParent($id_post, $parent = 0, $level = 0)
    {

        if (!$this->return_tree) {

            $fetch = $this->with('author')->findAll('post_id=?', array($id_post));

            foreach ($fetch as $k => $val) {
                if(is_null($val->parent)){
                    $val->parent = '0';
                }
                $this->_parent_tree[$val->parent][] = $val;
            }
        }
        $return = array();
        if(isset($this->_parent_tree[$parent])){
            //echo '<pre>';
            foreach($this->_parent_tree[$parent] as $val){
                //var_dump($val);

                //$return[]= array($val, $level);
                $this->return_tree[]= array($val, $level);

                $level++;

                $this->getSomeParent($id_post, (int)$val->id, $level);

                $level--;
            }
        }

        return $this->return_tree;
    }
}
