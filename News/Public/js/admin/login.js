/**
 * Created by if-information on 2017/8/21.
 */
var login = {
    check:function () {
        var username = $('#inputUsername').val();
        var password = $('#inputPassword').val();
        var data = {
            username : username,
            password:password
        };
        var url = './admin.php?a=check';

        $.post(url,data,function (result) {
            if (result.status == 0)
            {
                dialog.error(result.msg);
            }
            if (result.status == 1)
            {
                dialog.success(result.msg,'/admin.php?c=index');
            }
        },'JSON');
    }
};