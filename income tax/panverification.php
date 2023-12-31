<?php
session_start();

//error_reporting(0);
include 'partials/_dbconnect.php';

?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>TAX</title>
</head>

<body>
    <?php require 'partials/_nav.php' ?>
    <?php require 'partials/_template.php' ?>
    <div class="container">
        <ul class="nav nav nav-pills nav-fill">
            <li class="nav-item">
                <a class="nav-link" href="paytax.php">Pay Tax</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="panverification.php">Verify PAN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaction.php">Transcation</a>
            </li>
           
        </ul>
    </div>





    <div class="container my-4">

        <form action="/income tax/panverification.php" method="post">
            <div class="mb-3">
                <label for="pan" class="form-label">PAN Number </label>
                <input type="text" class="form-control" name="pan" aria-describedby="emailHelp" required>
                <div id="emailHelp" class="form-text">Enter Your PAN Number to Verify</div>
            </div>

            <div class="mb-3 form-check">

                <button type="submit" class="btn btn-primary">Verify</button>
            </div>
        </form>

    </div>

    <div class="container">





    </div>
    <div class="container my-5">

        <?php
        $pan_ver_exists;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $pan = $_POST['pan'];

            $pattern = '/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/';



            $pan_ver = "select name,pno,AADHARno,job from user_details where PANno='$pan'";
            $pan_ver_res = mysqli_query($conn, $pan_ver);
            $pan_ver_res_rows = mysqli_num_rows($pan_ver_res);

            if ($pan_ver_res_rows > 0) {
                $pan_ver_exists = true;

                echo "<table class='table table-success'>
  <thead>
<tr>
      <th scope='col'>Name</th>
      <th scope='col'>Contact number</th>
      <th scope='col'>Aadhar</th>
      <th scope='col'>Job</th>
    </tr>
  </thead>";
                while ($row = mysqli_fetch_assoc($pan_ver_res)) {
                    echo " <tbody>
    <tr>
      <th scope='row'>" . $row['name'] . "</th>
       <td>" . $row['pno'] . "</td>
       <td>" . $row['AADHARno'] . "</td>
      <td>" . $row['job'] . "</td>
    </tr>";
                }
            } else {
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>PAN doesnot exists</strong> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div> ';
            }
        }
   

        ?>

    </div>






    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script>

    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>