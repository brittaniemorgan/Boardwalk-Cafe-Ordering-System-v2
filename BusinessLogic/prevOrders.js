window.onload = function(){

    function cancelOrder(e){
        e.preventDefault();
        var orderId = e.target.getAttribute("id");
        let request = new XMLHttpRequest();
        request.onreadystatechange = function(){
            if (request.readyState === XMLHttpRequest.DONE){
                if (request.status === 200){
                    console.log(request.responseText);
                    document.getElementById("order-"+orderId).innerHTML = "Order Cancelled";
                    //window.location = 'prevOrders.php';
                }
            }
        }
        request.open("GET", "http://localhost/comp2171-groupproject/UI/prevOrders.php?orderId=" + orderId);
        request.send();   
    }

    var deliveryButtons = document.getElementsByClassName("cancel-order-btn");
    for (var i = 0; i < deliveryButtons.length ; i++){
        deliveryButtons[i].addEventListener("click", cancelOrder);
    }
}