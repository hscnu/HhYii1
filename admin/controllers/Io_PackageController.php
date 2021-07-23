<?php

class Io_PackageController extends BaseController {
    protected $model = 'Package';
    protected $msg_arr = array(
        '已经申请代领，等待主人回应中',
        '已获得包裹主人授权，请尽快取件送货',
        '包裹主人已拒绝您的申请，请试试别的包裹哦'
    );


    // 获取包裹列表 模板
    public function actionGetPackageList($viewsask='',$s='',$w2='',$is_show='1',$order_by='',$order_rule=''){
        $limit=DecodeAsk('limit','10');
        $offset=DecodeAsk('offset','0');
        $views=DecodeAsk('views',$viewsask);
        $order_by=$order_by==''?DecodeAsk('order','id'):$order_by;
        $order_rule=$order_rule==''?DecodeAsk('order_rule','ASC'):$order_rule;
        $key=DecodeAsk('keywords','');
        if($views)
            $m=Menu::model()->find("f_name = '".$views."'");
        $w1=(!empty($m))?empty($m->p_condition)?'1':$m->p_condition:'1';
        $w2=(!$w2)?'':' and '.$w2;
        $key=(!$key)?'':" and dl_address like '%".$key."%' ";
        $tmp =Package::model()->findAll($w1.' '.$w2.' '.$key.' order by '.$order_by.' '.$order_rule.' limit '.$offset.','.$limit);
        $this->power_filter($tmp,$is_show);
        $this->DataToWX($tmp,$s,$viewsask.'获取成功',array('isHideLoadMore'=>count($tmp)==$limit?false:true,'Post'=>$_POST),array());
    }


    /*
     * 详情页面不加密显示:
       包裹设置开放
       代领人==自己
       存在未过期的邀请
     * */

    public function power_filter($tmp,$is_show){
        if($is_show=='1')return;
        if(DecodeAsk('admin')==1)return;
        foreach ($tmp as $v) {
            if ($is_show == '2') //详情页开放情况
            {
                $p1=ApplyState::model()->findAll('in_id='.DecodeAsk('userId','0').' and type = 1 and state <> 3 and package_id='.DecodeAsk('id'));
                if(!empty($p1)){return;} //存在未过期的邀请
                if($v->dl_id==DecodeAsk('userId','0')){//代领人是自己
                    return;
                }
            }

            if( $v->show_switch == '0'||$v->show_switch == ''){
                $this->encode($v);
            }
        }
    }

    public function encode($v){
        $v->c_name = mb_substr ($v->c_name,0,1).'**';
        $v->p_name='******';
        $v->c_number='******';
        $v->dl_contact='******';
    }


    //给包裹信息附加用户信息
    public function AddPacInfo($tmp,$varname){
        $arr=array();
        $arr=$tmp;
        foreach ($tmp as $v){
            $pac=Package::model()->find('id = '.$v->package_id);
            $arr[]= array_merge((array)$v,array($varname=>$pac->{$varname}));
        }
        return $arr;
    }


    //输出JSON数据   第一个数组用于附加res.data 第二个数组附加res.data.data
    public function DataToWx($tmp,$s,$msg,$arr=array(),$arr2=array()){
        $data = toIoArray($tmp,$s,$arr2);
        $total=is_array($tmp)?count($tmp):1;
        $rs=array('data'=>$data,'total'=>$total,'code'=>'200','msg'=>$msg,'time' => time());
        $rs=array_merge($rs,$arr);
        echo json_encode($rs);
    }

    //获取等待代领列表
    public function actionGetPackageList_HelpWait(){
        $s = 'id:id,p_id:pGetPackageList_PickUpWait_id,c_name:c_name,p_name:p_name,dl_contact,dl_address,sex:sex,register_time,p_size';
        $this->actionGetPackageList('等待代领',$s,'dl_id=0 and c_id !='.DecodeAsk('userId','0'),'0');
    }


