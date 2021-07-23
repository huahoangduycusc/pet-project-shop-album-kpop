function xemAnh()
{
    const high = document.querySelector(".hightlight");
    const pre = document.querySelectorAll(".product_list_album img");
    pre.forEach(preview => {
        preview.addEventListener('click',function()
        {
            const small = this.src;
            high.src = small;
            pre.forEach(previews => previews.classList.remove("preview"));
            preview.classList.add("preview");
        });
    });

}
xemAnh();