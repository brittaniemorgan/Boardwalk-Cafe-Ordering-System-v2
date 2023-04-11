//import {OrderProcessor} from "./OrderProcessor.js" ;
window.onload = function(){

    function getFoodDetails(foodID){
        console.log("ok");
        var url = "http://localhost/comp2171-groupproject/BusinessLogic/Menu.php?foodID=" + foodID;
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

    function openPopUp(e) {
        var btn = e.target;
        var foodID = btn.getAttribute("itemid");
        getFoodDetails(foodID);
        var overlay = document.querySelector("#overLay");
        overlay.style.display = "block";
    }

    var closebutton = document.getElementById("close-btn");
    closebutton.addEventListener("click",closePopUp);
    function closePopUp(e){
        var overlay = document.querySelector("#overLay");
        overlay.style.display = "none";
    }

    var checkout = document.getElementById("check");

   
    var foodButtons = document.getElementsByClassName("addToOrderButton");
    for (var i = 0; i < foodButtons.length ; i++){
        foodButtons[i].addEventListener("click",openPopUp);
    }
    //document.querySelector("#close-btn").addEventListener("click", closePopUp);
    //reqManager.getOrders();

    var readyButtons = document.getElementsByClassName("mark-ready");
    for (var i = 0; i < readyButtons.length ; i++){
        readyButtons[i].addEventListener("click", updateOrderReady);
    }

    var prepareButtons = document.getElementsByClassName("mark-preparing");
    for (var i = 0; i < readyButtons.length ; i++){
        prepareButtons[i].addEventListener("click", updateOrderPreparing);
    }

    /* Open when someone clicks on the span element */
    function openNav() {
        console.log("okay");
        document.getElementById("myNav").style.width = "100%";
    }
  
  /* Close when someone clicks on the "x" symbol inside the overlay */
    function closeNav() {
        document.getElementById("myNav").style.width = "0%";
    }

    document.getElementById("expandBtn").addEventListener("click", openNav);
    document.getElementById("close-menu-btn").addEventListener("click", closeNav);
    
    
}