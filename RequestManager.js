export class RequestManager{
    constructor(){}
    
    sendData(url){
        let request = new XMLHttpRequest();
        request.onreadystatechange = function(){
        if (request.readyState === XMLHttpRequest.DONE){
            if (request.status === 200){
                document.querySelector("#item-description").innerHTML = request.responseText;
            }}
        }
        request.open("GET", url);
        request.send(); 
        
    }

    sendSignal(url,parameter){
        let request = new XMLHttpRequest();
        request.open("GET", url+"?"+parameter);
        console.log(url+"?"+parameter);
        console.log(request.readyState);
        request.send();  
    }

    sendUpdate(url,orderId,action){
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
        request.open("GET", url);
        request.send();   
    }
 
    checkout(){
        let url = "http://localhost/comp2171-groupproject/viewCart.php";
        window.location.href=url;
    }
    getFoodDetails(foodID){
        var url = "http://localhost/comp2171-groupproject/Menu.php?foodID=" + foodID;
        this.sendData(url);
    }

    getOrders(){
        let request = new XMLHttpRequest();
        request.onreadystatechange = function(){
        if (request.readyState === XMLHttpRequest.DONE){
            if (request.status === 200){
                document.querySelector("#orders-display").innerHTML = request.responseText;
            }}
        }
        request.open("GET", "http://localhost/comp2171-groupproject/Server.php");
        request.send();  
    }

    getDeliveryAddress(){
        let request = new XMLHttpRequest();
        request.onreadystatechange = function(){
        if (request.readyState === XMLHttpRequest.DONE){
            if (request.status === 200){
                document.querySelector("#deliveryAddress-display").innerHTML = request.responseText;
            }}
        }
        request.open("GET", "http://localhost/comp2171-groupproject/deliveryPersonnel.php");
        request.send();  
    }
    
}