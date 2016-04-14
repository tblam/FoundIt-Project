<?php
include('php/login.php'); 
include('php/signup.php'); 
?>

<!DOCTYPE HTML>
<html>
<head>
	<meta charset="UTF-8">
	<title>FoundIt - Home</title> 
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
     
    <!--    My AutoComplete-->
    <script type="text/javascript" src="js/city-autocomplete.js"></script> 
    <link rel="stylesheet" href="css/jquery.autocomplete.css">
    <script src="js/jquery.autocomplete.js"></script>
    
    <!-- Customed CSS for home page -->
    <link rel="stylesheet" href="css/home.css"/>
    <script src="backend.js"></script> 
    <script src="js/infobubble.js"></script> 
    
    <!-- Custom CSS for sign up / sign in modal-->
    <link href="css/signup_login/normalize.css" rel="stylesheet" type='text/css'/>  
    <link href="css/signup_login/style.css" rel="stylesheet" type='text/css'/>   
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    
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
                        <a class="navbar-brand" href="index.php"></a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="top-navbar-1"> 
                        <ul id="nav_text" class="nav navbar-nav navbar-right">   
                            <li> <a href="contact.php">Contact</a></li>
                            <li>
                            <?php
                            if(isset($_SESSION['username']))
                                echo "<a href='profile.php'>Welcome! "."<strong>".$_SESSION['firstname']." ".$_SESSION['lastname']."</strong></a></li>
                                <li><a href='php/logout.php?page=../home.php'>Log out!</a></li>"; 
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

                                                    <form action="" method="post"> 
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
                                                            <input type="password" name="signup_password" placeholder="Password..." required autocomplete="off"/>
                                                        </div>

                                                        <div class="field-wrap"> 
                                                            <input type="password" placeholder="Re-type password..." required autocomplete="off"/>
                                                        </div>

                                                        <button type="submit" name="submit_signup" class="button button-block">Get Started</button>
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
    
        <div id="map-filter" class="controls"> 
            <label><input id="displayCityBoundary" type="checkbox" checked="true"> City Boundary</label>  
            <label><input id="displayEarthquake-heatmap" type="checkbox" > Earthquake zone</label>
            <label><input id="displayEarthquake" type="checkbox" > Earthquake points</label>
            <label><input id="displaySchool" type="checkbox"> Schools</label> 
            <label><input id="displayFloodZone" type="checkbox"> Floodzone</label> 
        </div> 
        
        <div id="searcharea" class="container">   
            <div class="input-group stylish-input-group" id="searchbox">
                <input id="autocomplete" type="text" class="form-control"  placeholder="Search" > 
            </div>
            <div class="dropdown" id="filter-item" >  
                <a id="price_range" class="btn" type="button" data-toggle="dropdown">Price range <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a> +100K </a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a> +500K </a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a> +800K </a></li>
                </ul>  
            </div>
            <div class="dropdown" id="filter-item" >  
                <a id="num_bed" class="btn" type="button" data-toggle="dropdown">Bed <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a> +1</a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a> +2</a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a> +3</a></li>
                </ul> 
            </div> 

            <div class="dropdown" id="filter-item" >  
                <a id="num_bath" class="btn" type="button" data-toggle="dropdown">Baths <span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a> +0 </a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a> +1 </a></li>
                    <li role="presentation" class="divider"></li>
                    <li><a> +2 </a></li>
                </ul>  
            </div>
            <div id="filter_search">
                <button id="submit_filter" type="button" class="btn btn-link">Filter search</button>
            </div>
        </div>
    
        <div id="map">   
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5wg59qptDQmk185hwXK9uRb0PA7ttvBg&libraries=visualization&callback=init" async defer></script> 
        </div>   
    </body> 

<script>
    $('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');

	  if (e.type === 'keyup') {
			if ($this.val() === '') {
          label.removeClass('active highlight');
        } else {
          label.addClass('active highlight');
        }
    } else if (e.type === 'blur') {
    	if( $this.val() === '' ) {
    		label.removeClass('active highlight'); 
			} else {
		    label.removeClass('highlight');   
			}   
    } else if (e.type === 'focus') {
      
      if( $this.val() === '' ) {
    		label.removeClass('highlight'); 
			} 
      else if( $this.val() !== '' ) {
		    label.addClass('highlight');
			}
    }

});

    $('.tab a').on('click', function (e) {
        e.preventDefault(); 
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active'); 
        target = $(this).attr('href'); 
        $('.tab-content > div').not(target).hide(); 
        $(target).fadeIn(600); 
    });
     
    $(".dropdown-menu li a").click(function(){ 
        $(this).parent().parent().prev().html($(this).text() + ' <span class="caret"></span>'); 
    });
    
    $("#autocomplete").bind("keypress", function(event) {
        if(event.which == 13) {
            localStorage.setItem("storeddata", $('#autocomplete').val()); 
        }
    }); 
    
</script>
</html>