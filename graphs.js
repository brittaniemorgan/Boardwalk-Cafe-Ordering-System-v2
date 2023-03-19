import { RequestManager } from "./RequestManager.js";
window.onload=function(){
    var request = new RequestManager();
    var button = document.getElementById("date");
    var title = document.getElementsByTagName("h2")[1];
    var list = ['Today','This Month','This Year'];
    var set = "";
    button.addEventListener("click",function(){
          if (title.innerHTML=="Today's Orders"){
             title.innerHTML = "This Month's Orders";
             set = "Month" }
          else if (title.innerHTML=="This Month's Orders"){
             title.innerHTML = "This Year's Orders";
             set = "Day";}
	       else if (title.innerHTML=="This Year's Orders"){
             title.innerHTML = "Today's Orders";
             set = "Year";} 
          request.sendSignal("http://localhost/comp2171-groupproject/Metrics.php","filter="+set); 

});
}