    //代领广场 根据包裹ID获取包裹信息
    public function actionGetPackageById($is_show='2'){
        $s = 'id:id,p_id:p_id,c_name:c_name,p_name:p_name,dl_contact:dl_contact,dl_address:dl_address,sex:sex,register_time,dl_switch:dl_switch,dl_id:dl_id,dl_contact:dl_contact,dl_address:dl_address,remarks:remarks,show_switch:show_switch,latest_liuyan';
        $this->actionGetPackageList('',$s,'id = '.DecodeAsk('id',0),$is_show);
    }

    //我的包裹 根据包裹ID获取包裹信息
    public function actionGetMyPackageById(){
        $this->actionGetPackageById('1');
    }


    //根据用户ID 获取待取包裹--本人包裹
    public function actionGetPackageList_PickUpWaitList(){
        $s = 'id,p_id,c_name,p_name,dl_contact,dl_address,sex,register_time,remarks,dl_contact,dl_address,wx_checked:checked,au_code,dl_name,dl_switch,host_weidu,dl_weidu,pick_state,latest_liuyan';
        $this->actionGetPackageList('等待取件',$s,'confirm_receipt_state = 0 and help_state=0 and c_id = '.DecodeAsk('userId',0));
    }

    //根据用户ID 获取待取包裹--帮领取包裹
    public function actionGetPackageList_HelpWaitList(){
        $s = 'id,p_id,c_name,p_name,dl_contact,dl_address,sex,register_time,remarks,dl_contact,dl_address,wx_checked:checked,au_code,dl_name,dl_switch,host_weidu,dl_weidu,pick_state,latest_liuyan';
        $this->actionGetPackageList('等待取件',$s,'help_state = 0 and dl_id = '.DecodeAsk('userId',0));
    }

    //管理员界面 获取待取包裹--本人包裹
    public function actionGetAdminPackageList_PickUpWaitList(){
        $s = 'id,p_id,c_name,p_name,dl_contact,dl_address,sex,register_time,remarks,dl_contact,dl_address,wx_checked:checked,au_code,dl_name,dl_switch';
        $this->actionGetPackageList('等待取件',$s,'pick_state = 0 and c_id = '.DecodeAsk('userId',0));
    }

    //管理员界面 获取待取包裹--帮领取包裹
    public function actionGetAdminPackageList_HelpWaitList(){
        $s = 'id,p_id,c_name,p_name,dl_contact,dl_address,sex,register_time,remarks,dl_contact,dl_address,,wx_checked:checked,au_code,dl_name,dl_switch';
        $this->actionGetPackageList('等待取件',$s,'pick_state = 0 and dl_id = '.DecodeAsk('userId',0));
    }


    //根据用户ID 获取在送包裹--本人包裹
    public function actionGetPackageList_ReceiveWaitList(){
        $s = 'id,p_id,c_name,p_name,dl_contact,dl_address,sex,register_time,remarks,dl_contact,dl_address,wx_checked:checked,au_code,,help_time,host_weidu,dl_weidu,dl_name,latest_liuyan';
        $this->actionGetPackageList('等待收货',$s,'c_id = '.DecodeAsk('userId',0));
    }

    //根据用户ID 获取在送包裹--帮送包裹
    public function actionGetPackageList_SentWaitList(){
        $s = 'id,p_id,c_name,p_name,dl_contact,dl_address,sex,register_time,remarks,dl_contact,dl_address,wx_checked:checked,au_code,help_time,host_weidu,dl_weidu,dl_name,latest_liuyan';
        $this->actionGetPackageList('等待收货',$s,'picker_id = '.DecodeAsk('userId',0));
    }


    //根据用户ID获取帮领过包裹
    public function actionGetPackageList_HelpHistoryList(){
        $s = 'id:id,p_id:p_id,c_name:c_name,p_name:p_name,dl_contact:dl_contact,dl_address:dl_address,sex:sex,register_time:register_time,confirm_receipt_time';
        $this->actionGetPackageList('已经取件',$s,'confirm_receipt_state=1 and dl_id = '.DecodeAsk('userId',0),'1','confirm_receipt_time','DESC');
    }

