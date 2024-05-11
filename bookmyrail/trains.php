
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>trains running today</title>
  <link rel="icon" href="Assets/3843.svg" type="image/gif" sizes="16x16">
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="simple-sidebar.css" rel="stylesheet">
</head>

<body>

  <div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <div class="bg-light border-right" id="sidebar-wrapper">
    <div class="sidebar-heading">
                <tr>
                    <td><img src="Assets/3843.png" sizes="16x16"></td>
                    <td><b>bookmyrail</b></td>
                </tr>
            </div>
      <div class="list-group list-group-flush">
        <a href="index.html" class="list-group-item list-group-item-action bg-light">Home</a>
        <a href="trains.php" class="list-group-item list-group-item-action bg-light">Trains Running Today</a>
        <a href="existing_admin.php" class="list-group-item list-group-item-action bg-light">Admins</a>
        <a href="existing_user.php" class="list-group-item list-group-item-action bg-light">Users</a>
        <a href="search.php" class="list-group-item list-group-item-action bg-light">Search</a>
      </div>
    </div>
    <!-- /#sidebar-wrapper -->
    <!-- Page Content -->
    <div id="page-content-wrapper">

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom justify-content-between">
        <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
          
        </button>
        <form   action='tickets.php'  method="POST" class="form-inline my-2 my-lg-0 ">
      <input class="form-control mr-sm-2"name="ticket_number" type="search" placeholder="Ticket Number" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" ><a href= >Search</a></button>
    </form>
      </nav>

      <div class="container-fluid">
          <h1 style="font-family: cursive;">Trains Running Today</h1>
          <table class="table table-dark table-striped">
          <tr>
        <th>Train ID</th>
        <th>Train Number</th>
        <th>Source</th>
        <th>Destination</th>
        <th>Ac Seats booked</th>
        <th>Sleepers Seats booked</th>
    </tr>
      <?php
      session_start();
    error_reporting(E_ALL ^ E_WARNING); 
    
    require "connectdb.php";
    $q1 = "Select * from rail_data_schema.trains as T where T.running = 't' and T.released_for <= CURRENT_DATE and T.released_till >= CURRENT_DATE;";
    $trains_today = pg_query($q1);
    while($train=pg_fetch_row($trains_today)){
        $date_id_query = "select date_dim_id from rail_data_schema.calender where date_actual = CURRENT_DATE";
        $date_id = pg_fetch_row(pg_query($date_id_query));
        $fetch_query = "Select * from rail_data_schema.bookings as B where B.train_id = '$train[0]' and B.train_number = '$train[1]' and B.date_dim_id = '$date_id[0]'";
        $r = pg_query($fetch_query);
        $t = pg_fetch_row($r);
        if($t){
        echo "<tr>
                <th>$train[0]</th>
                <th>$train[1]</th>
                <th>$train[2]</th>
                <th>$train[3]</th>
                <th>$t[3]</th>
                <th>$t[4]</th>
            </tr>";
        }
        else{
            echo "<tr>
            <th>$train[0]</th>
                <th>$train[1]</th>
                <th>$train[2]</th>
                <th>$train[3]</th>
                <th>0</th>
                <th>0</th>
            </tr>";
        }
        }
?>
      </div>
    </div>
    <!-- /#page-content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>

</body>

</html>
