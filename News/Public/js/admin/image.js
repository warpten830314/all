$(function () {
   $('#file_upload').uploadify(
       {
           'swf' : SCOPE.ajax_upload_swf,
           'uploader' : SCOPE.ajax_upload_image_url,
           'buttonText' : "上传图片",
           'fileTypeDesc' : "Image Files",
           'fileObjName' : 'file',
           'fileTypeExts' : '*.gif;*.png;*.jpg',
           'onUploadSuccess' : function (file,data,response) {
               if (response)
               {
                   var obj = JSON.parse(data);
                   $('#'+file.id).find('.data').html('上传完毕');
                   $("#upload_org_code_img").attr("src","."+obj.data)
                   $("#file_upload_image").attr('value', obj.data);
                   $("#upload_org_code_img").show();
               }
               else
               {
                   dialog.error('上传失败');
               }
           }
       })
});