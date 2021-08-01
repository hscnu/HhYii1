<?php

class Menu extends BaseModel {

    public function tableName() {
        return '{{menu}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            //array('', 'safe'),
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
            '﻿id' =>'id',
            'f_group' => '一级菜单',
            'f_code'  => '二级菜单编码',
            'f_name'  => '二级菜单名称',
            'f_url'  => '网页连接地址',
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


    public function getMenuold($ptypecode="",$ptc="") {
        $fp1 =Role::model()->getParent($ptypecode,$ptc);
        $pset='0';
        if(is_null($fp1)) $fp1="";
        $fp1=str_replace(' ','',$fp1);
        if(!empty($fp1)){
            $pset=str_replace('|',',',$fp1);
        }
        if(empty($pset)) $pset="0";
        $ws='F_mtype=2'.(($ptc=="") ? "" : ' and f_id in ('.$pset.")");
        return $this->findAll( $ws);
    }

    public function getMenu($ptypename="",$ptc="") {
        if(!empty($ptypename)){
//            $role=Role::model()->find("f_rname='".$ptypename."'");
            $role=Role::model()->find("f_rname='系统管理员'");

            $rop="1";
            if(!empty($role->f_opter)) $rop=$role->f_opter;
//            $tmp=$this->findAll(' f_show=1  and id in ('.$rop.") and f_no<>' ' ".$ptc." order by f_no");
            $tmp=$this->findAll('id in ('.$rop.") and f_no<>' ' ".$ptc." order by f_no");

        }
        else{
//            $tmp=$this->findAll(' f_show=1 order by f_no');
            $tmp=$this->findAll(' 1 order by f_no');

        }

        $m1='=';$st1="";
        $menu=array();
        foreach($tmp as $v1){
            if(($v1->f_group!==$m1)){
                $m1=trim($v1->f_group);
                $m2=array();
                foreach($tmp as $v2){
                    if($v2->f_group==$m1){
                        $url=trim($v2->f_url);
                        if(empty($url)) $url='public/late';
                        $m2[trim($v2->f_code)]=array(trim($v2->f_name),$url,$v2->f_id);
                    }
                }
                $st1.=','.$m1.',';
                $menu[]=array(trim($v1->f_group),$m2);
            }
        }
        return $menu;
    }

    public function getFirst($ptypename=[''],$ptc=''){
        if(!empty($ptypename)){
            $role=Role::model()->find("f_rname='".$ptypename."'");
            $rop="1";
            if(!empty($role->f_opter)) $rop=$role->f_opter;
            $tmp=$this->find('id in ('.$rop.") and f_no<>' ' ".$ptc." order by f_no");
        }
        if($ptypename=='系统管理员'){
            $tmp=$this->find(' 1 order by f_no');
        }
        if($tmp)
            return $tmp->f_url;
        else
            return 'public/index';
    }


}
 