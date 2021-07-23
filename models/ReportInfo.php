<?php

class ReportInfo extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{report_info}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
            array('report_order', 'required', 'message' => '{attribute} 不能为空'),
            array('report_date', 'required', 'message' => '{attribute} 不能为空'),
            array('reporter_name', 'required', 'message' => '{attribute} 不能为空'),

            array($this->safeField(), 'safe',),
        );
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
            'reporter_name' => '上报者',
            'state' => '上报状态',
            'operate_time' => '操作时间',
            'checktor' => '审核员',


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