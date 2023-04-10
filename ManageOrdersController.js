window.onload = function(){
     class ManageOrdersController{

       constructor(){}

        updateOrderReady(e){
            var btn = e.target;
            var orderId = btn.getAttribute("id");
            let request = new XMLHttpRequest();
            var url = "http://localhost/comp2171-groupproject/ManageOrdersUI.php?action=updateReady&orderId=" + orderId;
            console.log(orderId);
            request.onreadystatechange = function(){
                if (request.readyState === XMLHttpRequest.DONE){
                    if (request.status === 200){
                        document.querySelector("#orderDiv"+orderId).style.display="none";
                    }
                }    
            }
            request.open("GET", url);
            request.send();
        }

        updateOrderPreparing(e){
            var btn = e.target;
            var orderId = btn.getAttribute("id");
            let request = new XMLHttpRequest();
            var url = "http://localhost/comp2171-groupproject/ManageOrdersUI.php?action=updatePrepare&orderId=" + orderId;
            console.log(orderId);
            request.onreadystatechange = function(){
                if (request.readyState === XMLHttpRequest.DONE){
                    if (request.status === 200){
                        document.querySelector("#order-status-"+orderId).innerHTML = "Status: PREP";
                    }
                }
            }
            request.open("GET", url);
            request.send(); 
         }
        
            

        main(){
            //this.displayOrders()
            var readyButtons = document.getElementsByClassName("mark-ready");
            for (var i = 0; i < readyButtons.length ; i++){
                readyButtons[i].addEventListener("click", this.updateOrderReady);
            }

            var prepareButtons = document.getElementsByClassName("mark-preparing");
            for (var i = 0; i < readyButtons.length ; i++){
                prepareButtons[i].addEventListener("click", this.updateOrderPreparing);
            }   
        }
    }
    
    var manageOrders = new ManageOrdersController();
    manageOrders.main()
  
}