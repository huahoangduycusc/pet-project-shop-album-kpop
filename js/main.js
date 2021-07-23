const toBeSelected = (s) => document.querySelector(s);
// tao 1 function de chon bat ky 1 phan tu
toBeSelected('.menu-toggle').addEventListener('click',() =>
{
    toBeSelected('header').classList.toggle('nav-open');
});
// drop down menu
const drop = document.querySelectorAll(".dropdown-toggle");
drop.forEach(dd => {
    dd.addEventListener('click',function(e){
        e.preventDefault();
        const getId = this.getAttribute("me");
        toBeSelected('#'+getId).classList.toggle("show-dropdown");
    })
});
    //const getVl = this.getAttribute("me");
/*toBeSelected('.dropdown-toggle').addEventListener('click',(e) =>{
    e.preventDefault();  
    toBeSelected('#myDropdown').classList.toggle('show-dropdown');
});*/
toBeSelected('.overlay').addEventListener('click',() =>
{
    toBeSelected('header').classList.toggle('nav-open');
});
toBeSelected('.close').addEventListener('click',() =>
{
    toBeSelected('header').classList.toggle('nav-open');
});
// add to cart ajax
var add_cart = document.querySelectorAll(".add-tocart");
var loader = document.querySelector(".loader-body");
add_cart.forEach(item => {
    item.addEventListener('click',function(e){
        loader.classList.add('loader-active');
        e.preventDefault();
        var id = item.getAttribute("data-id");
        item.innerText = "Loading ...";
        $.ajax({
            url : '/shop389/add-to-cart.php',
            type : 'get',
            dataType : 'json',
            data : {
                id : id
            },
            success : function(result){
                loader.classList.remove('loader-active');
                item.innerText = "Thêm vào giỏ";
                $('#cartsl').html(result.soluong);
                showPopup(result.title,result.msg,true);
            },
            error : function(){
                loader.classList.remove('loader-active');
                item.innerText = "Thêm vào giỏ";
                showPopup("Lỗi","Đã có lỗi xảy ra, liên hệ BQT để biết thêm chi tiết ",true);
            }
        });
    });
});
// pop up
function showPopup(title,msg,bool){
    if(bool == true){
        $('#popup-header').html(title);
        $('#popup-content').html(msg);
        document.querySelector('.message-container').classList.toggle('close-pop');
    }
    else{
        document.querySelector('.message-container').classList.toggle('close-pop');
    }
}
// close pop
var closepop = document.querySelector('#close-popup');
closepop.addEventListener('click',function(){
    document.querySelector('.message-container').classList.toggle('close-pop');
});
//modal login
var modal = document.querySelector("#login");
var modal_bg = document.querySelector(".modal-bg");
modal.addEventListener('click',function()
{
    modal_bg.classList.toggle("bg_active");
});
// search
// pop up dăng ky
var dangky = document.querySelector("#dangkys");
var modal_bg1 = document.querySelector(".modal-bg-1");
dangky.addEventListener('click',function(e){
    e.preventDefault();
    // alert("hay");
    modal_bg.classList.remove("bg_active");
    modal_bg1.classList.add('bg_active');
});
// đăng nhập
var dangnhaps = document.querySelector("#dangnhaps");
dangnhaps.addEventListener('click',function(e){
    e.preventDefault();
    // alert("hay");
    modal_bg.classList.add("bg_active");
    modal_bg1.classList.remove('bg_active');
});
// close
var modal_close = document.querySelectorAll(".modal-close");
modal_close.forEach(item => {
    item.addEventListener('click',function(){
        modal_bg.classList.remove('bg_active');
        modal_bg1.classList.remove('bg_active');
    });
});