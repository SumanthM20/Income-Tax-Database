<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>
<?php include 'partials/_dbconnect.php'; ?>
<?php
$sal_up = false;
$tax_up = false;
$tax_payed = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $year = $_POST["year"];
    $salary = $_POST["exampleInputEmail1"];
    $tax = $_POST["exampleInputPassword1"];
    $uname = $_SESSION["username"];
    $pan = $_SESSION["pan"];
    $pmethod = $_POST["select"];


    if ($year != 0 && $pmethod != 0) {
        $tax_up_check = "select * from tax where year='$year' and username='$uname'";
        $tax_up_check_res = mysqli_query($conn, $tax_up_check);
        $tax_up_check_res_rows = mysqli_num_rows($tax_up_check_res);
        if ($tax_up_check_res_rows >= 1)
            $tax_payed = false;
        else {

            $sal = "insert into salary(username,salary,PANno) values ('$uname','$salary','$pan')";
            $tax = "insert into tax(username,PANno,amount,year,pmethod) values('$uname','$pan',$tax,'$year','$pmethod')";
            $sal_res = mysqli_query($conn, $sal);
            if ($sal_res)
                $sal_up = true;
            if (mysqli_query($conn, $tax))
                $tax_up = true;
        }
    }
}
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
                <a class="nav-link active" aria-current="page" href="paytax.php">Pay Tax</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="panverification.php">Verify PAN</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="transaction.php">Transcation</a>
            </li>
            
        </ul>
    </div>

    <?php
    if (!$tax_payed) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong></strong> You already Payed Tax for the finalcial year ' . $year . '
                   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                     <span aria-hidden="true">×</span>
                   </button>
               </div>';
    }
    ?>

    <?php
    if (!$sal_up && !$tax_up && !$tax_payed) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Payment Failed</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div>';
    }
    if ($sal_up && $tax_up) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Payment Successfull</strong> 
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>
    </div>';
    }
    ?>
    <div class="container">
        <form action="/income tax/paytax.php" method="post">
            <div class="mb-3 my-3">
                <select class="form-select" aria-label="Default select example" id="year" name="year" required>
                    <option selected value="0">Select Financial Year</option>
                    <option value="2018-19">2018-19</option>
                    <option value="2019-20">2019-20</option>
                    <option value="2020-21">2020-21</option>
                    <option value="2021-22">2021-22</option>
                    <option value="2021-22">2022-23</option>

                </select>
            </div>


            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Enter Salary</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="exampleInputEmail1" aria-describedby="emailHelp" oninput="taxAmount();" required>
                <!--<div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>  -->
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Tax Amount</label>
                <input type="text" class="form-control" id="exampleInputPassword1" name="exampleInputPassword1" required>
            </div>

            <button type="button" class="btn btn-primary" id="button" style="display:inline;" onclick="visible();">NEXT</button>



            <div class="container mb-3 my-3" id="pmethod" style="display:none;">
                <select class="form-select" aria-label="Default select example" onchange="visible2();" id="select" name="select" required>
                    <option value="0" selected>Select Payment Method</option>
                    <option value="Card">Card</option>
                    <option value="Net Banking">Netbanking</option>

                </select>

                <div class="container" style="display:none;" id="card">
                    <div class="container mb-3 my-3">
                        <label for="inputPassword5" class="form-label">Card number</label>
                        <input type="text" id="cnum" class="form-control" aria-describedby="passwordHelpBlock" >
                    </div>

                    <div class="row mb-3 my-3">
                        <div class="col mb-3 my-3">
                            <input type="text" class="form-control" placeholder="EXP date" aria-label="First name" >
                        </div>
                        <div class="col mb-3 my-3">
                            <input type="text" class="form-control" placeholder="cvv" aria-label="Last name" >
                        </div>
                    </div>
                </div>
                <div class="container mb-3 my-3" id="netb" style="display:none;">
                    <div class="mb-3 my-3">
                        <label for="exampleInputEmail1" class="form-label">Net banking </label>
                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" >
                        </div>
                    </div>
                </div>
                <div class="container mb-3 my-2">
                    <button type="submit" class="btn btn-primary">PAY</button>
                </div>

            </div>





        </form>
    </div>


    <script>
        function taxAmount() {
            var sal = document.getElementById("exampleInputEmail1").value;
            var tax = 0;
            if (sal > 250000 && sal <= 500000)
                tax = tax + 0.05 * (sal - 250000);
            if (sal > 500000 && sal <= 750000)
                tax = tax + 0.10 * (sal - 500000);
            if (sal > 750000 && sal <= 1000000)
                tax = tax + 0.15 * (sal - 750000);
            if (sal > 1000000 && sal <= 1250000)
                tax = tax + 0.20 * (sal - 1000000);
            if (sal > 1250000 && sal <= 1500000)
                tax = tax + 0.25 * (sal - 1250000);
            if (sal > 1500000)
                tax = tax + 0.30 * (sal - 1250000);
            document.getElementById("exampleInputPassword1").value = tax;
        }

        function visible() {
            document.getElementById("button").style.display = "none";
            document.getElementById("pmethod").style.display = "inline";


        }

        function visible2() {
            var val = document.getElementById("select").value;
            if (val == 0) {
                document.getElementById("card").style.display = "none";
                document.getElementById("netb").style.display = "none";
            } else if (val == "Card") {
                document.getElementById("card").style.display = "inline";
                document.getElementById("netb").style.display = "none";
            } else {
                document.getElementById("netb").style.display = "inline";
                document.getElementById("card").style.display = "none";
            }
        }
    </script>




    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>