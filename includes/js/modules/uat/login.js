$(document).ready(function(){
	$("#password").keydown(function(a){
		if(a.keyCode==13){
			$("#login-btn").trigger("click")}
		});$("#login-btn").click(function(b){
			b.preventDefault();
			var a=this;$.ajax({
				url:BASE_URL+"uat/client_login",type:"post",dataType:"json",
				data:$("#login-form").serialize(),
				beforeSend:function(){
					$(a).text("Verify credentials...");
					$(a).attr("disabled",true)
				},
				success:function(c){if(c.status==200){
						$("#msg-container").html('<span class="label label-success">Sign In successful...</span>');
						$.ajax({url:BASE_URL+"uat/get_redirect_url",dataType:"html",
				success:function(d){
					window.location=BASE_URL+d}})}else{$("#msg-container").html('<span class="label label-important">Please check your username or password.</span>');
						$(a).text("Sign In");$(a).attr("disabled",false)}}})})});