<?php

class DisinfectionSummaryDetail extends BaseModel {

    public $check_save=1;
    public $club_list_pic = '';

    public function tableName() {
        return '{{disinfection_summary_detail}}';
    }

    /**health_list
     * 模型验证规则
     */
    public function rules() {

        if($this->check_save)
            $a=array(
                // array('id', 'required', 'message' => '{attribute} 不能为空'),
                //array('restaurant_id', 'required', 'message' => '{attribute} 不能为空'),

                //array('complete_time', 'required', 'message' => '{attribute} 不能为空'),

            );

        $a[]= array($this->safeField(), 'safe');
        return $a;

    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签若没有自定义则调用父类方法自动自动显示全部字段
     */
    public function attributeLabels(){
        return array(
            'id' => 'ID',
            'tableware_name' => '餐具名称',
            'date' => '日期',
            'number' => '数量',
            'cost' => '单价',
            'total_price' => '总价',
            'disinfection_center_name' => '消毒中心名称',
            'restaurant_name' => '酒楼名称',
        );
    }

    /**
     * 自定义属性标签
     * */
    public function DiyAttributeLabels(){
        return array(
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getCode()
    {
        return $this->findAll('1=1');
    }
    //添加明细
    public function actionAddDetail($order_tmp){
        $model=new DisinfectionSummaryDetail();
        $model->date=$order_tmp->complete_time;
        $order_Detail_temps=DisinfectionOrderDetail::model()->findAll('order_id='.$order_tmp->id);
        foreach ($order_Detail_temps as $tmp){
            $model=new DisinfectionSummaryDetail();
            $model->date=$order_tmp->complete_time;
            $model->tableware_name=$tmp->tableware_name;
            $model->number=$tmp->number;
            $model->cost=$tmp->cost;
            $model->total_price=$tmp->total_cost;
            $model->disinfection_center_name=$order_tmp->disinfection_name;
            $model->restaurant_name=$order_tmp->restaurant_name;
            $model->save();
        }
        DisinfectionSummary::model()->addSummary($order_tmp);
    }
    public function connectDetail_DateRestaurantDisinfection($summary_temp){
        $models=$this->findAll("date='".$summary_temp->complete_date."'"." and restaurant_name='".$summary_temp->restaurant_name."'"." and disinfection_center_name='".$summary_temp->disinfection_center_name."'");
        $total_price=0;
        $detail_number=0;
        foreach ($models as $m){
            $total_price+=$m->total_price;
            $detail_number++;
            $m->summary_id=$summary_temp->id;
            $m->save();
        }
        return array(
            'total_price'=>$total_price,
            'detail_number'=>$detail_number
        );
    }

}
