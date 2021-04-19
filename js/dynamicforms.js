   var videos = 1;
   var images = 1;
function add(element){
     var form = window.document.dynamicForm;
     // We clone the add button
   // var add = element.cloneNode(true);
     // Create a new HTML tag of type "input"
  
      if(images<5 ){
            images++;
           var field = document.createElement("input");
     // The value filled in the form will be stored in an array
     field.name = "img[]";
     field.type = "file";
     field.id =  "image" + images.toString();
  


     var rem = document.createElement("input");
     rem.value = " x ";
     rem.type = "button";
     rem.setAttribute("class", "btn btn-danger");
     rem.setAttribute("width", 35);
     rem.setAttribute("onclick", "EliminarElemento('"+ field.id+"');")



     var row1 = document.createElement("div");
      row1.setAttribute("class", "col");

      var row2 = document.createElement("div");
      row2.setAttribute("class", "col-1");

      var row = document.createElement("div");
      row.setAttribute("class", "row");
      row.id =  field.id;

  
     // Add the onclick event
     rem.onclick = function onclick(event)
      {form.removeChild(field);};
      
     // We create a new element of type "p" and we insert the field inside.
     var bloc = document.createElement("br");
   //  bloc.appendChild(field);
     form.insertBefore(bloc, element);
     form.insertBefore(row, element);
    row.appendChild(row1);
      row1.appendChild(field);
     row.appendChild(row2);
     row2.appendChild(rem);
     form.insertBefore(bloc, element);
  
    alert(images);
      }
    
   }


function AgregarVideo(element){
     var form = window.document.dynamicForm;
     // We clone the add button
   // var add = element.cloneNode(true);
     // Create a new HTML tag of type "input"
  
      if(videos<4 ){

           var field = document.createElement("input");
     // The value filled in the form will be stored in an array
     field.name = "vid[]";
     field.type = "file";
     field.id =  "video" + videos.toString();

     var rem = document.createElement("input");
     rem.value = " x ";
     rem.type = "button";
     rem.setAttribute("class", "btn btn-danger");
     rem.setAttribute("width", 35);
     rem.setAttribute("onclick", "EliminarElemento('"+ field.id+"');")

     // Add the onclick event
     rem.onclick = function onclick(event)
      {form.removeChild(field);};
      
     // We create a new element of type "p" and we insert the field inside.
    var bloc = document.createElement("br");
   //  bloc.appendChild(field);
    // form.insertBefore(add, element);
     form.insertBefore(field, element);
    form.insertBefore(bloc, element);
    videos++;
    alert(videos);
      }
    
   }

 
 function EliminarElemento(elemento){


     var elem = document.getElementById(elemento);
elem.parentNode.removeChild(elem);
 }