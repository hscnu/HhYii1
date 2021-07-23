<?php
$config = require(ROOT_PATH . "/include/config.php");
$params = array_merge($config['params'], array('administrator' => array('admin'),));
$st="";
    $params['roleItem'] = array(
        array(
            '评价社区',
            array(
                'remark_index47' => array('菜品分类', 'foodClass/index'),
                'remark_index45' => array('菜品信息', 'foodInfo/index'),
                'remark_index46' => array('菜品评价', 'foodEvaluation/index'),
                'remark_index42' => array('健康登记', 'HealthyRegister/index'),
                'remark_index44' => array('酒楼评价', 'Comment/index'),
                'remark_index41' => array('健康表', 'HealthyList/index'),
                'remark_index49' => array('下单详情', 'orderDetails/index'),
            )  ,
        ),

        array(
            '收藏',
            array(
                'remark_index1' => array('收藏', 'shouCang/index'),
            ),
        ),

    array(
     '样例',
        array(
            'demo_index1' => array('表格样例', 'testList/index'),
            'demo_index2' => array('组件源码', 'testList/demo'),

        ),
    ),
  );



$main = array(
    'basePath' => ROOT_PATH . '/admin',
    'runtimePath' => ROOT_PATH . '/runtime/admin',
    'name' => '',
    'defaultController' => 'index',
    'components' => array(
        'db' => $config['components']['db'],
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info,error, warning'
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace'
                ),
            ),
        ),
    ),
    'params' => $params,
);

return array_merge($config, $main);
?>

<ul class="sidebar-menu">            
<li class="treeview">               
    <a href="#">                    
        <i class="fa fa-gears"></i> <span>權限控制</span>                    
        <i class="fa fa-angle-left pull-right"></i>               
    </a>               
    <ul class="treeview-menu">                   
        <li class="treeview">                        
            <a href="/admin">管理員</a>                        
            <ul class="treeview-menu">                            
                <li><a href="/user"><i class="fa fa-circle-o"></i> 後臺用戶</a></li>                            
                <li class="treeview">                                
                    <a href="/admin/role"> <i class="fa fa-circle-o"></i> 權限 <i class="fa fa-angle-left pull-right"></i>
                    </a>                                
                    <ul class="treeview-menu">                                    
                        <li><a href="/admin/route"><i class="fa fa-circle-o"></i> 路由</a></li>
                        <li><a href="/admin/permission"><i class="fa fa-circle-o"></i> 權限</a></li>
                        <li><a href="/admin/role"><i class="fa fa-circle-o"></i> 角色</a></li>
                        <li><a href="/admin/assignment"><i class="fa fa-circle-o"></i> 分配</a></li>
                        <li><a href="/admin/menu"><i class="fa fa-circle-o"></i> 菜單</a></li>
                    </ul>                           
                </li>                        
            </ul>                    
        </li>                
    </ul>            
    </li>        
</ul>