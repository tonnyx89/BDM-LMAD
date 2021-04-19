/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function muestra_oculta(id, ver){
if (document.getElementById){ //se obtiene el id
var el = document.getElementById(id); //se define la variable "el" igual a nuestro div
el.style.display = (el.style.display == 'none') ? 'block' : 'none'; //damos un atributo display:none que oculta el div
}
}




function viewOtherImg(idA, idB) {
    document.getElementById(idA).src = document.getElementById(idB).src;
}



		function generarBusqueda(){
			var send = false;
			
			var strUser = document.getElementById("filtros-select").value;
			aler(strUser);
			}