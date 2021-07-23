$('#submit_update').submit(function(){
    loader.classList.add('loader-active');
    $.ajax({
        url : '/shop389/users/setting_ajax.php',
        type : 'post',
        dataType : 'json',
        contentType : false,
        processData : false,
        data : new FormData(this),
        success : function(result){
            loader.classList.remove('loader-active');
            showPopup(result.title,result.msg,true);

        },
        error : function(){
            loader.classList.remove('loader-active');
            showPopup("Lỗi","Đã có lỗi xảy ra, vui lòng liên hệ BQT để biết thêm chi tiết",true);
        }
    });
    return false;
});