<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head> 
    <meta charset="utf-8">  
    <title>Found It</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/home.css"/>
    <script src="backend.js"></script>
     
    <!-- Custom CSS for sign up / sign in model-->
    <link href="css/profile.css" rel="stylesheet"/>
    <link href="css/signup_login/normalize.css" rel="stylesheet"/>  
    <link href="css/signup_login/style.css" rel="stylesheet"/>   
    <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'> 
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    
    <!-- Custom JS for auto complete--> 
    <script type="text/javascript" src="js/city-autocomplete.js"></script> 
    <link rel="stylesheet" href="css/jquery.autocomplete.css">
    <script src="js/jquery.autocomplete.js"></script>    
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
							<li><a href='php/logout.php?page=../home.php'>Log out</a></li>
                        </ul> 
                    </div> <!-- Collapsed bar --> 
                </div> 
            </nav> 
        </div>
    
    <!-- Body section -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3" id="sidebar">  
                <div>
                    <center><img id="profile" src="images/default.png" class="img-circle"  width="304" height="236"></center>
                </div>
               
<!--
                <div>
                    <form method="POST" enctype="multipart/form-data"> 
                        <input style="float:left;" type="file" name="fileToUpload" id="fileToUpload">
                        <input style="float:right;" type="submit" value="Upload" name="submit">
                    </form>
                </div>
-->
                <hr>
                
                <div style="float:left; margin: 0;">
                    <h3>Name: 
                        <?php echo "<strong>".$_SESSION['firstname']." ".$_SESSION['lastname']."</strong>";?>
                    </h3> 
                    <h3>Email: 
                        <?php echo "<strong>".$_SESSION['username']."</strong>"; ?>
                    </h3>  
                </div> 
            </div>
            
            <div class="col-md-9" style="margin-bottom: 15px;"> 
                <div class="container-fluid" id="search-background" style="padding-top: 1cm; width:100%;">
                    <div id="custom-search-input">
                        <div class="input-group col-md-12">
                            <input id="autocomplete" type="text" class="form-control input-lg" placeholder="Where would you like to live?" /> 
                        </div>
                    </div>
                </div> 
                
                <div class="container-fluid" id="mainContent">
                    <div id="topContent">
                        <p>Favorite Houses</p>
                    </div>
                    <div id="bodyContent">
                    <?php
                        include("php/connectToDatabase.php");
                        $userID = (int) $_SESSION['userID'];

                        //setlocale(LC_MONETARY, 'en_US');
                        $sql = "SELECT address, city, BedsTotal, BathsTotal, SqftTotal, LotSizeArea_Min, Age, CurrentPrice, Status, MLSNumber, long, lat FROM favoriteHouse, house WHERE userID = $userID AND id_house = MLSNumber";  

                        //Execute the query      
                        $stmt = db2_prepare($conn, $sql);
                        $result = db2_execute($stmt);

                        if ($result == true) {   
                            while ($row = db2_fetch_array($stmt)){
                                    $id_house = $row[9];
                                    //echo $id_house;
                                    echo '<div id="houseInfo" class="houseInfo">
                                    <a href="forum.php?house='.$id_house.'"><img src="http://maps.googleapis.com/maps/api/streetview?size=640x480&location='.$row[11].','.$row[10].'" alt="sample"> </a><b>'.
                                    'Address: <a href="forum.php?house='.$id_house.'">' . $row[0] . ', '.$row[1]. '</a></b><br>'.
                                    'Bedrooms Total: ' . $row[2] . '<br>'.
                                    'Bathrooms Total: ' . $row[3] . '<br>'.
                                    'Area Total: '  . number_format($row[4]) . ' sqft<br>'.
                                    'Lot Size Area: ' .  number_format($row[5]) . ' sqft<br>'.
                                    'Age: ' . $row[6]. ' year(s)<br>'.
                                    '<b>'.'CurrentPrice: $'. number_format($row[7]). '<br>'.
                                    'Status: ' . $row[8]. '</b><br>
                                    <div class="remove"><button class="btn btn-warning" onclick="removeHouse(\''.$id_house.'\')">Remove</button></div></div>'; 
                            }  
                        }
                        else
                            echo "Excution error!";

                        //Close connection
                        db2_close($conn);
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</body>


<script> 
    $(document).ready(function(){
		// //$("#houseInfo").remove();
        // $(".houseInfo").on("click", function(e){
			// alert("The house is removed from your favorite list");
			// console.log(e);
			// /*$.post("php/removeHouse.php", {id_house: MLSNumber},function(data, status){
				// alert("The house is removed from your favorite list");
		// //alert("Adding a house status: " + status);
				// //console.log(data);*/
			// console.log(status);
			// //});
			
        // });
		
    });
	
	function removeHouse(id_house) {
		$('.houseInfo .remove').each(function () {
			if($(this).html().indexOf(id_house) >= 0) {
				$.post("php/removeHouse.php", {id_house: id_house},function(data, status) {
					if (status = 200 && data == "remove") {
						$('.houseInfo .remove').each(function () {
							if($(this).html().indexOf(id_house) >= 0) {
								$(this).parent().fadeOut(1000, function(){
									$(this).remove();
								});
							}
						});
					}
				});
			}
		});
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
            window.location.href = "home.php";
        }
    }); 
     
    $("form[name='uploader']").submit(function(e) {
        var formData = new FormData($(this)[0]);

        $.ajax({
            url: "page.php",
            type: "POST",
            data: formData,
            async: false,
            success: function (msg) {
                alert(msg)
            },
            cache: false,
            contentType: false,
            processData: false
        });

        e.preventDefault();
    });
</script>

</html>
