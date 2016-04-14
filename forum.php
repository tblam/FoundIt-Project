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
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>


    <!-- Custom CSS -->
    <link href="css/forum.css" rel="stylesheet">
    
    <!-- Custom CSS for sign up / sign in model-->
    <link href="css/signup_login/normalize.css" rel="stylesheet"/>  
    <link href="css/signup_login/style.css" rel="stylesheet"/>   
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
    
    <!-- Social icons--> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>

</head>

<body>

    <div id="first">
        <div class="container" id="first-nav">
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
        </div> 
    <div class="info">
        <h1 style="color : orange"><b>2117 Ashley Ridge Ct,
            San Jose, CA 95138<br>For sale: $1,888,000</b></center></h1>
        
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
        <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
      </ol>

      <!-- Wrapper for slides -->
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img src="images/sample.jpg" alt="Chania">
        </div>

        <div class="item">
          <img src="images/living.jpg" alt="Chania">
        </div>

        <div class="item">
          <img src="images/roomE.jpg" alt="Flower">
        </div>

        <div class="item">
          <img src="images/garden.jpg" alt="Flower">
        </div>
          
        <div class="item">
          <img src="images/bath.jpg">
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
        <p1><b>5 beds, 4 baths, 4,079 sqft - built in 1998</b></p1><br>
        <p1>This is a prestigious and exclusive Hillstone home. Luxurious master suite. Outdoor oasis includes the large pool, spa and professionally installed Koi pond, gazebo and a 500 sq/ft guest house.</p1>
        
        <div id="map">   
            <script src="https://maps.googleapis.com/maps/api/js?v3key=AIzaSyAaUks5Vq08xS53CAuS2LzakJMlDlk2Nb8&sign_in&libraries=places&callback=init" async defer></script> 
        </div> 
        
        <script>
        function toggleByClass(className) {
            $("."+className).toggle();
        }
        </script>
        <ul id="list">
            <button class="btn btn-lg btn-block" onclick="toggleByClass('schools');">Schools</button>
            <div class="schools" id="information">Nearby schools: Evergreen School District, James Franklin Smith Elementary School, Evergreen Valley College </div>
            <button class="btn btn-lg btn-block" onclick="toggleByClass('attractions');">Nearby Attractions</button>             <div class="attractions" id="information">The Ranch Golf Club, Montgomery Hill Park, Evergreen Park</div>
            <button class="btn btn-lg btn-block" onclick="toggleByClass('crime');">Crime Alerts</button>
            <div class="crime" id="information">1 Registered Sex Offenders in 1 mile radius.</div>
        </ul>

        <h1>Features</h1>
        <ul id="list">
            <li>Security System</li>
            <li>Fireplace</li>
            <li>Hot Tub / Spa</li>
            <li>Pool and Garden</li>
        </ul>
    <a href="profile.html">
        <center><button type="button" class="btn btn-success navbar-btn">Add to my list</button></center>
    </a>
    <hr>
    <div class="comment">
        <form method='post'>
        
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

    <!-- Script to Activate the Carousel -->
    <!-- <script>
    $('.carousel').carousel({
        interval: 2000 //changes the speed
    })
    </script> -->

</body>

</html>