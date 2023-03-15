
window.onload=function(){
    var button = document.getElementById("date");
    var title = document.getElementByTagName("h2")[0];
    var list = ['Today','This Month','This Year'];
    button.addActionListener("click",function(){
          if (button.innerHTML == 'Today'){
             button.innerHTML = "This Month";
             title.innerHTML = "This Month's Orders";}
          if (button.innerHTML == 'This Month'){
             button.innerHTML = "This Year";
             title.innerHTML = "This Year's Orders";}
	  if (button.innerHTML == 'This Year'){
             button.innerHTML = "Today";
             title.innerHTML = "Today's Orders";} 
});
}