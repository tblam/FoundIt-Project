<?php
	session_start();
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
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
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

    <!-- Navigation -->
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
    <div id="search-background">
        <div id="custom-search-input">
            <div class="input-group col-md-12">
                <input id="autocomplete" type="text" class="form-control input-lg" placeholder="Where would you like to live?" /> 
            </div>
        </div>
    </div>
    
    <div class="col-xs-12 col-sm-4 col-md-4" id="sidebar">
        <div id="profile">
            <img src="images/profile.jpg">
        </div> 
        <div id="list">
            <p>Name: 
                <?php echo "<strong>".$_SESSION['firstname']." ".$_SESSION['lastname']."</strong>";?>
            </p> 
            <p>Email: 
                <?php echo "<strong>".$_SESSION['username']."</strong>"; ?>
            </p> 
        </div>
    </div>
    <div class="col-xs-12 col-sm-8 col-md-8" id="mainContent">
        <div id="topContent">
            <p>Favorite Houses | Contact List | House Collections </p>
        </div>
        <div id="bodyContent">
		<?php
			include("php/connectToDatabase.php");
			$userID = (int) $_SESSION['userID'];
			//setlocale(LC_MONETARY, 'en_US');
			$sql = "SELECT address, city, BedsTotal, BathsTotal, SqftTotal, LotSizeArea_Min, Age, CurrentPrice, Status FROM favoriteHouse, house WHERE userID = $userID AND id_house = MLSNumber";  
			 
			//Execute the query      
			$stmt = db2_prepare($conn, $sql);
			$result = db2_execute($stmt);

			if ($result == true) {   
				while ($row = db2_fetch_array($stmt)){  
						echo '<div class="houseInfo">
						<a href="forum.php"><img src="images/sample.jpg" alt="sample"> </a><b>'.
						'Address:' . $row[0] . ', '.$row[1]. '</b><br>'.
						'BedsTotal: ' . $row[2] . '<br>'.
						'BathsTotal: ' . $row[3] . '<br>'.
						'SqftTotal: '  . $row[4] . '<br>'.
						'LotSizeArea_Min: ' .  $row[5] . '<br>'.
						'Age: ' . $row[6]. '<br>'.
						'<b>'.'CurrentPrice: $'. number_format($row[7]). '<br>'.
						'Status: ' . $row[8]. '</b><br>
						<div class="remove"><button type="button" class="btn btn-warning">Remove</button></div></div><br>';
					//$json[] = array(
						//'address' => $row[0], 
						//'BedsTotal' => $row[1],
						//'BathsTotal' => $row[2],
						//'SqftTotal' => $row[3],
						//'LotSizeArea_Min' => $row[4],
						//'Age' => $row[5],
						//'CurrentPrice' => $row[6], 
				} 
					//echo json_encode($json); 
			}
			else
				echo "Excution error!";

			//Close connection
			db2_close($conn);
		?>
        </div>
    </div>
     
</body>

<script>       
    $(document).ready(function(){
        $(".remove").on("click", function(){
            $(this).closest("li").remove();
        });
    });
    
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
     
</script>

</html>
