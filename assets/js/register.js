$(document).ready(function(){

	//OnClick Signup, hide Login Section and show Register Section
	$("#signup").click(function(){
		$("#login_section").slideUp("slow", function(){
			$("#register_section").slideDown("slow");
		});
	});


	//OnClick Signup, hide Login Section and show Register Section
	$("#signin").click(function(){
		$("#register_section").slideUp("slow", function(){
			$("#login_section").slideDown("slow");
		});
	});

});