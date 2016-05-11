<?php
include('php/login.php'); 
include('php/signup.php'); 
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="FoundIt" content="">

    <title>Found It</title>

    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    
    <!-- Custom CSS -->
    <link href="css/forum.css" rel="stylesheet">
    
    <!-- Custom CSS for sign up / sign in model-->
    <link href="css/signup_login/normalize.css" rel="stylesheet"/>  
    <link href="css/signup_login/style.css" rel="stylesheet"/>   
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	
	 <!-- Custom JS for auto complete--> 
    <script type="text/javascript" src="js/city-autocomplete.js"></script> 
    <link rel="stylesheet" href="css/jquery.autocomplete.css">
    <script src="js/jquery.autocomplete.js"></script>
	
    <!-- Customed CSS for home page -->
    <link rel="stylesheet" href="css/home.css"/>
    <script src="backend.js"></script> 
    <script src="js/infobubble.js"></script> 
	
    <!-- Social icons--> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
    
    <!-- Lightgallery for lightbox gallery -->
    <link type="text/css" rel="stylesheet" href="lib/lightgallery/css/lightgallery.css" /> 

</head>

<body>
	
    <div id="navigation" class="container-fluid"> 
            <nav class="navbar navbar-inverse navbar-no-bg" role="navigation">
                <div  class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
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
                        <ul id="nav_text" class="nav navbar-nav navbar-right">   
                            <li> <a href="contact.php">Contact</a></li>
                            <li>
						<?php
							if(isset($_SESSION['username']))
								echo "<a href='profile.php'>Welcome! "."<strong>".$_SESSION['firstname']." ".$_SESSION['lastname']."</strong></a></li>
								<li><a href='php/logout.php?page=../home.php'>Log out</a></li>"; 
							else{
						?>
							<a href="#myModal" data-toggle="modal" data-target="#myModal">Login / Sign Up</a> 
							
							<div class="modal fade" id="myModal" role="dialog">
								<div class="modal-dialog modal-lg" >
									<!-- Modal content-->
									<div class="modal-content" style="background: rgba(19, 35, 47, 0.9);">  
										<div class="modal-body">
											<ul class="tab-group">
												<li class="tab active"><a href="#login">Log In</a></li>
												<li class="tab"><a href="#signup">Sign Up</a></li>
											</ul>
										   
											<div class="tab-content"> 
												<div id="login">   
													<h1>Welcome Back!</h1>

													<form action="/" method="post">

														<div class="field-wrap"> 
															<input type="email" placeholder="Email..." required autocomplete="off"/>
														</div>

														<div class="field-wrap">
															<input type="password" placeholder="Password..." required autocomplete="off"/>
														</div>

														<p class="forgot"><a href="#">Forgot Password?</a></p> 
														<button type="submit" class="button button-block"/>Log In</button> 
													
													</form> 
												</div>
											
												<div id="signup">   
													<h1>Sign Up for Free</h1>

													<form action="/" method="post">

														<div class="top-row">
															<div class="field-wrap">
																<input type="text" placeholder="First name..." required autocomplete="off" />
															</div>

															<div class="field-wrap"> 
																<input type="text" placeholder="Last name..." required autocomplete="off"/>
															</div>
														</div>

														<div class="field-wrap"> 
															<input type="email" placeholder="Email..." required autocomplete="off"/>
														</div>

														<div class="field-wrap"> 
															<input type="password" placeholder="Password..." required autocomplete="off"/>
														</div>
														
														<div class="field-wrap"> 
															<input type="password" placeholder="Re-type password..." required autocomplete="off"/>
														</div>

														<button type="submit" class="button button-block"/>Get Started</button>
												</div>
											</div><!--Tab content---->
										</div> <!--Modal body---->
									</div>
								</div>
							</div> 
						<?php
							}
						?>
						    </li>
                        </ul> 
                    </div> <!-- Collapsed bar --> 
                </div> 
            </nav> 
        </div>
