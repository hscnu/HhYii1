<?php

class TestListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }


    public function actionDelete($id) {
        parent::_clear($id);
    }

    public function actionTest(){
        echo CJSON::encode($_REQUEST['name']);
    }

    public function actionAutoSql(){
        $sub="INSERT INTO `package_msg` VALUES ('id','p_id', 'c_id','p_name', 'c_name', 'c_number','sex','', '','dl', '', 'add', '', '', 
'', '', 'register', null, null, null, 'help', 'con', 'pick');
";
//         $xing = array('黄','李','王','陈','杨','高','郭','周','林','曹','张','朱','赵','仇','方','房','范','关',
//             '何','谭','胡','吴','韩','赖','梁','邓','林','凌','许','刘','罗','卢','彭','唐','冯','褚','卫','蒋','沈'
//             ,'杨', '朱','秦','尤','吕','施', '孔','严','金','魏','陶','姜', '戚','谢','邹','喻','柏','水','窦','章'
//            ,'云','苏','潘','葛','奚','郎', '鲁','韦','昌','马','苗','花',
//);
//         $name = array('建国','富国','富强','俊杰','兴旺','海源','俊才','胜利','子轩','子然','梓贤','璇儿','建安','敬业',
//             '大伟','爱国','爱丽','田园','江河','书林','天韵','琳','云','嘉豪','佳豪','浩瀚','浩','翊','仪','佳仪','筠星',
//         '茵茵','欧欧','狗儿','飒爽','少记','慧能','悟空','京','一晋','一然','欣然','梓然','萌','帅','酷','化新','文武','晓',
//             '晓欣','晓丽','晓琪','晓娜','晓君','晓亮','晓励','晓砾','晓布','金金','晶晶','杰','儒','武宗');
//         $phone = '13';

         $diqu= array('广州','香港','北京','浙江','河北','湖北','湖南','河南','青岛','海南','武汉','西藏','新疆','阳江',
             '安徽','石家庄','东莞','江门','潮汕');
         $good=array('苹果','梨子','草莓','西瓜','香蕉','橙子','橘子','鲜虾','鲍鱼','鲈鱼','粉丝','面条','白菜','娃娃菜','方便面',
             '鱼翅','燕窝','咖啡','水牛奶','仙草','哈密瓜','葡萄','车厘子','猪肉干','牛肉干','鹅肝','芒果','芒果干','草莓干','土豆',
             '竹笋','海带丝','鸡扒','猪扒','牛扒','火锅底料','土鸡蛋' ,'火腿','猪脚','猪舌','鸡肝','鸭肾','猪脑','南瓜','冬瓜',
             '烤冷面','螺蛳粉','炸油条','番茄酱');
         $des=array('限时打折','特价包邮','买一送二','送农家土鸡蛋','爱心扶农','直播限定','正品保障','假一赔十','农户手作',
             '产业园冷链物流直送','绿色安全权威认证','加购物车加收藏送同款','附送海量赠品','李佳奇强烈推荐','李先特别安利','爆款网红'
         ,'小红伞同款','抖因爆款');