    //根据用户ID获取历史包裹
    public function actionGetPackageList_MyHistoryList(){
        $s = 'id:id,p_id:p_id,c_name:c_name,p_name:p_name,dl_contact:dl_contact,dl_address:dl_address,sex:sex,register_time:register_time,confirm_receipt_time';
        $this->actionGetPackageList('已经收货',$s,'confirm_receipt_state=1 and c_id = '.DecodeAsk('userId',0),'1','confirm_receipt_time','DESC');
    }

    //申请代领 通用
    public function actionWebAppluDl(){
        $package_id=DecodeAsk('pg_id',0);
        $userId=DecodeAsk('userId',0);
        $remark=DecodeAsk('remark','');
        $userName=user::model()->find('userId='.$userId)->userName;
        $Pac = Package::model()->find('id = '.$package_id);
        $tmp = new ApplyState();
        $tmp->c_id=$Pac->c_id;
        $tmp->out_id=$userId;
        $tmp->in_id=$Pac->c_id;
        $tmp->out_name=$userName;
        $tmp->in_name=$Pac->c_name;
        $tmp->package_id =$package_id;
        $tmp->out_remark= $remark;
        $tmp->p_name=$Pac->p_name;
        $tmp->state = 0;  //0未同意 1已同意 2已拒绝 3已过期 -1撤销发出 -2撤销同意
        //本人收件 撤销该申请
        $tmp->out_state=$tmp->in_state=0;
        $tmp->apply_time=Date('Y-m-d H:i:s');
        $tmp->type= 0;  //0我要代领 1邀请代领
        $tmp->save();
        LogInfo($tmp);
    }


    //主动申请代领  包裹ID  申请者ID  小程序用
    public function actionApplyDl(){
        $this->actionWebAppluDl();
        echo json_encode(array('code'=>'200','time'=>time(),'msg'=>'设置成功'));
    }

    //网页用
    public function actionApplyDl2(){
        $this->actionWebAppluDl();
        echo '申请成功';
    }

    //用户点击代领开关
    public function actionSwitchChange_dl(){
        $package_id=DecodeAsk('id',0);
        $tmp=Package::model()->find('id='.$package_id);
        $tmp->dl_switch=0;
        if($tmp->dl_switch==0){ //关闭时 将邀请和申请信息设置为3:过期
            $InfoArr=ApplyState::model()->findAll('package_id='.$package_id);
            if(!empty($InfoArr)){
                foreach ($InfoArr as $Info){
                    $Info->state=3;  //过期
                    $Info->answer_time=Date('Y-m-d H:i:s');
                    $Info->save();
                    UpdateLog($Info);
//                    LogInfo($Info,$Info->in_id,$Info->out_id,'主人关闭代领，申请已经过期','1');
                    $tmp->dl_id=0;//代领人设置为空
                    $tmp->dl_name='';
                }
            }
        }
        $tmp->save();
        echo json_encode(array('code'=>'200','msg'=>'改变代领开关为'.$tmp->dl_switch));
    }

    //用户点击代领开关
    public function actionSwitchChange_show(){
        $package_id=DecodeAsk('id',0);
        $tmp=Package::model()->find('id='.$package_id);
        $tmp->show_switch=!$tmp->show_switch;
        $tmp->save();
        echo json_encode(array('code'=>'200','msg'=>'改变显示开关'));
    }

//打开代领开关
    public function actionSubmitToDl(){
        $package_id=DecodeAsk('id',0);
        $tmp=Package::model()->find('id = '.$package_id);
        $tmp->dl_switch=1;
        $tmp->remarks=DecodeAsk('remarks','');
        $tmp->dl_contact=DecodeAsk('dl_contact','');
        $tmp->dl_address=DecodeAsk('dl_address','');
        $tmp->save();
        echo json_encode(array('code'=>'200','msg'=>'设置代领成功'));

    }


