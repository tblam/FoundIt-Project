<!DOCTYPE html>
<html lang="en">
    <head> 
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Contact Form</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

        <!-- CSS for contact page-->
        <link rel="stylesheet" href="css/contact.css">

    </head>

    <body>
		<!-- Top menu -->
		<nav class="navbar navbar-inverse navbar-no-bg" role="navigation">
			<div class="container">
				<div class="navbar-header">
					   <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="home.php"></a>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse" id="top-navbar-1">
					<ul class="nav navbar-nav navbar-right">
						<li>
							<span class="li-text">
								Connect with us through:
							</span>   
							<span class="li-social">
								<a href="https://www.facebook.com"><i class="fa fa-facebook"></i></a> 
								<a href="https://www.twitter.com"><i class="fa fa-twitter"></i></a> 
								<a href="https://plus.google.com/collections/featured"><i class="fa fa-google-plus"></i></a>
							</span>
						</li>
					</ul>
				</div>
			</div>
		</nav>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row"> 
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Contact us</strong></h1>
                            <div class="description">
                            	<p> Please let us know about your questions regarding <a href="index.php"><strong>FoundIt</strong></a>  </p>
                                <p> It is the best way to improve our services</p>
                                <p> Email: foundit@gmail.com  </p> 
                                <p> You can directly email us from the form below.  </p>
                            </div>
                        </div>
                        
                    </div>
                    <div class="row"> 
                        <div class="col-md-12 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Email us at foundit@gmail.com </h3>
                            		<p>Fill in the form below to send us your feedback:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-pencil"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="contact.php" method="post" class="registration-form">
			                    	<div class="form-group" id="groupinfo">
			                    		<label class="sr-only" for="form-first-name">First name</label>
			                        	<input type="text" name="firstname" id="firstname" placeholder="First name..." class="form-first-name form-control"> 
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-last-name">Last name</label>
			                        	<input type="text" name="lastname" id="lastname" placeholder="Last name..." class="form-last-name form-control">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-email">Email</label>
			                        	<input type="email" name="email" id="email" placeholder="Your email..." class="form-email form-control">
			                        </div>
                                    <div class="form-group"> 
                                        <label class="sr-only" for="form-message">Message</label>
                                        <textarea type="text" name="message" id="message" placeholder="Message..." class="form-message form-control"></textarea>
			                        </div>
			                        <button id="MyButton" type="submit" class="btn">Send the message</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/retina-1.1.0.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
		<script>
			function validateEmail($email) {
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				return emailReg.test($email );
			}		
			$(document).ready(function(){
				$('#MyButton').click(function(){
				  //$('<div>Thank you for sending the message. FoundIt will reply your message soon.</div>').insertBefore('#MyButton').fadeOut(10000);
					confirm("Thank you for sending the message. FoundIt will reply your message soon.");
			   });
			 });
			
			
		</script>	
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>