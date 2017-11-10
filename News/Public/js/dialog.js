/**
 * Created by if-information on 2017/8/21.
 */
var dialog = {
    error:function (msg) {
        layer.open({
            icon:2,
            title:'错误提示',
            content:msg
        })
    },
    success:function (msg,url) {
        layer.open({
            icon:1,
            title:'成功提示',
            content:msg,
            yes:function () {
                location.href = url;
            }
        })
    }
};