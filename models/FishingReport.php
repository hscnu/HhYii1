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
                //array('name', 'required', 'message' => '{attribute} 不能为空'),

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
            'id' => '表单号',
            'state'=>'状态',
            'boatname'=>'船名',
            'name' => '上报人姓名',
            'company'=>'公司名称',
            'count'=>'记录数',
            'fishingtime' => '捕鱼时间',
            'reporttime'=>'上报时间',
            'userId'=>'用户',
            'remark'=>'备注',
        );
    }


    public function getInfoFromMenu($views,$field) {
        $tmp1=Menu::model()->find("f_name='".$views."'");
        return $tmp1->{$field};
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


    public function getStateName($state='')
    {

        $a=array(
            '1'=>'待审核',
            '2'=>'审核通过',
            '3'=>'审核不通过',

        );
        return isset($a[$state])?$a[$state]:'未知状态';
    }

    protected function beforeSave() {

        $this->userId=get_session('userId');

        parent::beforeSave();
        return true;
    }

}