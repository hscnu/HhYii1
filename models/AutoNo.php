<?php 
    class AutoNo extends BaseModel {

        public function tableName() {
            return '{{auto_no}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
               array($this->safeField(), 'safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array();
        }

   
    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '内部自增id',
            'table_name' => '表名称',
            'table_id' => '表自增ID',
            'type_id' => '表类型id，根据',
            'code_project' => '编码前加代码',
            'code_ymd' => '年月日',//20210801
            'code_month' => '月',
            'code_day' => '日',
            'code_gfaccount' => '会员账号，服务机构编号，订单编号使用',
            'code_num' => '已生成的序号数字',
            'code_str' => '编号，触发器自动生成',
        );
    }
        /**
         * Returns the static model of the specified AR class.
         */
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        protected function beforeSave() {
            parent::beforeSave();
            return true;
        }
    /**
	 * 写入编码
	 * $param=array('table_name'=>$table,'code_table_name'=>$code_table_name,'table_id'=>$table_id,'code_param'=>'club_code','id_param'=>'id','code_length'=>'6'
	 * ,'code_year'=>date("Y"),'code_month'=>date("m"),'code_day'=>date("d"),'code_head'=>'');
	 * $code_table_name 为编码使用表（mall_sales_order_info编码使用表mall_shopping_settlement的编号计数，否则存在购买单与售后但一样的情况单）
	 * code_gfaccount 仅订单编码传入，不足前面补0 ,code_gfaccount_len补足位数
	 */  
	public function getCode_base($mode,$ymd='',$type=''){
        if(empty($ymd))  $ymd = date('Ymd');
         $w1="table_name='".$mode."' and code_ymd='".$ymd."'";
	     $tmp=$this->find($w1);
         if(empty($tmp)){
            $tmp=new AutoNo();
            $tmp->table_name=$mode;
            $tmp->code_ymd=$ymd;
            $tmp->code_num=0;
         }
         $tmp->code_num=  $tmp->code_num+1;
         $tmp->save();
         $s1='000'.'000'.'0000'.$tmp->code_num;
		 return $ymd.substr($s1, -4);
	  }
	  public function deleteorderid(){
          $ymd = date('Ymd');
          $w1="code_ymd=".$ymd;
          $tmp=$this->find($w1);
          $tmp->code_num=  $tmp->code_num-1;
      }
	
    }