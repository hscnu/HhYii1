<?php

class FishingReport extends BaseModel
{
    public $club_list_pic = '';
    public $check_save=1; //设置跳过检验标志符
    public function tableName()
    {
        return '{{fishingreport}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        if($this->check_save)
        $a=array(
            // array('id', 'required', 'message' => '{attribute} 不能为空'),
            array('name', 'required', 'message' => '{attribute} 不能为空'),
        
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
            'state'=>'状态',
            'number'=>'表单号',
            'reason'=>'退回原因',
            'name' => '上报人姓名',
            'company'=>'公司名称',
            'count'=>'记录数',
            'fishingtime' => '捕鱼时间',
            'reporttime'=>'上报时间',
            'telephone'=>'联系电话',


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

    public function getInfoFromMenu($views,$field) {
       $tmp1=Menu::model()->find("f_name='".$views."'");
       return $tmp1->{$field};
    }
}