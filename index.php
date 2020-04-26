<html>
<head>
<!-- meta -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- jquery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.slim.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Local CSS -->
<link rel="stylesheet" type="text/css" href="/public/styles/style.css">
</head>
<body>
<?

/**
*	Require debug
*/
require 'application/lib/Dev.php';

/**
*	Autoloadutoload classes
*/
use application\core\Usd;
use application\core\Eur;
spl_autoload_register(function($class) {
    $path = str_replace('\\', '/', $class.'.php');
	if (file_exists($path)){
		require $path;
	}
});

/**
* Set default vars
*/
$usd_code = "R01235"; // USD code for api
$eur_code = "R01239"; // EUR code for api
$max_date = date("Y-m-d"); // max date in input for query, set equal to today

/**
*	Check isset date_to_query variable by user
*/
if(isset($_GET['date_to_query'])){
	$date_to_query = $_GET['date_to_query']; // YES -> TAKE A GET VARIABLE
	$date_to_query = str_replace('-', '/', $date_to_query); // replace '-' to '/'
	$array = explode("/", $date_to_query); // make a array
	$date_to_query = "$array[2]/$array[1]/$array[0]"; // swap the Y-m-d to d-m-Y
}
else{
	$date_to_query = date("d/m/Y", mktime(0, 0, 0, date("m"), date("d")-1, date("Y"))); // NOPE -> TAKE A CURRENT DATE
}

?>
<!-- navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-transparent float-right">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form class="form-inline my-2 my-lg-0" action="index.php">
      <input type="date" name="date_to_query" class="form-control" id="date_to_query" max="<?=$max_date?>">
      <button class="btn btn-outline-light mx-2 my-2 my-sm-0" type="submit">magic</button>
    </form>
  </div>
</nav>
<!-- container -->
<div class="container">
	<div class="row align-items-center" style="height: 80%; color: white;">
		<!-- usd div -->
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			
			<div class="box-part text-center">
				
				<i class="fa fa-usd fa-3x" aria-hidden="true"></i>
				
				<div class="title mt-3">
					<h4>USD</h4>
				</div>
				
				<div class="text">
					<span>
					<?
							$Usd = new Usd;
							$Usd->get_value($usd_code, $date_to_query);
					?>
					</span>
				</div>				
			 </div>
		</div>
		<!-- eur div -->
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	   
			<div class="box-part text-center">
				
				<i class="fa fa-eur fa-3x" aria-hidden="true"></i>
			
				<div class="title mt-3">
					<h4>EUR</h4>
				</div>
				
				<div class="text">
					<span>
					<?
							$Eur = new Eur;
							$Eur->get_value($eur_code, $date_to_query);
					?>
					</span>
				</div>
			 </div>
		</div>	
	</div>
</div>


</body>
</html>
