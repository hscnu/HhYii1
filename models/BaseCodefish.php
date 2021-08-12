<?php

class BaseCodefish extends BaseModel {

    public function tableName() {
        return '{{base_code_fish}}';
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



    public function getByType($f_type,$f_order='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("f_type = :f_type");
        $criteria->params[':f_type']=$f_type;


        if(!empty($f_order)) $criteria->order='f_name ASC';

        $result=$this->model()->findAll($criteria);
        return $result;
    }

    public function getAllType(){
        $criteria = new CDbCriteria();
        $criteria->select = 'f_type,f_type_CN';
        $criteria->group = 'f_type,f_type_CN';
        $result=$this->model()->findAll($criteria);
        return $result;
    }


}
