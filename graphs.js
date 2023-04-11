
window.onload=function(){
    //var request = new RequestManager();
    var button = document.getElementById("date");
    var title = document.getElementsByTagName("h2")[0];
    var display = document.getElementById("report");
    var list = ['Today','This Month','This Year'];
    var set = "";
    button.addEventListener("click",function(){
          if (title.innerHTML=="Today's Orders"){
            button.innerHTML = "View Yearly Report";
             title.innerHTML = "This Month's Orders";
             set = "m";
           // window.location.href = "http://localhost/comp2171-groupproject/ReportController.php?filter=m";
             }
          else if (title.innerHTML=="This Month's Orders"){
            button.innerHTML = "View Daily Report";
             title.innerHTML = "This Year's Orders";
             set = "y";}
	       else if (title.innerHTML=="This Year's Orders"){
            button.innerHTML = "View Monthly Report";
             title.innerHTML = "Today's Orders";
             set = "d";} 
            let request = new XMLHttpRequest();
            request.onreadystatechange = function(){
               if (request.readyState === XMLHttpRequest.DONE){
                   if (request.status === 200){
                     display.innerHTML = request.response;
                  }
               }}
         request.open("GET", "http://localhost/comp2171-groupproject/ReportController.php?filter="+set);
         request.send();               

});
}