    //根据包裹ID 获得申请用户详情
    public function actionGetApplyInfo(){
        $userId=DecodeAsk('userId','0');
        $package_id=DecodeAsk('pg_id','0');
        $User=user::model()->find('userId='.$userId);
        $Info=ApplyState::model()->find('state<>3 and package_id='.$package_id.' and type=0 and out_id='.$userId);//申请类型
        $Pac=Package::model()->find('id='.$package_id);
        $msg_arr=$this->msg_arr;
        $au_code='';

        //如果没有申请信息,找邀请类型已经同意的
        if(empty($Info)){
            $Info=ApplyState::model()->find('package_id='.$package_id.' and type=1 and state=1 and in_id='.$userId);
        }
        if(empty($Info)) return;
        $remark=$Info->out_remark;
        $apply_time=$Info->apply_time;
        $in_state=$Info->in_state;
        $type=$Info->type;

//        if($Info->state==1){ //随机生成3位 分别标志代领者和包裹
//            $Pac->au_code=$this->GetAuCode('Package',3);
//            $User->au_code=$this->GetAuCode('User',3);
//            $User->save();
//            $Pac->save();
//            $au_code=$User->au_code.$Pac->au_code;
//        }
        $apply_info=array(array('userName'=>$User->userName,'user_contact'=>!empty($User->contact_info)?$User->contact_info:$User->PHONE,
            'remark'=>$remark,'apply_time'=>$apply_time,'in_state'=>$in_state,'state'=>$Info->state,'au_code'=>$au_code,
            'type'=>$type
        ));
        echo json_encode(array('data'=>$apply_info,'isapply'=>'1','code'=>'200','time'=>time(),'msg'=>$msg_arr[$Info->state]));

    }

//    public function GetRandCode($length){
//        $pattern = '1234567890ABCDEFGHIJKLOMNOPQRSTUVWXYZ';
//        $key='';
//         for($i=0;$i<$length;$i++) {
//             $key .= $pattern{mt_rand(0,35)}; //生成php随机数
//          }
//         return $key;
//    }
//
//    public function GetAuCode($modelName,$length){
//        do{
//            $au_code=$this->GetRandCode($length);
//        }
//        while(!empty($modelName::model()->find("au_code='".$au_code."'")));
//        return $au_code;
//    }

    public function  actionReadMyInfo(){
        $tmp=InfoLog::model()->find('id='.DecodeAsk('logid'));
        $tmp->in_state=1;
        $tmp->save();
        echo json_encode(array('R'=>$_REQUEST,'code'=>'200','time'=>time(),'msg'=>'已读成功'));

    }

    //获取我的消息列表
    public function GetMyInfo($wkey,$w='1'){
        $userId=DecodeAsk('userId',0);
//        $arr=array('out'=>'apply_time','in'=>'answer_time');
        $tmp=InfoLog::model()->findAll($w.' and '.$wkey.'_id = '.$userId.' order by id DESC');
        $s="id,package_id,apply_time,in_name,out_name,answer_time,out_remark,in_remark,type,out_state,in_state,p_name,state,sys_msg,is_answer";
        $this->DataToWx($tmp,$s,'消息列表获取成功',array('w'=>$w.' and '.$wkey.'_id = '.$userId.' order by id DESC'));
    }

    //获取我发出的消息列表
    public function  actionGetMyInfo_OutList(){
        $this->GetMyInfo('out','is_answer<>1');
    }
    //获取我收到的消息列表
    public function  actionGetMyInfo_InList(){
        $this->GetMyInfo('in');
    }

    //设置消息回复    1同意 2拒绝
    public function actionInfoAnswer(){
        $sys_msg='对方已经拒绝了邀请';
        $id=DecodeAsk('id',0);
        $p_id=DecodeAsk('p_id',0);
        $log=InfoLog::model()->find('id = '.$id);
        $tmp=ApplyState::model()->find('id = '.$log->apply_id);
        $old_state=$tmp->state;
        $tmp->state=DecodeAsk('state','0');
        $log->state=DecodeAsk('state','0');
        if($tmp->state==1){ //如果同意，填入到包裹的代领人ID
            $tmp2=Package::model()->find('id='.$p_id);
            $tmp2->dl_id=DecodeAsk('userId');
            $tmp2->dl_name=user::model()->find('userId='.DecodeAsk('userId'))->userName;
            $tmp2->save();
            $sys_msg='对方已经同意了邀请';
        }
        $tmp->answer_time=Date('Y-m-d H:i:s');
        $tmp->save();
        $log->save();
        if($old_state==0)LogInfo($tmp,$tmp->in_id,$tmp->out_id,$sys_msg,'1');

        $out_date=ApplyState::model()->findAll('state=0 and package_id='.$p_id);
        foreach ($out_date as $v){
            $v->state=3;
            $v->answer_time=Date('Y-m-d H:i:s');
            $v->save();
            UpdateLog($v);
        }
        echo json_encode(array('in_state'=>1,'code'=>'200','time'=>time(),'msg'=>'回复成功'));
    }


