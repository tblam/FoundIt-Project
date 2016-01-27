<<<<<<< HEAD
$(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	 $("#login").click(function(){	
		  username=$("#name").val();
		  password=$("#word").val();
		  $.ajax({
		   type: "POST",
		   url: "login.php",
			data: "name="+username+"&pwd="+password,
		   success: function(html){    
			if($.trim(html)==='true')    {
			 //$("#add_err").html("right username or password");
			 window.location="../proFound/index.php";
			}
			else    {
			$("#add_err").css('display', 'inline', 'important');
			 $("#add_err").html("<h1 >Wrong username or password</h1>");
			
			}
		   },
		   beforeSend:function()
		   {
			$("#add_err").css('display', 'inline', 'important');
			$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...")
		   }
		  });
		return false;
	});
=======
$(document).ready(function(){
	$("#add_err").css('display', 'none', 'important');
	 $("#login").click(function(){	
		  username=$("#name").val();
		  password=$("#word").val();
		  $.ajax({
		   type: "POST",
		   url: "login.php",
			data: "name="+username+"&pwd="+password,
		   success: function(html){    
			if($.trim(html)==='true')    {
			 //$("#add_err").html("right username or password");
			 window.location="../proFound/index.php";
			}
			else    {
			$("#add_err").css('display', 'inline', 'important');
			 $("#add_err").html("<h1 >Wrong username or password</h1>");
			
			}
		   },
		   beforeSend:function()
		   {
			$("#add_err").css('display', 'inline', 'important');
			$("#add_err").html("<img src='images/ajax-loader.gif' /> Loading...")
		   }
		  });
		return false;
	});
>>>>>>> 553549766b92a9f42daf78521f67381b8a1cc83f
});