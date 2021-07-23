<?php
class CatchFishController extends BaseController {
//声明一个控制器类，extends 表示继承， BaseController是它的父类

    protected $model = ''; //成员变量，用于存放当前当前控制器对应的模型名字，该变量在init()方法中初始化

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);//__CLASS__是魔术变量，可以返回当前类名，类似的有__FUNCTION__ 、__LINE__
        parent::init();//调用父类的方法
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionDelete($id) {//对应删除按钮的动作函数
        parent::_clear($id);//调用父类方法
    }

    public function actionCreate() {//对应添加按钮的动作函数
        $modelName = $this->model;//this是当前控制器类，它的model成员变量，即line6的变量，值为模型名
        $model = new $modelName('create');//new 实例化， 其中()里的'create'可以省略
        $data = array();//array() 新建一个空数组
        if (!Yii::app()->request->isPostRequest) { //该语句判断是否有一个Post请求，即是否提交数据
            //若没有提交请求，则应该渲染update视图
            $data['model'] = $model;//关联数组，类似字典可以用字符串作为索引下标，'model'是键，$model是值。
            $this->render('update', $data);//yii通过render方法渲染界面update，并传递$data数组的值给界面，在界面中可以直接调用data里的变量
            //比如：写了$data['oneVar']=1; 在update页面中可以直接使用变量 $oneVar ，它的值就是1
            //这是控制器向视图传递参数的方法之一
        } else {
            //若有提交请求，即点击了保存按钮，调用成员函数saveData
            //$_POST是PHP的超级全局变量，表示Post方法提交的数据构成的数组; $_POST[$modelName]表示post上来的关于对应modelName的数据
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {//对应修改按钮的动作函数
        $modelName = $this->model;//同上
        $model = $this->loadModel($id, $modelName);//父类中有一个loadModel方法,等价于$modelName::model()->find('id='.$id);通过id获得数据库记录
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            //和Create同样是渲染update视图，不过此时$model内容是有数据的。而Create中是new出来的模型，是没有数据的。
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }


    function saveData($model, $post) {
        $model->attributes = $post;//模型属性attributes代表全部字段，批量字段赋值
        show_status($model->save(), '保存成功', get_cookie('_currentUrl_'), '保存失败');
        //show_status(保存状态，保存成功显示信息，返回地址，保存失败显示信息)
        //$model->save()即保存，把变量真正写入数据库。如果写入成功，返回1，否则0。
        //get_cookie 是获取cookie缓存，在actionIndex中（即进入列表界面时），有对应的set_cookie
    }

    //列表搜索
    public function actionIndex($keywords = '', $start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();

        //new一个参数对象
        $criteria = new CDbCriteria;
        //condition表示的是查询的条件，即sql语句中where后面的语句
        $criteria -> condition = get_like('1','boat_name',$keywords);
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($end_date!=""),'time<=',$end_date,'"');
    
        //get_like是全局函数，一个变量与多个字段进行关键字模糊匹配
        //第一个参数是旧的condition，当第一次调用get_like时，第一个参数是'1',表示没有条件限制;之后调用则需要写$criteria -> condition
        //第二个参数是要匹配的字段
        //第三个参数是要匹配的关键词
        //即在网页输入了关键词‘大酒店’，放到keywords变量里，
        //分别在'restaurant,res_owner_phone,food_class,food_name,user_name'字段中匹配含有大酒店的记录
        $criteria -> condition = get_like( $criteria -> condition,'boat_name',$keywords);
        $data = array();
        parent::_list($model, $criteria, 'index', $data);//调用父类方法
        
    }




}





