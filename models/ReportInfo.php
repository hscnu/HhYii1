<?php

class ReportInfo extends BaseModel
{
    // public $club_list_pic = '';

    public $check_save=1; //设置跳过检验标志符

    public function tableName()
    {
        return '{{report_info}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        if($this->check_save)
            $a=array(
                array('report_order', 'required', 'message' => '{attribute} 不能为空'),
                array('report_date', 'required', 'message' => '{attribute} 不能为空'),
                array('reporter_id', 'required', 'message' => '{attribute} 不能为空'),
                array('reporter_name', 'required', 'message' => '{attribute} 不能为空'),


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
            'report_order' => '上报单号',
            'report_date' => '上报日期',
            'reporter_id' => '上报者ID',
            'reporter_name' => '上报者',
            'theme' => '主题',
            'state' => '上报状态',
            'operate_time' => '操作时间',
            'checktor' => '审核员',
            'checktor_id' => '审核员ID'

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