//公共js函数

$('#button-add').click(function () {
    //点击前往./admin.php?c=menu&a=add
    var url = SCOPE.add_url;
    window.location.href = url;
});



$('#cms-button-submit').click(function () {
   //获取到前台界面的表单数据:

    var dataArray = $("#cms-form").serializeArray();
    var data = {};
    //遍历数组

    $.each(dataArray, function () {
        //this是每一次遍历出来的对象
        data[this.name] = this.value;
    })
    $.post(SCOPE.save_url, data, function (result) {
        if (result.status === 0)
        {
            dialog.error(result.msg);
        }
        if (result.status === 1)
        {
            dialog.success(result.msg,SCOPE.jump_url)
        }
    },'JSON');

});

//删除按钮点击事件
$('.cms-table #cms-delete').click(function () {

    var id = $(this).attr('attr-id');
    //id对应行的status改为-1
    var data = {
        id : id,
    };

    layer.open({
        title : '提示',
        icon : 3,
        btn : ['yes','no'],
        content : '确认删除',
        yes : function () {
            toDelete(data)
        }
    })
})

function toDelete(data)
{
    $.post(SCOPE.delete_url,data,function (result) {
        if (result.status == 1)
        {
            dialog.success(result.msg,SCOPE.jump_url);
        }
        if (result.status == 0)
        {
            dialog.error(result.msg);
        }
    },'JSON')
}

$(".cms-table #cms-edit").click(function () {
    var id = $(this).attr('attr-id');
    //跳转到后端的menu的edit方法:
    location.href = SCOPE.edit_url+'&id='+id;
})

//点击更新排序:
$("#button-listorder").click(function () {
    var dataArray = $("#cms-listorder").serializeArray();
    var data = {};
    $.each(dataArray,function () {
        data[this.name] = this.value;
    });
    $.post(SCOPE.listorder_url,data,function (result) {
        if (result.status == 1)
        {
            dialog.success(result.msg,SCOPE.jump_url)
        }
        if (result.status ==0)
        {
            dialog.error(result.msg);
        };
    },'JSON');
})

/*
$(".form-control").on('change',function () {
    var id = this.value;
    window.location.href = SCOPE.jump_url+'&position_id='+id;
})
*/
$('#cms-push').click(function () {
    var posioion_id = $("#select-push").val();
    var checks = [];
    if (posioion_id == 0)
    {
        return dialog.error('请选择推荐位');
    }
    $.each($('input[name="pushcheck"]:checked'),function (i)
    {
       checks[i] = $(this).val();
    })
    var data = {
        position_id : posioion_id,
        checked: checks
    };
    $.post(SCOPE.push_url,data,function (res) {
        if (res.status == 1)
        {
            dialog.success(res.msg,SCOPE.jump_url);
        }
        if (res.status == 0)
        {
            dialog.error(res.msg);
        }
    },'JSON');
})

$('#sub_data').click(function () {
    var dataArray = $("#f1").serializeArray();
    var data = {};
    var p = 1;
    $.each(dataArray,function () {
        data[this.name] = this.value;
    });


    $.post(SCOPE.search_url, data, function (res) {
        $('#new1').html(res.html);
        next(p,res.num);
    }, 'JSON');
})

function changepage(eve) {

    var p = $(eve).attr("value");

    var dataArray = $("#f1").serializeArray();
    var data = {};
    $.each(dataArray,function () {
        data[this.name] = this.value;
    });

    data['p'] = p;

    $.post(SCOPE.search_url,data,function (res) {
        $('#new1').html(res.html);
        next(res.p, res.num);
    },'JSON');
}

function next(p,num) {
    for (var i = 1; i <= num ; i++)
    {
        if (i == p)
        {
            $('.pagination').append('<span class="current">'+i+'</span>');
        }
        else
        {
            var newa = $('<a class="num" href="javascript:void(0)" value="'+i+'">'+i+'</a>')
            newa.on('click',function () {
                changepage(this);
            })
            $('.pagination').append(newa);
        }
    }
}



