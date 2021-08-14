<?php


class IceType extends BaseModel
{
    public $check_save=1;


    public function tableName()
    {
        return '{{ice_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {
        if($this->check_save)
            $a=array(
                array('ice_type', 'required', 'message' => '{attribute} 不能为空'),
                array('ice_id', 'required', 'message' => '{attribute} 不能为空'),
                array('specification', 'required', 'message' => '{attribute} 不能为空'),
                array('unit_price', 'required', 'message' => '{attribute} 不能为空')
            );
        $a[]= array($this->safeField(), 'safe');
        return $a;
    }

    /**
     * 模型关联规则
     */
    public function relations()
    {
        return array();
    }

    /**
     * 属性标签
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'ice_id' => '冰的编号',
            'ice_type' => '冰名称',
            'specification'=>'规格',
            'unit_price'=>'单价'
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCode()
    {
        return $this->findAll('1=1');
    }

    public function getByType($f_type,$f_order='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("f_type = :f_type");
        $criteria->params[':f_type']=$f_type;


        if(!empty($f_order)) $criteria->order='f_name ASC';

        $result=$this->model()->findAll($criteria);
        return $result;
    }
}