<?php

/**
 * @param:modelName the MVC that you wanna create
 * @param:tableName the table of the Model
 * */
$modelName='New';
$tableName='new_list';

/**
 * Using the template
 */
$template="Modules";
createModules($modelName,$template,array('modules'=>$tableName));
function createModules($modelName,$template,$otherMap){
    openAndReplace('admin/controllers/',$template,$modelName,'Controller.php');
    openAndReplace('models/',$template,$modelName,'.php',$otherMap);
    copydir('admin/views/'.lcfirst($template),'admin/views/'.lcfirst($modelName));
    echo 'successfully create MVC';
}


/**
 * 复制控制器和模型文件
 */
function openAndReplace($dir,$template,$modelName,$hz,$otherMap=array()){
    $c1=1;$c2=1;
    $dest=$dir.$modelName.$hz;
    copy($dir.$template.$hz,$dest);
    $file = file_get_contents($dest);
    $file = str_replace($template,$modelName,$file,$c1);
    if(!empty($otherMap)){
        foreach ($otherMap as $k=>$v) {
            $file = str_replace($k,$v,$file,$c2);
        }
    }
    file_put_contents($dest,$file);
}


/**
 * 复制文件夹
 */
function copydir($source, $dest)
{
    if (!file_exists($dest)) mkdir($dest);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) copydir($_source, $_dest);
    }
    closedir($handle);
}