    //根据包裹ID 获取代领人列表
    public function actionGetDlWait(){
        $id=DecodeAsk('id',0);
//        $tmp=ApplyState::model()->findAll('package_id='.$id.' and type = 0 and state = 1');//申请代领 已通过
//        $s1='out_name:name,type:type';
        $is_new=ApplyState::model()->Count('package_id='.$id.' and type = 0 and state!=3');//申请代领 未过期
        $tmp=Package::model()->findAll('id='.$id);
        $s1='id:id,dl_name:name';
        $this->DataToWx($tmp,$s1,'获取代领人列表成功',array('is_new'=>$is_new>0));

    }



    //根据用户ID 获取当前要帮代领的列表
    public function actionGetMyHelp(){
        $id=DecodeAsk('id',0);
        $Info=ApplyState::model()->findAll('package_id='.$id.' and state = 1');
        $s='in_name';
        $this->DataToWx($Info,$s,'获取同意代领列表成功');
    }

    //邀请用户列表
    public function actionGetHelperList(){
        $limit=DecodeAsk('limit','10');
        $offset=DecodeAsk('offset','0');
        $order_by=DecodeAsk('order','credibility');
        $order_rule=DecodeAsk('order_rule','DESC');
        $key=DecodeAsk('keywords','');
        $id=DecodeAsk('userId',0);
        $op=DecodeAsk('op',0);
        $p_id=DecodeAsk('p_id',0);
        $w='';$arr=array();
        if($op==1){
            $Info_apply=ApplyState::model()->findAll('package_id='.$p_id.' and type = 0 and state!=3');//申请代领 未过期
            if(!empty($Info_apply)){
                foreach ($Info_apply as $v){
                    $arr[]=$v->out_id;
                }
                $s=implode(',',$arr);
                $w=' and userId in(' . $s . ')';
            }
            else  $w=' and  0 ';
        }
        $key=(!$key)?'1':" userName like '%".$key."%' || userId like '%".$key."%' ";
        $tmp =user::model()->findAll($key.$w.' and userId!='.$id.' order by '.$order_by.' '.$order_rule.' limit '.$offset.','.$limit);
        $s='userId,userName:user_name,credibility,times,distance';
        $this->DataToWX($tmp,$s,'获取成功',array('isHideLoadMore'=>count($tmp)==$limit?false:true,'Post'=>$_POST),array());
    }



    //新增邀请
    public function actionAddInvent(){
        $package_id=DecodeAsk('p_id',0);
        $in_id=DecodeAsk('in_id',0);
        $out_id=DecodeAsk('out_id',0);

        $tmp=ApplyState::model()->find('package_id='.$package_id.' and in_id='.$in_id.' and state=0');
        if($tmp){
            $code='500';
            $msg='已经邀请过';
        }
        else{
            $Pac=Package::model()->find('id='.$package_id);
            $Info=new ApplyState();
            $Info->c_id=$out_id;
            $Info->in_id=$in_id;
            $Info->out_id=$out_id;
            $Info->package_id=$package_id;
            $Info->type=1;//1邀请代领
            $Info->out_remark=$Pac->remarks;
            $Info->apply_time=Date('Y-m-d H:i:s');
            $Info->out_name=$Pac->c_name;
            $Info->p_name=$Pac->p_name;
            $Info->in_name=user::model()->find('userId='.$in_id)->userName;
            $Info->save();
            LogInfo($Info);

            $code='200';
            $msg='新增成功';
        }

        echo json_encode(array('code'=>$code,'msg'=>$msg));

    }

