<?php

class CatchFish extends BaseModel
{
    public $club_list_pic = '';

    public function tableName()
    {
        return '{{catch_fish}}';
    }

    /**
     * 模型验证规则
     */
    public function rules()
    {

        return array(
            array('id', 'required', 'message' => '{attribute} 不能为空'),
            array('time', 'required', 'message' => '{attribute} 不能为空'),
            array('fisherman_name', 'required', 'message' => '{attribute} 不能为空'),
            array('fisherman_phonenum', 'required', 'message' => '{attribute} 不能为空'),
            array('fisherman_idnum', 'required', 'message' => '{attribute} 不能为空'),
            array('boat_name', 'required', 'message' => '{attribute} 不能为空'),
            array('picture_of_boat', 'required', 'message' => '{attribute} 不能为空'),
            array('certificate_boat', 'required', 'message' => '{attribute} 不能为空'),
            array('valid_time_boat', 'required', 'message' => '{attribute} 不能为空'),
            array('certificate_catch', 'required', 'message' => '{attribute} 不能为空'),
            array('valid_time_catch', 'required', 'message' => '{attribute} 不能为空'),
            array('oil', 'required', 'message' => '{attribute} 不能为空'),
            array('company', 'required', 'message' => '{attribute} 不能为空'),
            array('state', 'required', 'message' => '{attribute} 不能为空'),

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
            'id'=>'ID',
            'time' => '时间',
            'fisherman_name' => '渔民姓名',
            'fisherman_phonenum' => '渔民手机号',
            'fisherman_idnum' => '渔民身份证',
            'boat_name' => '船名',
            'picture_of_boat' => '渔船的图片',
            'certificate_boat' => '所属国籍, 港籍, 有效日期, etc',
            'valid_time_boat' => '渔船证件有效期',
            'certificate_catch' => '捕捞许可证',
            'valid_time_catch' => '捕捞许可证有效期',
            'oil' => '渔船所用的油',
            'company' => '渔船所属公司',
            'state' => '已申报, 审核中, 审核通过,  ',
            'longitude' => '经度',
            'latitude' => '纬度',

            'f_name' => '名称',
            'f_type' => '类型',
            'f_type_CN' => '类型中文名',
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