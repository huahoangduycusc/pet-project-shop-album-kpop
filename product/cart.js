// minus
const minus = document.querySelectorAll('.minus');
minus.forEach(item => {
    item.addEventListener('click',function(){
        loader.classList.add('loader-active');
        var id = item.getAttribute('data-m');
        $.ajax({
            url : '/shop389/product/cart_ajax.php',
            type : 'get',
            dataType : 'json',
            data : {
                loai : 'tru',
                id : id
            },
            success : function(result){
                loader.classList.remove('loader-active');
                if(result.msg != "")
                {
                    showPopup(result.title,result.msg,true);
                    $('#tongtien').html(result.tong+"đ");
                    $('#thanhtien').html(result.tong+"đ");
                }
                else
                {
                    var qtt = parseInt($('#data-id'+id).html());
                    --qtt;
                    $('#data-id'+id).html(""+qtt+"");
                    $('#tongtien').html(result.tong+"đ");
                    $('#thanhtien').html(result.tong+"đ");
                    var soluong = parseInt($('#cartsl').html());
                    $('#cartsl').html(--soluong);
                }
            },
            error : function(){
                loader.classList.remove('loader-active');
                showPopup("Lỗi","Đã có lỗi xảy ra, vui lòng liên hệ BQT để biết thêm chi tiết",true);
            }
        });
    });
    
});
// plus
const plus = document.querySelectorAll('.plus');
plus.forEach(item => {
    item.addEventListener('click',function(){
        var id = item.getAttribute('data-s');
        loader.classList.add('loader-active');
        $.ajax({
            url : '/shop389/product/cart_ajax.php',
            type : 'get',
            dataType : 'json',
            data : {
                loai : 'cong',
                id : id
            },
            success : function(result){
                loader.classList.remove('loader-active');
                if(result.msg != "")
                {
                    showPopup(result.title,result.msg,true);
                    $('#tongtien').html(result.tong+"đ");
                    $('#thanhtien').html(result.tong+"đ");
                }
                else
                {
                    var qtt = parseInt($('#data-id'+id).html());
                    ++qtt;
                    $('#data-id'+id).html(""+qtt+"");
                    $('#tongtien').html(result.tong+"đ");
                    $('#thanhtien').html(result.tong+"đ");
                    var soluong = parseInt($('#cartsl').html());
                    $('#cartsl').html(++soluong);
                }
            },
            error : function(){
                loader.classList.remove('loader-active');
                showPopup("Lỗi","Đã có lỗi xảy ra, vui lòng liên hệ BQT để biết thêm chi tiết",true);
            }
        });
    });
    
});