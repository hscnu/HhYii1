<?php

class BaseCodeIce extends BaseModel {

    public function tableName() {
        return '{{base_code_ice}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_name', 'required', 'message' => '{attribute} 不能为空'),
            array('f_type', 'required', 'message' => '{attribute} 不能为空'),
            array('f_type_CN', 'required', 'message' => '{attribute} 不能为空'),
            array('f_code,f_name,f_group,f_type,f_type_CN,f_order', 'safe',),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */

    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'f_code' => '列表编码',
            'f_name' => '列表名称',
            'f_group' => '列表组别',
            'f_type' => '列表类型英文',
            'f_type_CN' => '列表类型中文',
            'f_order' => '组内序号',
        );
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

    // 获取单条数据，主表名转换为模型返回
    public function getOne($id, $ismodel = true) {
        $rs = $this->find('f_id=' . $id);
        if (!$ismodel) {
            return $rs;
        }

        if ($rs != null && $rs->user_table != '') {
            $modelName = explode(',',$rs->user_table);
            $arr = explode('_', $modelName[0]);
            $modelName[0] = '';
            foreach ($arr as $v) {
                $modelName[0].=ucfirst($v);
            }
            $rs->user_table = implode(',', $modelName);
            return $rs;
        } else {
            return $rs;
        }
    }

  public function getName($id) {
        $rs = $this->find('f_id=' . $id);
        return  str_replace(' ','',is_null($rs->F_NAME) ? "" : $rs->F_NAME);
    }

    public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }
    
    public function getAttrtype() {
        return $this->findAll('fater_id in(349,350,360,362)');
    }
    
    public function getOrderType2() {
        $cooperation= $this->getOrderType();
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
                $arr[$r]['f_id'] = $v->f_id;
                $arr[$r]['F_NAME'] = $v->F_NAME;
                $arr[$r]['fater_id'] = $v->fater_id;
                $r=$r+1;
        }
        return $arr;
    }
    
    public function getOrderType() {
        return $this->findAll('fater_id in(350,360,362,367)');
    }
    
    //return $this->findAll('fater_id in (8,9,189,380,495)');
    //return $this->findAll('fater_id=' . $f_id);
    public function getGrouptypestate() {
        return $this->getCode(32);
    }

    public function getClub_type2() {
        $cooperation= $this->getClub_type2_all();
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
                $arr[$r]['f_id'] = $v->f_id;
                $arr[$r]['F_NAME'] = $v->F_NAME;
                $arr[$r]['fater_id'] = $v->fater_id;
                $r=$r+1;
        }
        return $arr;
    }

   public function getClub_type2_all() {
        return $this->findAll('fater_id in (8,9,189,380,495)');
    }
    //return  $this->findAll("F_TCODE='PARTNAME' and fater_id<>10 and fater_id<>0");

    public function getSex($f_id) {
        return $this->findAll('f_id in (205,207)');
    }  
  function get_name_set_by_code($code) 
{ return  parent::delete_by_key("f_id=".$news_id);}

 function get_combo($code)
  {
       $ws= " f_code='".$code ."' and F_COL2=1  ";//and club_type=".$club_type;
       return $this->findAll($ws);
   }

 function get_combo2($code)
  {
       return $this->get_by_code($code);
   }

       // 学员申请状态
   public function getUsertype() {///695服务者类型描图
        return $this->getCode(886);
    }
   
        // 学员申请状态

  function get_by_code($pcode){
    $s1="left(f_code,".strlen($pcode).")='".$pcode."' and left(f_value,1)<>' '";

    return $this->findAll($s1);
  }


   public function getLevel() {///695服务者类型描图
        return $this->getTcode('LEVEL');
    }
   public function getClass() {///695服务者类型描图
        return $this->getTcode('CLASS');//CLASS
    }
   public function getTerm() {///695服务者类型描图
        return $this->getTcode('TERM');
    }   
    public function getYear() {///695服务者类型描图
        return $this->getTcode('YEAR');
    }


  public function getTcode($ftcod) {
        return $this->findAll("left(f_code,".strlen($ftcod).")='".$ftcod."'");
    }  

    function get_years_chose() {   
        $data = array();
        $data['terms']   =$this->getTerm();
        $data['years']   = $this->getYear();
        $data['levels']  =$this->getLevel();
        $data['classes'] = $this->getClass();
        return $data;
    }

    public function getByType($f_type,$f_order='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("f_type = :f_type");
        $criteria->params[':f_type']=$f_type;


        if(!empty($f_order)) $criteria->order='f_name ASC';

        $result=$this->model()->findAll($criteria);
        return $result;
    }
        public function getByType2($f_type) {
           $tmp=$this->model()->findAll("f_type_CN='申报职称（".$f_type."）'");
           put_msg(toIoArray($tmp,'f_name,f_type,f_type_CN'));
        return $tmp;
    }
    public function getAllType(){
        $criteria = new CDbCriteria();
        $criteria->select = 'f_type,f_type_CN';
        $criteria->group = 'f_type,f_type_CN';
        $result=$this->model()->findAll($criteria);
        return $result;
    }


}
