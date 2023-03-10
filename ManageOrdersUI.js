window.onload = function(){
    var orderList;
    saveStatus(url,orderId,action){
            let request = new XMLHttpRequest();
            request.onreadystatechange = function(){
            if (request.readyState === XMLHttpRequest.DONE){
                if (request.status === 200){
                    if (action=="ready"){
                        document.querySelector("#orderDiv"+orderId).style.display="none";
                    }
                    if (action=="prep"){
                        document.querySelector("#order-status-"+orderId).innerHTML = "Status: PREP";
                    }
                }}
            }
        class ManageOrdersUI{
        constructor(){}


        
            request.open("GET", url);
            request.send();   
        }

        /*displayOrders(){
            let request = new XMLHttpRequest();
            request.onreadystatechange = function(){
            if (request.readyState === XMLHttpRequest.DONE){
                if (request.status === 200){
                    document.querySelector("#orders-display").innerHTML = request.responseText;
                }}
            }
            request.open("GET", "http://localhost/updateOrders/ManageOrdersController.php");
            request.send();  
        }*/

        updateOrderReady(e){
            var btn = e.target;
            var orderId = btn.getAttribute("id");
            console.log(orderId);
            saveStatus("http://localhost/comp2171-project/ManageOrdersCOnroller.php?action=updateReady&orderId=" + orderId, orderId,"ready");
            }

        updateOrderPreparing(e){
            var btn = e.target;
            var orderId = btn.getAttribute("id");
            console.log(orderId);
            saveStatus("http://localhost/comp2171-project/ManageOrdersController.php?action=updatePrepare&orderId=" + orderId, orderId,"prep");
            }

        main(){
            //this.displayOrders()
            var readyButtons = document.getElementsByClassName("mark-ready");
            for (var i = 0; i < readyButtons.length ; i++){
                readyButtons[i].addEventListener("click", updateOrderReady);
            }

            var prepareButtons = document.getElementsByClassName("mark-preparing");
            for (var i = 0; i < readyButtons.length ; i++){
                prepareButtons[i].addEventListener("click", updateOrderPreparing);
            }   
        }
    }
    
    var manageOrdersUI = new ManageOrdersUI();
    manageOrdersUI.main()
  
}