    //我的包裹 选定代领人
    public function actionSelectDl(){
        $package_id=DecodeAsk('p_id',0);
        $in_id=DecodeAsk('in_id',0);
        $out_id=DecodeAsk('out_id',0);
        $Pac=Package::model()->find('id='.$package_id);
        $Pac->dl_id=$in_id;
        $Pac->dl_name=user::model()->find('userId='.$in_id)->userName;

        $Pac->save();
        $Info=ApplyState::model()->find('package_id = '.$package_id.' and out_id = '.$in_id.' and state!=3');
        $Info->answer_time=Date('Y-m-d H:i:s');
        $Info->state=1;
        $Info->save();
        UpdateLog($Info);
        LogInfo($Info,$Info->in_id,$Info->out_id,'申请代领成功，请尽快为主人取件','1');


        $Other_Info=ApplyState::model()->findAll('package_id = '.$package_id.' and out_id != '.$in_id);
        if(!empty($Other_Info)){
            foreach ($Other_Info as $v){
                $v->answer_time=Date('Y-m-d H:i:s');
                $v->state=3; //过期
                $v->save();
                UpdateLog($v);
                LogInfo($v,$v->in_id,$v->out_id,'申请代领失败，包裹主人已选定其他人','1');
            }
        }
//
//        $Other_Info=InfoLog::model()->findAll('package_id = '.$package_id.' and out_id != '.$in_id);
//        if(!empty($Other_Info)){
//            foreach ($Other_Info as $v){
//                $v->answer_time=Date('Y-m-d H:i:s');
//                $v->state=3; //过期
//                $v->save();
//            }
//        }



        echo json_encode(array('code'=>'200','msg'=>'选定代领人成功'));
    }

    //个人设置 常用代领开关
    public function actionGlobalSwitchChange_dl(){
        $tmp=user::model()->find('userId='.DecodeAsk('userId'));
        $tmp->always_dl=!$tmp->always_dl;
//        $tmp->always_dl=!DecodeAsk('dlset');

        if($tmp->always_dl==0){ //关闭时 将邀请和申请信息设置为3:过期
            $InfoArr=ApplyState::model()->findAll('c_id='.DecodeAsk('userId'));
            if(!empty($InfoArr)){
                foreach ($InfoArr as $Info){
                    $Info->state=3;  //过期
                    $Info->answer_time=Date('Y-m-d H:i:s');
                    $Info->save();
                    UpdateLog($Info);
//                    LogInfo($Info,$Info->in_id,$Info->out_id,'主人关闭代领，申请已经过期','1');
                }
            }
            $Pac=Package::model()->findAll('c_id='.DecodeAsk('userId'));
            if($Pac){
                foreach($Pac as $v){
                    $v->dl_id='';
                    $v->dl_name='';
                    $v->save();
                }
            }
        }
        $tmp->save();
        Package::model()->updateAll(array('dl_switch'=>$tmp->always_dl),'c_id='.DecodeAsk('userId'));
        echo json_encode(array('msg'=>'更改常用代领开关成功','always_dl'=>$tmp->always_dl));
    }


    //个人设置 常用显示开关
    public function actionGlobalSwitchChange_show(){
        $tmp=user::model()->find('userId='.DecodeAsk('userId'));
        $tmp->always_show=!$tmp->always_show;
        $tmp->always_show=$tmp->always_show?'1':'0';

//        $tmp->always_show=!DecodeAsk('dlset');

        $tmp->save();
        Package::model()->updateAll(array('show_switch'=>$tmp->always_show?'1':'0'),'c_id='.DecodeAsk('userId'));
        echo json_encode(array('msg'=>'更改常用显示开关成功','always_show'=>$tmp->always_show));
    }

    //个人设置 获取设置数据
    public function actionGetMySetting()
    {
        $tmp=user::model()->find('userId='.DecodeAsk('userId'));
        if($tmp)
        echo json_encode(array('always_dl'=>$tmp->always_dl,'always_show'=>$tmp->always_show,'contact_info'=>$tmp->contact_info,
            'send_address'=>$tmp->send_address));
    }