<!--	<?php
			include("php/connectToDatabase.php");
			//$houseID = $_POST['houseID'];
			//echo $houseID;
			$houseID = 'ML81561225';
			
			$sql = "SELECT address, city, BedsTotal, BathsTotal, SqftTotal, LotSizeArea_Min, Age, CurrentPrice, Status, MLSNumber, BathsFull,
					BathsHalf, DOM FROM house WHERE MLSNumber = '$houseID'";  
			 
			//Execute the query      
			$stmt = db2_prepare($conn, $sql);
			$result = db2_execute($stmt);

			if ($result == true) {   
				while ($row = db2_fetch_array($stmt)){	
					echo '<div class="info"><h1 style="background-color:#c6ecd9; color:  #ff8000"><b>'.
					$row[0].', '.$row[1].'<br>For sale: $'.number_format($row[7]).'</b></center></h1>';
				}
			}
			else
				echo "Excution error!";
			//db2_close($conn);
		?>-->

    <div id="gallery">
        <a href="images/sampleHouse/outside.jpg">
            <img src="images/sampleHouse/outside.jpg" height="15%" width="15%" />
        </a>
        <a href="images/sampleHouse/living.jpg">
            <img src="images/sampleHouse/living.jpg" height="15%" width="15%" />
        </a>

        <a href="images/sampleHouse/livingroom.jpg">
            <img src="images/sampleHouse/livingroom.jpg" height="15%" width="15%" />
        </a>

        <a href="images/sampleHouse/backyard.jpg">
            <img src="images/sampleHouse/backyard.jpg" height="15%" width="15%" />
        </a>

        <a href="images/sampleHouse/television.jpg">
            <img src="images/sampleHouse/television.jpg" height="15%" width="15%" />
        </a>

        <a href="images/sampleHouse/swimmingpool.jpg">
            <img src="images/sampleHouse/swimmingpool.jpg" height="15%" width="15%" />
        </a>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-4" id="addressLine">
                <h3 class="lead" style="margin-bottom:5px;"><strong>2117 Ashley Ridge Ct.</strong></h3>
                <div class="row">
                    <div class="col-sm-12">
                        <hr style="margin-top:5px;">
                        <ul id="addressPriceList">
                            <li><strong>San Jose, CA 95138</strong></li>
                            <li><strong>$1,888,000</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-8" style="margin-top:20px;">
                <div class="col-sm-4">
                    <h4>Schools</h4>
                    <p>Evergreen School District, James Franklin Smith Elementary School, Evergreen Valley College</p>
                </div>
                <div class="col-sm-4">
                    <h4>Attractions</h4>
                    <p>The Ranch Golf Club, Montgomery Hill Park, Evergreen Park</p>
                </div>
                <div class="col-sm-4">
                    <h4>Local Crime</h4>
                    <p>1 Registered Sex Offenders in 1 mile radius</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="houseInfo">
        <div class="row">
            <div class="col-sm-1">5 beds</div>
            <div class="col-sm-1">4 baths</div>
            <div class="col-sm-2">4,079 sq ft</div>
        </div>
    </div>
	<br>
<!--	<?php 
		$result1 = db2_execute($stmt);
		if ($result == true) {   
				while ($row = db2_fetch_array($stmt)){	
					echo '<h2 style="padding-left: 1cm"><b>'.$row[2].' bedrooms, '.$row[3]. ' bathrooms - Total'.
						number_format($row[4]). ' square feet - Age: '. $row[6].' years</b></h2><br>';
					echo '<ul id="list"><b>
							<li>Lot Size Area: '.number_format($row[5]).' square feet</li>
							<li>Bathrooms Full: '.$row[10].'</li>
							<li>Bathrooms Half: '.$row[11].'</li>
							<li>MLSNumber: '.$row[9].'</li>
							<li>Status: '.$row[8].'</li>
							<li>Day on Market (DOM): '.$row[12].'</li><b>
						</ul> ';
				}
			}
			else
				echo "Excution error!";
			db2_close($conn);
			//<h2 style="padding-left: 1cm"><b>5 beds, 4 baths, 4,079 sqft - built in 1998</b></h2><br>
	?>
        
        <p1 style="padding-left: 1cm">This is a prestigious and exclusive Hillstone home. Luxurious master suite. Outdoor oasis includes the large pool, spa and professionally installed Koi pond, gazebo and a 500 sq/ft guest house.</p1> -->
        
        <div id="map">   
            <script src="https://maps.googleapis.com/maps/api/js?v3key=AIzaSyAaUks5Vq08xS53CAuS2LzakJMlDlk2Nb8&sign_in&libraries=places&callback=init" async defer></script> 
        </div> 

		<?php 
			//echo $houseID;
			echo '<center><button id="button1" type="button" class="btn btn-success navbar-btn" onclick="addFavorite(\''.$houseID.'\')">Add to my list</button></center>';
		?>
    <hr>
    <div class="comment">
        <form method='post' style='padding-left: 1cm'>
        
            Comment:<br />
            <textarea name='comment' id='comment' style="width:20cm;"></textarea><br />
            
            <input type='hidden' name='articleid' id='articleid' value='<? echo $_GET["id"]; ?>' />
            
            <input type='submit' value='Post' style="margin-left:19cm"/>
        </form>
    </div>

    <div id="fourth"> 
        <div id="footer">
            <p style="color:yellow;">© Copyright 2015 | All rights reserved to FoundIt</p>
        </div>
        
        <div class="social" id="social-icons"> 
            <ul>
                <li><a href="https://www.facebook.com/"><i class="fa fa-lg fa-facebook"></i></a></li>
                <li><a href="https://twitter.com/?lang=en"><i class="fa fa-lg fa-twitter"></i></a></li>
                <li><a href="https://plus.google.com/"><i class="fa fa-lg fa-google-plus"></i></a></li>
            </ul>
        </div>
    </div>
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to favorite house -->
    <script>
		function addFavorite(MLSNumber) {
			$.post("php/addHouse.php", {id_house: MLSNumber},function(data, status){
				//$('#successSaved').slideDown(2000, function(){ $('h3').fadeOut(2000)})
			});	
			$("#button1").replaceWith("<h3><b>Saved!</b></h3>");
			}
    </script>

    <!-- lightGallery script -->
    <script src="lib/lightgallery/js/lightgallery.min.js"></script>
    <script src="lib/lightgallery/js/lg-thumbnail.min.js"></script>
    <script src="lib/lightgallery/js/lg-fullscreen.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#gallery").lightGallery({
            thumbnail: true
        }); 
    });
    </script>

</body>

</html>
