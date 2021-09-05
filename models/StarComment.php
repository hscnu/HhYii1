<?php
class StarComment
{

public static function starList($model,$filed='star'){
    $html='<div id="layui-star"></div>';
    $html.='<input type="hidden" id="layui-star-input" name="'.get_class($model).'['.$filed.']'.'">';
    return $html;

}
}