    //个人设置 修改数据
    public function actionChangeSetting()
    {
        $userId=DecodeAsk('userId',0);
        $input=DecodeAsk('input',0);
        $filed=DecodeAsk('filed',0);
        $tmp=user::model()->find('userId='.$userId);
        $tmp->{$filed}=$input;
        $tmp->save();
        echo json_encode(array('msg'=>'修改成功','$Re'=>$_REQUEST));
    }

    //确认收货
    public function actionConfirmRecive(){
        $str_id=DecodeAsk('id_str','');
        $userId=DecodeAsk('userId',0);
        $tmp=Package::model()->findAll('id in(' . $str_id . ')');
        if(!empty($tmp)){
            foreach ($tmp as $v){
                $v->confirm_receipt_state=1;
                $v->confirm_receipt_time=Date('Y-m-d H:i:s');
                $v->save();
            }
        }
        echo json_encode(array('msg'=>'确认收货成功','$Re'=>$_REQUEST));
    }



    //添加评价
    public function actionAddCommand(){
        $Command=new PickCommand();
        $Command->remarks=DecodeAsk('remark');
        $Command->id_str=DecodeAsk('id_str');
        $Command->time=Date('Y-m-d H:i:s');
        $Command->picker_id=DecodeAsk('userId');
        $Command->serve_stars=DecodeAsk('serve_stars');
        $Command->package_stars=DecodeAsk('package_stars');
        $Command->save();
        echo json_encode(array('msg'=>'添加评论成功'));
    }



    //个人设置 应用到全部
    public function actionSetToAll(){
        $userId=DecodeAsk('userId');
        $Pac=Package::model()->findAll('c_id='.$userId.' and pick_state=0');//只修改未取件的包裹
        $user=user::model()->find('userId='.$userId);
        foreach ($Pac as $item) {
            $item->dl_switch=$user->always_dl?'1':'0';
            $item->dl_id=0;
            $item->dl_name='';
            $item->show_switch=$user->always_show?'1':'0';
            $item->dl_address=$user->send_address;
            $item->dl_contact=$user->contact_info;
            $item->save();
            if($item->dl_switch==0){
                $this->ClearInfoWhenCloseDl($userId);
            }
        }

        echo json_encode(array('msg'=>'应用全部成功','$Re'=>$_REQUEST,'$item->show_switch'=>DecodeAsk('always_dl')?1:0,'$item->dl_switch'=> DecodeAsk('always_show')?1:0));
    }

    public function ClearInfoWhenCloseDl($userId){
        $Info=ApplyState::model()->findAll('(type=1 and out_id='.$userId.') or (type=0 and in_id='.$userId.')'); //0 申请 1邀请
        put_msg(CJSON::encode($Info));
        foreach ($Info as $v){
            $v->state=3;  //过期
            $v->answer_time=Date('Y-m-d H:i:s');
            $v->save();
            UpdateLog($v);
//            LogInfo($v,'','','包裹主人关闭代领，申请已经过期','1');
        }
    }


    //确认取件成功 分两种情况
    public function actionConfirmPickUp(){
        $str_id=DecodeAsk('id_str','');
        $userId=DecodeAsk('userId',0);
        $w='id in(' . $str_id . ')';
        $tmp=Package::model()->findAll($w);
        $state='1';$msg='确认取件成功';
        $tmp2=Package::model()->findAll($w.' and pick_state=0');


        if(!empty($tmp2)){
            $state='0';$msg='确认取件失败';
            $tmp=array();
        }

        foreach ($tmp as $v){
            if($v->picker_id!=$userId){
                $state='2';$msg='代领者未确定';
                $tmp=array();
            }

        }

        foreach ($tmp as $v){
            $this->PickLog($v->id,$userId);
            if($v->dl_id == $userId){
                $v->help_state=1;
                $v->help_time=Date('Y-m-d H:i:s');
            }
            elseif($v->c_id == $userId){
                $v->confirm_receipt_state=1;
                $v->confirm_receipt_time=Date('Y-m-d H:i:s');
                $Info=ApplyState::model()->findAll('package_id in(' . $str_id . ') and state !=3 ');
                if(!empty($Info)){
                    foreach ($Info as $item) {
                        $item->state=3; //3：确认收货时, 针对该包裹的邀请/申请代领信息过期
                        $item->answer_time=Date('Y-m-d H:i:s');
                        $item->save();
//                        LogInfo($item,'','','包裹主人已经取货，申请已经过期','1');
                    }
                }
            }
            $v->save();

        }
        echo json_encode(array('state'=>$state,'msg'=>$msg,'$Re'=>$_REQUEST));
    }

