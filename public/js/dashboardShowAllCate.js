let cate = document.getElementById('cate');
let all_cate_div = document.getElementById('all_cate');

cate.addEventListener('mouseenter',function(){
    all_cate_div.style.display="flex";
});
all_cate_div.addEventListener("mouseenter",function(){
    all_cate_div.style.display="flex";
});

cate.addEventListener('mouseleave',function(){
    all_cate_div.style.display="none";
});
all_cate_div.addEventListener("mouseleave",function(){
    all_cate_div.style.display="none";
});
