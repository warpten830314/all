<?php
/**
 * Created by PhpStorm.
 * User: if-information
 * Date: 2017/8/21
 * Time: 下午7:42
 */
function show($status,$msg,$data = array())
{
    $result = array(
        'status' => $status,
        'msg' => $msg,
        'data' => $data,
    );

    exit(json_encode($result));
}

function getAdminNameToIndex()
{
    $adminName = isset($_SESSION['adminMsg']['username']) ? $_SESSION['adminMsg']['username'] : '';
    return $adminName;
}
function getAdminUrl($row)
{
    $res = '/admin.php?c='.$row['c'].'&a='.$row['f'];
    return $res;
}
function getActive ($conName)
{
//    CONTROLLER_NAME;//获取当前控制器的名字
//    ACTION_NAME;//获取当前方法名
    $c = strtolower(CONTROLLER_NAME); //将字符串转成小写
    if ($c == strtolower($conName))
    {
        return 'class = "active"';
    }
    return 'class = ""';
}
//根据type返回对应的汉字名称
function getMenuType ($type)
{
    return $type == 1 ? '后台模块': '前端模块';
}

function status ($sta)
{
    return $sta == 1 ? '正常':'关闭';
}
function isThumb ($src)
{
    if ($src)
    {
        return "<span style='color: red'>封面图已上传</span>";
    }
    else
    {
        return "<span>此新闻未上传封面图</span>";
    }
}
function getCatName($data,$id)
{
    for ($i=0;$i<count($data);$i++)
    {
        if ($data[$i]['menu_id'] == $id)
        {
            return $data[$i]['name'];
        }
    }
}
function getCopyFromById($id)
{
    return C('COPY_FROM')[$id] ? C('COPY_FROM')[$id]:'站点来源不可知';

}