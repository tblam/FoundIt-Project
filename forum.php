<?php
include('php/login.php'); 
include('php/signup.php'); 
?>

<!DOCTYPE HTML>
<html> 
    <head> 
        <meta charset="UTF-8">  
        <title>Found It</title>

        <!-- Bootstrap Core CSS -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
              
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
        
        <script>  
        var current_location; 
        var map;
        var markers = []; 
         
        function init() {  
            current_location = {lat: current_lat, lng: current_long}; 
            map = new google.maps.Map(document.getElementById('map'), {
                center: current_location,
                zoom: 12
            });
            
            var house = new google.maps.Marker({
                map: map,
				icon: {
                    url: 'icons/house.png', 
                    scaledSize: new google.maps.Size(40, 40)
                },
                position: current_location,
                animation: google.maps.Animation.DROP, 
            });  
            
            var panorama = new google.maps.StreetViewPanorama(
                document.getElementById('pano'), {
                    position: current_location,
                    pov: {
                        heading: 34,
                        pitch: 10
                    }
                }); 
            
//            var url = "https://maps.googleapis.com/maps/api/streetview?size=400x300&location=" + current_lat + "," + current_long+"&fov=90 &pitch=10&key=AIzaSyD5wg59qptDQmk185hwXK9uRb0PA7ttvBg";
//            console.log(url); 
        }
         
        function getAttractions(){
            //Get user input
            var keyword = $("#place_input").val();
             
            if(keyword == "")
                alert("Please enter your attraction!");
            else{
                
                //Clear old markers
                for(var i = 0 ; i < markers.length; i++)
                    markers[i].setMap(null);
                markers = []; 
                
                //Get locations 
                getNearby(keyword);  
                
                //Zoom map
//                var bounds = new google.maps.LatLngBounds(); 
//                for (var i = 0; i < markers.length; i++) {
//                    bounds.extend(markers[i].getPosition());
//                } 
//                map.fitBounds(bounds);
            }
                
        }
        
        function getNearby(keyword){ 
            var service = new google.maps.places.PlacesService(map);
                service.nearbySearch({
                    location: current_location, 
                    rankBy: google.maps.places.RankBy.DISTANCE,
                    keyword: keyword 
                }, placesCallback);
        }

        function placesCallback(results, status) {
            if (status === google.maps.places.PlacesServiceStatus.OK) {
                for (var i = 0; i < results.length; i++) {
                    createMarker(results[i]);   
                }
            }  
        }

        function createMarker(place) { 
            var placeLoc = place.geometry.location;
            var infowindow = new google.maps.InfoWindow();
            
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });
             
            markers.push(marker);
            google.maps.event.addListener(marker, 'click', function() {
                var name;
                if(place.name == "")
                    name = $("#place_input").val();
                else
                    name = place.name;
                infowindow.setContent(name);
                infowindow.open(map, this);
            }); 
        }
        
        function addFavorite(MLSNumber) { 
            $.get("php/addHouse.php?id_house=" + MLSNumber, function(data, status){ 
                if(data == "")
                   $("#save_button").replaceWith("<h3 class='container'><b>Saved!</b></h3>");
                else
                    alert(data);
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
                                                            <input type="email" name="username" placeholder="Email..." required autocomplete="off"/>
                                                        </div>

                                                        <div class="field-wrap">
                                                            <input type="password" name="password" placeholder="Password..." required autocomplete="off"/>
                                                        </div>

                                                        <p class="forgot"><a href="#">Forgot Password?</a></p> 
                                                        <button name="submit_login" type="submit" class="button button-block">Log In</button>  
                                                        <span><?php echo $error; ?></span>
                                                    </form> 
                                                </div>

                                                <div id="signup">   
                                                    <h1>Sign Up for Free</h1>

                                                    <form method="post"> 
                                                        <div class="top-row">
                                                            <div class="field-wrap">
                                                                <input type="text" name="signup_firstname" placeholder="First name..." required autocomplete="off" />
                                                            </div>

                                                            <div class="field-wrap"> 
                                                                <input type="text" name="signup_lastname" placeholder="Last name..." required autocomplete="off"/>
                                                            </div>
                                                        </div>

                                                        <div class="field-wrap"> 
                                                            <input type="email" name="signup_email" placeholder="Email..." required autocomplete="off"/>
                                                        </div>

                                                        <div class="field-wrap"> 
                                                            <input id="password" type="password" name="signup_password" placeholder="Password..." required autocomplete="off"/>
                                                        </div>

                                                        <div class="field-wrap"> 
                                                            <input id="password1" type="password" placeholder="Re-type password..." required autocomplete="off"/>
                                                        </div> 
                                                        <button id="submit_signup" type="submit" name="submit_signup" class="button button-block">Get Started</button>
                                                    </form>
                                                    
                                                </div>
                                            </div><!--Tab content---->
                                        </div> <!--Modal body---->
                                    </div>
                                </div>
                            </div> <!-- End modal ---->
                            <?php
                            }
                            ?>
                                </li>
                        </ul> 
                    </div> <!-- Collapsed bar --> 
                </div> 
            </nav> 
        </div> 
        
    <div id="top_picture" class="container-fluid"> 
        <div id="pano" style="height:500px; width:100%;"></div>  
    </div>
    
	<div id="housing_info" class="container">
        <?php
			include("php/connectToDatabase.php");
			$houseID = $_GET["house"];
			//echo $houseID;
			
			$sql = "SELECT address, city, BedsTotal, BathsTotal, SqftTotal, LotSizeArea_Min, Age, CurrentPrice, Status, MLSNumber, BathsFull,
					BathsHalf, DOM, long, lat FROM house WHERE MLSNumber = '$houseID'";  
			 
			//Execute the query      
			$stmt = db2_prepare($conn, $sql);
			$result = db2_execute($stmt);

			if ($result == true) {   
				while ($row = db2_fetch_array($stmt)){	
					echo '<div class="lead"><h3><strong><center>'.
					$row[0].', '.$row[1].'<br>For sale: $'.number_format($row[7]).'</strong></center></h3></div>';
					$city = $row[1];
                    echo "<script>var current_long = $row[13]; current_lat = $row[14]</script>";
				}
			}
			else
				echo "Excution error!";
			//db2_close($conn);
		?>
        <hr>
        
		<div class="row">
			<h2 style="padding-left: 1cm"><b>Description</b></h2>
			<?php 
				$result1 = db2_execute($stmt);
				if ($result1 == true) {   
					while ($row = db2_fetch_array($stmt)){	
						echo '<div class="col-md-4"><ul id="list">
								<li>Total Area: '.number_format($row[4]).' square feet</li>
								<li>Lot Size Area: '.number_format($row[5]).' square feet</li>
								<li>Bedroom(s): '.$row[2].'</li>
                                <li>MLSNumber(s): '.$row[9].'</li></ul></div>';
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
    
	<div id="school_attractions" class="container">	
		<div class="row">
			<div class="col-md-6">
				<ul id="list">
					<h2>Schools in <?php
						echo $city; ?></h2>
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
				</ul>
			</div>
			
			<div class="col-md-6">
                <h2><b>Search your own attractions</b></h2>
				<div id="map" style="width: 100%; height: 350px;"> 
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5wg59qptDQmk185hwXK9uRb0PA7ttvBg&libraries=places&callback=init" async defer></script>
                </div>   
                
                <div class="input-group stylish-input-group" style="margin-top:1%;">  
                    <input type="text" id="place_input" class="form-control input-lg"  value="Attractions" >
                    <span class="input-group-addon">
                        <button onclick="getAttractions();">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>  
                    </span> 
                </div> 
			</div>
		</div>
	</div> 
	<?php
        if(isset($_SESSION['username'])){ 
            echo '<center><button id="save_button" type="button" class="btn-lg btn-success navbar-btn" onclick="addFavorite(\''.$houseID.'\')">Add this house to my list</button></center>';
        }
    ?> 
    <hr>
    
    <div class="container">  
        <?php
            if(isset($_SESSION['username'])){
        ?>
        <form method='post' action='php/forumPost.php?house=<?php echo $houseID; ?>'>  
            <div id="comment_area" class="row">
                <div class="col-md-10"> 
                    <textarea placeholder="Comment..." name='comment' id='comment' class ='text'></textarea><br/> 	
                </div>
                <div class="col-md-1" style="text-align:right;">
                    <button type='submit' class="btn-info btn-lg" value='Post'>Post</button>
                </div>
            </div> 
        </form> 
        <?php
                }
        ?>
        <h2 id="display_comment_title" hidden="true">Comments</h2>
        <div id="display_comment" class="row">
            <?php 
                $sql2 = "select contentPost, firstname, timePost from comment, user where id_house = '$houseID' and user.userID = comment.userID order by timepost desc"; 
                $stmt2 = db2_prepare($conn, $sql2);
                $result3 = db2_execute($stmt2);
                if ($result3 == true) { 
                    echo  '<script>$("#display_comment_title").show()</script>';
                    while ($row = db2_fetch_array($stmt2)){
                        echo '<div class="col-md-9"><hr><p id="commentLine" style="padding-left: 1cm; font: 12px;"></p>'.$row[0].'</div>
                               <div class="col-md-3"><hr><p style="text-align:right;">' . $row[1] . '  (' .substr($row[2],0, 16). ')</p></div>';
                    }
                }
                db2_close($conn);
            ?>
        </div>       
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
