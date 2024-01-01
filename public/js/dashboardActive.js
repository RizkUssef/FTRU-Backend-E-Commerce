let dash = document.getElementById('dash');
let order = document.getElementById('order');
let product = document.getElementById('product');
let cate = document.getElementById('cate');
let custumer = document.getElementById('custumer');

// dash
dash.addEventListener('click',function (){
    if (!dash.classList.contains("active")) {
        dash.classList.add("active");
        if (order.classList.contains("active")){
            order.classList.remove("active");
        } else if(product.classList.contains("active")){
            product.classList.remove("active");
        } else if(cate.classList.contains("active")){
            cate.classList.remove("active");
        } else if(custumer.classList.contains("active")){
            custumer.classList.remove("active");
        }
    }
});

// order
order.addEventListener('click',function (){
    if (!order.classList.contains("active")) {
        order.classList.add("active");
        if (dash.classList.contains("active")){
            dash.classList.remove("active");
        } else if(product.classList.contains("active")){
            product.classList.remove("active");
        } else if(cate.classList.contains("active")){
            cate.classList.remove("active");
        } else if(custumer.classList.contains("active")){
            custumer.classList.remove("active");
        }
    }
});

// product
product.addEventListener('click',function (){
    if (!product.classList.contains("active")) {
        product.classList.add("active");
        if (order.classList.contains("active")){
            order.classList.remove("active");
        } else if(dash.classList.contains("active")){
            dash.classList.remove("active");
        } else if(cate.classList.contains("active")){
            cate.classList.remove("active");
        } else if(custumer.classList.contains("active")){
            custumer.classList.remove("active");
        }
    }
});

// cate
cate.addEventListener('click',function (){
    if (!cate.classList.contains("active")) {
        cate.classList.add("active");
        if (order.classList.contains("active")){
            order.classList.remove("active");
        } else if(product.classList.contains("active")){
            product.classList.remove("active");
        } else if(dash.classList.contains("active")){
            dash.classList.remove("active");
        } else if(custumer.classList.contains("active")){
            custumer.classList.remove("active");
        }
    }
});

// custumer
custumer.addEventListener('click',function (){
    if (!custumer.classList.contains("active")) {
        custumer.classList.add("active");
        if (order.classList.contains("active")){
            order.classList.remove("active");
        } else if(product.classList.contains("active")){
            product.classList.remove("active");
        } else if(cate.classList.contains("active")){
            cate.classList.remove("active");
        } else if(dash.classList.contains("active")){
            dash.classList.remove("active");
        }
    }
});
