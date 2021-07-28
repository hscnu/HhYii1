<?php

class BaseModel extends CActiveRecord {

    public $select_id='';
    public $select_code='';
    public $select_title='';
    public $select_item1='';
    public $select_item2='';
    public $select_item3='';

    protected function afterSave() {
        parent::afterSave();
    }


    protected function beforeSave() {
        parent::beforeSave();
        $tname= str_replace('{','',$this->tableName());
        $tname= str_replace('}','',$tname);
        $this->movePath();//删除路径，保留相对路径

        if(!($tname=="table_update")){
            if(!$this->getIsNewRecord()) $this->update_log($tname);
        }
        return true;
    }
    protected function afterDelete() {
        parent::afterDelete();
    }

    protected function movePath(){
        $ds=$this->getPicField();
        foreach($ds as $v1){ //加上路径名称
            $this->{$v1}=BasePath::model()->reMovePath($this->{$v1});
        }
    }

    //获得表的图片属性名称
    protected function getPicField($method='picLabels') {
        $rs=array();
        if(method_exists($this,$method)){
            $ds=$this->{$method}();
            $afieldstr=$ds;
            if(is_array($ds)){
                $afieldstr=$ds['fields'];//要处理的图片名称
            }
            $rs=explode(',',$afieldstr);
        }
        return $rs;
    }


    public function safeField($type='safe') {
        $dm=$this->safeFieldArray($type);
        return  implode(',',array_keys($dm));

    }

    public function safeFieldArray($type='safe'){
        $dm=$this->AutoGetAttributeLabels(); //全字段
        if($type=='show') {
            $dm = $this->attributeLabels(); //全字段或者自定义字段
//            $dm = array_slice($dm,1);
        }
        return $dm;
    }

    protected function AutoGetAttributeLabels(){
        $table_name = trim($this->tableName(),"{}");
        $res=sql_findall('SHOW FULL COLUMNS FROM '.$table_name);
        $arr=array();
        foreach($res as $v){
            $arr[$v['Field']]=$v['Comment'];
        }
        return $arr;
    }

    protected function update_log($tname) {
        $dm=$this->attributeLabels();
        $tmp0=sql_findall('SHOW FULL COLUMNS FROM '.$tname);
        $key="";
        foreach($tmp0 as $v)
        {
            if($v['Key']=='PRI'){
                $key=$v['Field'];
                break;
            }
        }
        $val=$this->{$key};
        $tmp2=$this->find($key."='".$val."'");
        $data=array();
        foreach($tmp0 as $v)
        {
            $k=$v['Field'];
            if(isset($this->{$k})){
                $s1=$tmp2->{$k};
                $s2=$this->{$k};
                if(!($s1==$s2)){
                    $data[$k]=array($s1,$s2);
                }
            }
        }
        save_change($tname,0,$data,$key,$val);//0修改 1 删除
    }

    public  function gridHead($fs='') {
        $s1="";
        $dm=$this->getFields($fs);
        foreach($dm as $k)
        {
            $s1.='<th>'.$this->getAttributeLabel($k).'</th>';
        }
        return $s1;

    }

    public  function gridRow($fs='') {
        $s1="";
        $dm=$this->getFields($fs);

        foreach($dm as $k)
        {
            $s2=$this->{$k};
            if(indexof($s2,'uploads/temp')>=0){
                $s2='<img src="'.$s2.'" height="60px" width="60px">';
            }
            $s1.='<td>'.$s2.'</td>';
        }
        return $s1;
    }

    public  function getFields($r) {
        if(empty($r))  $r=$this->safeField('show');
        return explode(',',$r);
    }

    public function showUpdate($form,$filed,$formType='textField',$formOptions=array()){
        $model=$this;
        $str=
            '<tr>'.
            '<td>' .$form->labelEx($model, $filed).'</td>'.
            '<td>';

        $str.=
            $form->textField($model, $filed, array_merge(array('class' => 'input-text'),$formOptions));

        $str.=
            $form->error($model, $filed, $htmlOptions = array()).
            '</td>'.
            '</tr>';
        return $str;
    }


}
