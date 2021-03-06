<?php

class YzOnShelfInfo extends BaseModel
{
    // public $club_list_pic = '';

    public $check_save=1; //设置跳过检验标志符

    public function tableName()
    {
        return '{{yzonshelf_info}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        if($this->check_save)
            $a=array(
                array('apply_order', 'required', 'message' => '{attribute} 不能为空'),
                array('apply_date', 'required', 'message' => '{attribute} 不能为空'),
                array('apply_id', 'required', 'message' => '{attribute} 不能为空'),
                array('apply_name', 'required', 'message' => '{attribute} 不能为空'),


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
            'apply_order' => '申请上架单号',
            'apply_date' => '申请上架日期',
            'apply_id' => '申请者ID',
            'apply_name' => '申请者',
            'theme' => '主题',
            'remark' => '备注',
            'state' => '上架申请状态',
            'operate_time' => '操作时间',
            'auditor' => '审核员',
            'auditor_id' => '审核员ID',
            'audit_date' => '审核日期',
            'audit_opinion' => '审核意见'
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
}