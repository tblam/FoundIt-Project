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

    <title>Found It</title>

    <!-- Bootstrap Core CSS -->
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
	  .carousel-inner > .item > img,
	  .carousel-inner > .item > a > img {
		  width: 80%;
		  margin: 0 auto;
	  }
	  </style>

    <!-- Custom CSS -->
    <link href="css/forum.css" rel="stylesheet">
    
    <!-- Custom CSS for sign up / sign in model-->
    <link href="css/signup_login/normalize.css" rel="stylesheet"/>  
    <link href="css/signup_login/style.css" rel="stylesheet"/>   
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
	<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	
    <!-- Customed CSS for home page -->
    <link rel="stylesheet" href="css/home.css"/>
    <script src="js/infobubble.js"></script> 
	
    <!-- Social icons--> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
	<!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Script to Activate the Carousel -->
    <script>
		function addFavorite(MLSNumber) {
			$.post("php/addHouse.php", {id_house: MLSNumber},function(data, status){
				//$('#successSaved').slideDown(2000, function(){ $('h3').fadeOut(2000)})
			});	
			$("#button1").replaceWith("<h3><b>Saved Successfully</b></h3>");
			}
		
		var map;
		var infowindow;

		function init() {
		  var pyrmont = {lat: -33.867, lng: 151.195};

		  map = new google.maps.Map(document.getElementById('map'), {
			center: pyrmont,
			zoom: 15
		  });

		  infowindow = new google.maps.InfoWindow();
		  var service = new google.maps.places.PlacesService(map);
		  service.nearbySearch({
			location: pyrmont,
			radius: 500,
			type: ['store']
		  }, callback);
		}

		function callback(results, status) {
		  if (status === google.maps.places.PlacesServiceStatus.OK) {
			for (var i = 0; i < results.length; i++) {
			  createMarker(results[i]);
			}
		  }
		}

		function createMarker(place) {
		  var placeLoc = place.geometry.location;
		  var marker = new google.maps.Marker({
			map: map,
			position: place.geometry.location
		  });

		  google.maps.event.addListener(marker, 'click', function() {
			infowindow.setContent(place.name);
			infowindow.open(map, this);
		  });
		}
			
    </script>
	
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

													<form action="" method="post">

														<div class="field-wrap"> 
															<input type="email" placeholder="Email..." required autocomplete="off"/>
														</div>

														<div class="field-wrap">
															<input type="password" placeholder="Password..." required autocomplete="off"/>
														</div>

														<p class="forgot"><a href="#">Forgot Password?</a></p> 
														<button name="submit_login" type="submit" class="button button-block">Log In</button>  
                                                        <span><?php echo $error; ?></span>
													</form> 
												</div>
											
												<div id="signup">   

													<h1>Sign Up for Free</h1>

													<form action="" method="post">

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

														<button id="submit_signup" type="submit" name="submit_signup" class="button button-block">Get Started</button>
													</div>
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
	<?php
			include("php/connectToDatabase.php");
			$houseID = $_GET["house"];
			//echo $houseID;
			
			$sql = "SELECT address, city, BedsTotal, BathsTotal, SqftTotal, LotSizeArea_Min, Age, CurrentPrice, Status, MLSNumber, BathsFull,
					BathsHalf, DOM FROM house WHERE MLSNumber = '$houseID'";  
			 
			//Execute the query      
			$stmt = db2_prepare($conn, $sql);
			$result = db2_execute($stmt);

			if ($result == true) {   
				while ($row = db2_fetch_array($stmt)){	
					echo '<div class="info"><h1 style="background-color:#c6ecd9; color:  #ff8000"><b>'.
					$row[0].', '.$row[1].'<br>'.$row[9].'<br>For sale: $'.number_format($row[7]).'</b></center></h1>';
					$city = $row[1];
				}
			}
			else
				echo "Excution error!";
			//db2_close($conn);
		?>
        
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
	
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
		<li data-target="#myCarousel" data-slide-to="5"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="images/sampleHouse/outside.jpg" alt="Chania">
        </div>

        <div class="item">
          <img src="images/sampleHouse/living.jpg" alt="Chania">
        </div>

        <div class="item">
          <img src="images/sampleHouse/livingroom.jpg" alt="Flower">
        </div>
		
		 <div class="item">
          <img src="images/sampleHouse/swimmingpool.jpg" alt="Flower">
        </div>
		
        <div class="item">
          <img src="images/sampleHouse/backyard.jpg" alt="Flower">
        </div>
          
        <div class="item">
          <img src="images/sampleHouse/television.jpg">
        </div>
      </div>
        
      <!-- Left and right controls -->
      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>
	<div class="container">
		<div class="row">
			<h2 style="padding-left: 1cm"><b>Description</b></h2>
			<?php 
				$result1 = db2_execute($stmt);
				if ($result1 == true) {   
					while ($row = db2_fetch_array($stmt)){	
						echo '<div class="col-md-4"><ul id="list">
								<li>Total Area: '.number_format($row[4]).' square feet</li>
								<li>Lot Size Area: '.number_format($row[5]).' square feet</li>
								<li>Bedroom(s): '.$row[2].'</li></ul></div>';
						echo '<div class="col-md-4"><ul id="list">							
								<li>Total Bathroom(s): '.$row[3].'</li>	
								<li>Bathroom(s) Full: '.$row[10].'</li>
								<li>Bathroom(s) Half: '.$row[11].'</li></ul></div>';
						echo '<div class="col-md-4"><ul id="list">
								<li>Age: '.$row[10].' year(s)</li>
								<li>Status: '.$row[8].'</li>
								<li>Day(s) on Market (DOM): '.$row[12].'</li></ul></div>';
					}
				}
				else
					echo "Excution error!";
				
			?>
		</div>
	</div>
	
	<hr>
	<div class="container">	
		<div class="row">
			<div class="col-md-6">
				<ul id="list">
					<h2><b>Schools in <?php
						echo $city; ?></b></h2>
					<div class="schools" id="information"> 
						<?php
							$sql1 = "select name, staterank from school where city = '$city' order by staterank"; 
							$stmt1 = db2_prepare($conn, $sql1);
							$result2 = db2_execute($stmt1);
							echo '<table border="1px;" style="width:100%; padding-left: 0px"><tr>
									<th style="text-align: center; color: blue">School name</th>
									<th style="text-align: center; color: blue">State Ranking</th></tr>';
							if ($result2 == true) {   
								while ($row = db2_fetch_array($stmt1)){
									echo  '<tr><td style="padding-left: 1cm">'.$row[0].'</td><td style="text-align: center">'.$row[1].'</td></tr>';
								}
							}
							echo '</table></br>';
						?>
					</div>
					<h2><b>Crime Alerts</b><h2>
					<!--<div class="crime" id="information" style="padding-left: 1cm">1 Registered Sex Offenders in 5 miles radius.</div>-->
				</ul>
			</div>
			
			<div class="col-sm-6">
				<h2><b>Search your own attractions</b><h2>
				<div id="map" style="width: 550px; height: 350px;">   
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5wg59qptDQmk185hwXK9uRb0PA7ttvBg&libraries=visualization&callback=init" async defer></script> 
				</div>
				
				<form role="form">
					<div class="form-group">
						  <h4 for="sel1">Distance in mile(s)</h4>
							  <select class="form-control" id="sel1" style="width: 2cm">
								<option>1</option>
								<option>5</option>
								<option>10</option>
								<option>20</option>
								<option>50</option>
							  </select>
					</div>
					<div class="form-group">
						  <h4 for="inputmd" style="font: 12px;">Attractions</h4>
						  <input class="form-control input-lg" id="keyword" type="keyword" placeholder="Enter point of interest">
					</div>
					<button type="submit" class="btn-info btn">Submit</button>
				</form>
				<br>
			</div>
		</div>
	</div>
	
	<div class="container">
	<?php 
			//echo $houseID;
			echo '<center><button id="button1" type="button" class="btn btn-success navbar-btn" onclick="addFavorite(\''.$houseID.'\')">Add to my list</button></center>';
		?>
	</div>
	<hr>
	
	<div class="container">
		<div class="comment">
			<form method='post' action='php/forumPost.php?house=<?php echo $houseID; ?>' style='padding-left: 1cm'>
			
				Comment:<br/>
				<textarea name='comment' id='comment' class ='text'></textarea><br/> 	
				<div class="text-right"> <!--You can add col-lg-12 if you want -->
					<button type='submit' class="btn-info btn" value='Post'>Post</button>
				</div>
				<!--<center><input type='submit' value='Post'/></center>-->
			</form>
		</div>
		
		<?php 
			$sql2 = "select contentPost, email, timePost from comment, user where id_house = '$houseID' and user.userID = comment.userID order by timePost desc"; 
			$stmt2 = db2_prepare($conn, $sql2);
			$result3 = db2_execute($stmt2);
			if ($result3 == true) {   
				while ($row = db2_fetch_array($stmt2)){
					echo '<hr><h4 id="commentLine" style="padding-left: 1cm; font: 12px;">'.$row[0].'<h5 style="text-align: right;">'.$row[1].'  '.substr($row[2],0, 16).'</h5></h4>';
				}
			}
			db2_close($conn);
		?>
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

</body>

</html>