    //添加取件日志
    public function PickLog($id,$userId){
        $tmp=Package::model()->findAll('id =' . $id );
        foreach ($tmp as $v){
            $Log=new PickLog();
            $Log->p_id=$v->id;
            $Log->time=Date('Y-m-d H:i:s');
            $Log->picker_id=$userId;
            $Log->save();
        }
    }


    //管理员获取 用户列表
    public function actionGetPackageList_admin()
    {
        $keywords = DecodeAsk('keywords');
        $tmp=User::model()->findAll("PHONE like '%".$keywords."'");
        $s='userId,PHONE,TCNAME';
        $this->DataToWx($tmp,$s,'管理员列表搜索成功');
    }



    //管理员 确认出货
    public function actionAdminConfirmPickUp(){
        $str_id=DecodeAsk('id_str','');
        $userId=DecodeAsk('userId',0);
        $adminId=DecodeAsk('adminId',0);
        $tmp=Package::model()->findAll('id in(' . $str_id . ')');
        if(!empty($tmp)){
            foreach ($tmp as $v){
                $v->admin_id=$adminId;
                $v->pickup_time=Date('Y-m-d H:i:s');
                if($v->pick_state<>1) { //如果未取件，则记录取件人
                    $v->picker_id=$userId;
                    $v->pick_state=1;
                }
                $v->save();
            }
        }
        echo json_encode(array('msg'=>'管理员确认取件成功','$Re'=>$_REQUEST));
    }

    //添加留言
    public function actionAddliuyan()
    {

        $p_id=DecodeAsk('p_id');
        $userId=DecodeAsk('userId');
        $tmp=new LiuYan();
        $tmp->liuyantext=DecodeAsk('liuyantext');
        $tmp->heading=DecodeAsk('headimg');
        $tmp->p_id=$p_id;
        $tmp->time=Date('Y-m-d H:i:s');
        $tmp2=Package::model()->find('id='.$p_id);
        if($userId==$tmp2->c_id){
            $tmp2->dl_weidu= $tmp2->dl_weidu+1;
            $tmp->nickname=$tmp2->c_name;
        }
        else{
            $tmp2->host_weidu= $tmp2->host_weidu+1;
            $tmp->nickname=$tmp2->dl_name;
        }
        $tmp2->latest_liuyan=$tmp->liuyantext;
        $tmp->save();
        $tmp2->save();
        echo CJSON::encode(array('msg'=>'成功','R'=>$_REQUEST));
    }

    //获取留言
    public function actionGetliuyan()
    {
        $id=DecodeAsk('id');
        $userId=DecodeAsk('userId');

        $tmp=LiuYan::model()->findAll('state!=-1 and p_id = '.$id.' order by id DESC');
        $Pac=Package::model()->find('id='.$id);
        if($userId==$Pac->c_id){
            $Pac->host_weidu=0;
        }
        else{
            $Pac->dl_weidu= 0;
        }
        $Pac->save();
        $s='id,nickname,liuyantext,heading,time';
        $this->DataToWx($tmp,$s,'留言读取成功');
    }

    public  function actionAppCheckMyInfo(){
        $userId=DecodeAsk('userId',0);
        $c1=InfoLog::model()->Count('in_id='.$userId.' and in_state=0 and is_answer=1');//回复
        $c2=ApplyState::model()->Count('in_id='.$userId.' and type=1 and state=0');//邀请
        $c3=ApplyState::model()->Count('in_id='.$userId.' and type=0 and state=0');//申请

        echo CJSON::encode(array('count'=>$c1+$c2+$c3,'c1'=>$c1,'c2'=>$c2,'c3'=>$c3,'R'=>$_REQUEST));
    }



}
