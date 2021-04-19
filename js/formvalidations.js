$(function(){
	var mayus = new RegExp("^(?=.*[A-Z])");
	var minus = new RegExp("^(?=.*[a-z])");
	var num = new RegExp("^(?=.*[0-9]])");
	var special = new RegExp("^(?=.*[!@#$&*])");
	var len = new RegExp("^(?=.{8,})");

	$("#passw").on("keyup",function(){
		var pass = $("#passw").val();

		if(mayus.test(pass) && minus.test(pass) && num.test(pass) && len.test(pass)){

		}
		else
		{

		}
	});
});