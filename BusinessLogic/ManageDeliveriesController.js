window.onload=function(){
    class ManageDeliveriesController{

        updateDelivery(e){
            var btn = e.target;
            var orderId = btn.getAttribute("id");
            //console.log(orderId);
            let url = "http://localhost/comp2171-groupproject/UI/ManageDeliveriesUI.php?orderID=" + orderId;
            let request = new XMLHttpRequest();
            request.onreadystatechange = function(){
                if (request.readyState === XMLHttpRequest.DONE){
                    if (request.status === 200){
                        document.querySelector("#DeliveryDiv-"+orderId).style.display="none";
                    }
                }
            }
            request.open("GET", url);
            request.send(); 
        }

        main(){
            var deliveryButtons = document.getElementsByClassName("delivered-order");
            for (var i = 0; i < deliveryButtons.length ; i++){
                deliveryButtons[i].addEventListener("click",this.updateDelivery);
            }    
        } 
    }
    var manageDeliveries = new ManageDeliveriesController();
    manageDeliveries.main()
}