//         $add=array('东','西','南');
//        $add_num=array('一','二','三','四','五','六','七','八','九','十');

        $spe=array('!','@','#','$','**',"||",'!!!','###','&&');

        $user_msg=user::model()->findAll();

        $j=212;
        foreach ($user_msg as $u){

        $rand=rand(1,10);
        if($j==213) $rand = 50;
        for($i=1;$i<$rand;$i++) {
            $rand_diqu = $diqu[rand(0,count($diqu)-1)];
            $rand_good="【".$rand_diqu.$good[rand(0,count($good)-1)]."】".
                $des[rand(0,count($des)-1)].$spe[rand(0,count($spe)-1)].$des[rand(0,count($des)-1)].
                $spe[rand(0,count($spe)-1)].$des[rand(0,count($des)-1)];


            $res = str_replace("p_id",rand(100000000000,999999999999),$sub);
            $res = str_replace("c_id",$u->user_id,$res);
            $res = str_replace("id",$j++,$res);
            $res = str_replace("p_name",$rand_good,$res);
            $res = str_replace("c_name",$u->TCNAME,$res);
            $res = str_replace("c_number",$u->PHONE,$res);

            $dl=rand(0,1);$pick=rand(0,1);$con=rand(0,1);$help=rand(0,1);
            $res = str_replace("dl",$dl,$res);
            $res = str_replace("pick",$pick,$res);
            $res = str_replace("con",$pick?$con:0,$res); //取件了才有确认随机值，未取件不确认
            $res = str_replace("help",$dl?$pick?$help:0:0,$res);
            $res = str_replace("add",$dl?$u->address:null,$res);
            $res = str_replace("register",randomDate('2021-2-7 00:00:00','2021-2-28 00:00:00'),$res);
            $res = str_replace("sex",$u->sex,$res);



            $phone='13';
            echo ($res.'<br>');

        }
        }
    }

    public function actionAutoSqlUser(){
        $sub="INSERT INTO `user` VALUES ('id', 'TUNAME', 'TPWD', '', 'TCNAME', '', '', '', '用户', null, 'user_id', 'user_name', 'sex', '', 'add', null, null, null, null, '', '', '','PHONE');
";
        $xing = array('黄','李','王','陈','杨','高','郭','周','林','曹','张','朱','赵','仇','方','房','范','关',
            '何','谭','胡','吴','韩','赖','梁','邓','林','凌','许','刘','罗','卢','彭','唐','冯','褚','卫','蒋','沈'
        ,'杨', '朱','秦','尤','吕','施', '孔','严','金','魏','陶','姜', '戚','谢','邹','喻','柏','水','窦','章'
        ,'云','苏','潘','葛','奚','郎', '鲁','韦','昌','马','苗','花',
        );
        $name = array('建国','富国','富强','俊杰','兴旺','海源','俊才','胜利','子轩','子然','梓贤','璇儿','建安','敬业',
            '大伟','爱国','爱丽','田园','江河','书林','天韵','琳','云','嘉豪','佳豪','浩瀚','浩','翊','仪','佳仪','筠星',
            '茵茵','欧欧','狗儿','飒爽','少记','慧能','悟空','京','一晋','一然','欣然','梓然','萌','帅','酷','化新','文武','晓',
            '晓欣','晓丽','晓琪','晓娜','晓君','晓亮','晓励','晓砾','晓布','金金','晶晶','杰','儒','武宗');

        $phone = '13';
        $sex=array('男','女');


        $add=array('东','西','南');
        $add_num=array('一','二','三','四','五','六','七','八','九','十','十一','十二','十三','十四');

        for($i=1;$i<100;$i++) {
            for ($j = 0; $j < 9; $j++){
                $phone .= rand(0, 9);
            }

            $rand_name = $xing[rand(0,count($xing)-1)].$name[rand(0,count($name)-1)];
            $rand_sex=$sex[rand(0,1)];
            $rand_add=$add[rand(0,count($add)-1)].$add_num[rand(0,count($add_num)-1)];
            $res = str_replace("TCNAME",$rand_name,$sub);
            $res = str_replace("user_name",$rand_name,$res);
            $res = str_replace("sex",$rand_sex,$res);
            $res = str_replace("TPWD",$i,$res);
            $res = str_replace("TUNAME",$i,$res);
            $res = str_replace("user_id",$i,$res);
            $res = str_replace("sex",$rand_sex,$res);
            $res = str_replace("id",$i,$res);
            $res = str_replace("add",$rand_add,$res);
            $res = str_replace("PHONE",$phone,$res);


            $phone='13';
            echo ($res.'<br>');

        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        if(!empty( $model->check_button))
            $model->check_button =  explode(',',  $model->check_button );
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;

        if(!empty( $model->check_button)||is_array($model->check_button))
            $model->check_button = implode(',',$post['check_button']);


        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
    }

    //列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','club_code,club_address,club_name,contact_phone,apply_name',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'club_code,club_address,club_name,contact_phone,apply_name',$keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }


    public function actionDemo($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria -> condition = get_like('1','club_code,club_address,club_name,contact_phone,apply_name',$keywords);
        $criteria -> condition = get_like( $criteria -> condition,'club_code,club_address,club_name,contact_phone,apply_name',$keywords);
        $data = array();
        parent::_list($model, $criteria, 'demo', $data);
    }
}
