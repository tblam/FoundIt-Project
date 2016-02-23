<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 

    <title>FoundIt</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom CSS --> 
	<link href="css/index.css" rel="stylesheet"/> 
     
    <!-- Custom CSS for sign up / sign in modal-->
    <link href="css/signup_login/normalize.css" rel="stylesheet"/>  
    <link href="css/signup_login/style.css" rel="stylesheet"/>   
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
    
    <!-- Custom JS for auto complete--> 
    <script type="text/javascript" src="js/city-autocomplete.js"></script> 
    <link rel="stylesheet" href="css/jquery.autocomplete.css">
    <script src="js/jquery.autocomplete.js"></script>
      
    <!-- Social icons--> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet"/>
    
</head>
	
<body> 
    <div id="first">
        <div class="container" id="first-nav">
            <a href="profile.php"><?php
					echo "Welcome!  "."<strong>".$_SESSION['firstn']."</strong>";
			?></a>
        </div> 
      
        <div id="first-content">   
            <div> 
                <img class="logo img-responsive" src="images/logo.png">
                <h1>The simplest way to find your dream home.</h1>    
            </div>
            <div id="custom-search-input">
                <div class="input-group col-md-12">
                    <input id="autocomplete" type="text" class="form-control input-lg" placeholder="Where would you like to live?" />
                    <span class="input-group-btn">
                        <a href="home.html" class="btn btn-info btn-lg" type="button">
                            <i id="search-icon" class="glyphicon glyphicon-search"></i>
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container" id="second">        
        <h1>Select the largest selection of rentals nationwide, updated in real time.</h1>  
        
        <div id="custom-image">
            <a onclick="storedata('San Jose')" class="img-wrap"><img class="img-responsive" src="images/cities/san-jose.jpg" alt="img01"/>
                <div id="description-text"> San Jose </div>
            </a>   
        </div>
        <div id="custom-image">
            <a onclick="storedata('San Francisco')" class="img-wrap"><img class="img-responsive" src="images/cities/san-francisco.jpg" alt="img03"/>
                <div id="description-text"> San Francisco </div>
            </a>   
        </div> 
        <div id="custom-image">
            <a onclick="storedata('Los Angeles')" class="img-wrap"><img class="img-responsive" src="images/cities/los-angeles.jpg" alt="img06"/>
                <div id="description-text"> Los Angeles </div>
            </a>   
        </div> 
        <div id="custom-image">
            <a onclick="storedata('San Diego')" class="img-wrap"><img class="img-responsive" src="images/cities/san-diego.jpg" alt="img06"/>
                <div id="description-text"> San Diego </div>
            </a>   
        </div> 
        <div id="custom-image">
            <a onclick="storedata('Sacramento')" class="img-wrap"><img class="img-responsive" src="images/cities/sacramento.jpg" alt="img01"/>
                <div id="description-text"> Sacramento </div>
            </a>   
        </div>
        <div id="custom-image">
            <a onclick="storedata('Irvine')" class="img-wrap"><img class="img-responsive" src="images/cities/irvine.jpg" alt="img01"/>
                <div id="description-text"> Irvine </div>
            </a>   
        </div>
        <div id="custom-image">
            <a onclick="storedata('Palo Alto')" class="img-wrap"><img class="img-responsive" src="images/cities/palo-alt.jpg" alt="img01"/>
                <div id="description-text"> Palo Alto </div>
            </a>   
        </div>
        <div id="custom-image">
            <a onclick="storedata('Berkeley')" class="img-wrap"><img class="img-responsive" src="images/cities/berkeley.jpg" alt="img01"/>
                <div id="description-text"> Berkeley </div>
            </a>   
        </div>
    </div>
    
    <div id="third">
        <div class="container"> 
            <h1><span style="color:black;">About</span> Found<span style="color:orange;">It</span></h1>
            <p>
                FoundIt is one of the leading real estate and rental marketplace dedicated to empowering consumers with data, inspiration and knowledge around the place they call home, and connecting them with the best local professionals who can help.
            </p> 
            <p>
                FoundIt designs and creates a user-friendly website that gives users accurate housing information to make their house-hunting experience as smooth as possible, and also implements features that are less inherent to buyers, but are important factors in making final decisions. The website will be able to list the sources from which it obtained the information, the attractions around a particular house, and a verified forum for each property where other shoppers can give their own comments. The desired outcome of FoundIt is to enhance a buyer's research process so that they can make educated choices when purchasing a home.
            </p> 
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

<script>     
    function storedata(city){
        localStorage.setItem("storeddata", city);
        window.location.href = "home.html";
    } 
    
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
    
    $('#search-icon').on('click', function (e){
        localStorage.setItem("storeddata", $('#autocomplete').val());
    })
    
    $("#autocomplete").bind("keypress", function(event) {
        if(event.which == 13) {
            localStorage.setItem("storeddata", $('#autocomplete').val());
            window.location.href = "home.html";
        }
    }); 
</script>

</html>
