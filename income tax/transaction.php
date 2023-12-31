<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

include 'partials/_dbconnect.php';
$transaction_exists;
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
                <a class="nav-link" href="panverification.php">Verify PAN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="transaction.php">Transaction</a>
            </li>
            
        </ul>
    </div>



    <div class="container">
        <form action="/income tax/transaction.php" method="post">
            <div class="mb-3 my-4">
                <select class="form-select" aria-label="Default select example" id="year" name="year">
                    <option selected>Select Financial Year</option>
                    <option value="All" selected>All</option>
                    <option value="2018-19">2018-19</option>
                    <option value="2019-20">2019-20</option>
                    <option value="2020-21">2020-21</option>
                    <option value="2021-22">2021-22</option>
                    <option value="2022-23">2022-23</option>


                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>
    </div>



    <div class="container mb-3 my-5">

        <?php

        if (isset($_POST['submit'])) {

            $username = $_SESSION["username"];
            $year = $_POST['year'];
            if ($year == "All") {

                $tax_hist = "select Tno,PANno,amount,year,pmethod from tax where username='$username'";
            } else
                $tax_hist = "select Tno,PANno,amount,year,pmethod from tax where username='$username' and year='$year'";
            $tax_hist_res = mysqli_query($conn, $tax_hist);
            if (mysqli_num_rows($tax_hist_res) > 0) {

                echo "<table class='table table-success'>
      <thead>
        <tr>
          <th scope='col'>TNO</th>
          <th scope='col'>PAN NO</th>
          <th scope='col'>Amount</th>
          
          <th scope='col'>Year</th>
          <th scope='col'>Payment Method</th>
        </tr>
      </thead>";


                while ($row = mysqli_fetch_assoc($tax_hist_res)) {
                    echo "<tr>
                 <td>" . $row['Tno'] . "</td>
                 <td>" . $row['PANno'] . "</td>
                 <td>" . $row['amount'] . "</td>
                
                 <td>" . $row['year'] . "</td>
                 <td>" . $row['pmethod'] . "</td>
                 </tr>";
                }
                echo "</table>";
            } else {
                echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>No Transaction Found</strong> 
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>