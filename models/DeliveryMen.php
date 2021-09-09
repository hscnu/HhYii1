<?php


class DeliveryMen extends BaseModel
{
    public $check_save=1;


    public function tableName()
    {
        return '{{delivery_men}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {
        if($this->check_save)
            $a=array(
                array('name', 'required', 'message' => '{attribute} 不能为空'),
                array('deliver_id', 'required', 'message' => '{attribute} 不能为空'),
                array('tel', 'required', 'message' => '{attribute} 不能为空')
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
            'name' => '姓名',
            'deliver_id' => '送货人ID',
            'tel'=>'送货人电话'
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
    public function create($deliver_id,$name,$tel)
    {
        $model=new DeliveryMen();
        $model->deliver_id=$deliver_id;
        $model->name=$name;
        $model->tel=$tel;
        $model->save();
    }
}