<?php

class Dish extends BaseModel {

    public function tableName() {
        return '{{dish}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('d_name', 'required', 'message' => '{attribute} 不能为空'),
            array('d_name', 'unique', 'message' => '已存在{attribute}!'),
            array('d_price', 'required', 'message' => '{attribute} 不能为空'),
            array('d_price','numerical','min'=>'0'),
            array('d_rest', 'required', 'message' => '{attribute} 不能为空'),
            array('d_rate', 'required', 'message' => '{attribute} 不能为空'),
            array('d_introduce', 'required', 'message' => '{attribute} 不能为空'),
            array('d_name,d_price,r_rest,d_introduce,d_image,d_rate','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array('d_name'=>array(self::BELONGS_TO, 'restaurant', 'd_rest'));
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'd_name'=>'菜名',
            'd_rest'=>'饭店',
            'd_price'=>'价格',
            'd_introduce'=>'菜品介绍',
            'd_image'=>'图片',
            'd_rate'=>'好评率',
        );
    }
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function put_msg($pmsg)
    {
//        $this->isNewRecord = true;
//        $this->f_msg=$pmsg;
//        $this->save();
    }

    protected function afterFind()
    {

        parent::afterFind(); // TODO: Change the autogenerated stub
        $this->d_image=addUploadPath($this->d_image);

    }


    protected function beforeSave()
    {
        parent::beforeSave();
        return true;
    }

}
