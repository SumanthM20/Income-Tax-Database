<?php
$showAlert = false;
$showError = false;
$uname_exists = false;
$pan_exists = false;
$pass_equal = true;
$pancheck=true;
$aadhar_valid=true;
$pno_valid=true;
if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
  include 'partials/_dbconnect.php';

//collecting form data

  $name = $_POST["name"];
  $pno = $_POST["contact"];
  $panno = $_POST["pan"];
  $aadhaar = $_POST["aadhaar"];
  $occupation = $_POST["occupation"];
  $username = $_POST["username"];
  $password = $_POST["password"];
  $cpassword = $_POST["cpassword"];

//pan validation
  $pattern = '/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/';
if (preg_match($pattern, $panno)) 
   $pancheck=true;
else
    $pancheck=false;

  //aadhaar validation  
$aadhaar_pattern='/^[0-9]{11}$/';
if (preg_match($aadhaar_pattern,$aadhaar))
$aadhar_valid=true;
else
$aadhar_valid=false;

//phone number validation 
$pno_pattern='/^[0-9]{10}$/';
if (preg_match($pno_pattern,$pno))
$pno_valid=true;
else
$pno_valid=false;
//
if($pno_valid &&$aadhar_valid&&$pancheck)
$fields_valid=true;
else
$fields_valid=false;


  //to check whether username already exists or not
  $check_uname = "Select * from user where username='$username'";
  $uname_check_result = mysqli_query($conn, $check_uname);
  $num1 = mysqli_num_rows($uname_check_result);
  if ($num1 >= 1)
    $uname_exists = true;


  //to check whether pan already exists or not
  $check_pan = "Select * from user_details where PANno='$panno'";
  $pan_check_result = mysqli_query($conn, $check_pan);
  $num2 = mysqli_num_rows($pan_check_result);
  if ($num2 >= 1)
    $pan_exists = true;

  //to check whether password and confirm password are equal
  if ($password != $cpassword)
    $pass_equal = false;

  if ($pass_equal && ($uname_exists == false) && ($pan_exists == false)&& ($fields_valid==true)) {
    $sql = "INSERT INTO user ( username, password) VALUES ('$username', '$password')";
    $sql_2 = "INSERT INTO user_details(username,name,pno,PANno,AADHARno,job) VALUES('$username','$name','$pno','$panno','$aadhaar','$occupation')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $result2 = mysqli_query($conn, $sql_2);
      if ($result2) {
        $showAlert = true;
      } else {
        $del_user = "delete from user where username='$username'";
        mysqli_query($conn, $del_user);
      }
    }
  } else {

    $showError = "Passwords do not match";
  }
// here     hi
//else {
 // $pancheck=false;
//}
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

  <title>SignUp</title>
  <script >

    function validate_pan()
    {
      var panexp=/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/;
      var elem=document.getElementById("pan");
      if(elem.value.search(panexp)!=-1)
      {
    
        return true;
      }
      else{
        elem.select();
        elem.focus();
        <?php
      echo 'alert("Enter coreect pan number");';
      ?>
      return false;
      }


    }
    </script>
</head>

<body>
  <?php require 'partials/_nav.php' ?>
  <?php
  if ($showAlert) {
    echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> Your account is now created and you can login
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }
  if (!$pancheck) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>Enter proper pan number
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }

  if (!$aadhar_valid) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>Enter proper Aadhaar number
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }

  if (!$pno_valid) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong>Enter proper contact number
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }
  if ($uname_exists) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> User name ' . $username . ' already exists 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }
  if ($pan_exists) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> PAN number ' . $panno . ' already registered 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }
  if (!$pass_equal) {
    echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> ' . $showError . '
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
  }

  ?>

  <div class="container my-4">
    <h1 class="text-center">Signup to our website</h1>
    <form action="/income tax/signup.php" method="post"  >

      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>

      <div class="form-group">
        <label for="contact">Contact No</label>
        <input type="text" class="form-control" id="contact" name="contact" required>
      </div>

      <div class="form-group">
        <label for="pan">PAN No</label>
        <input type="text" class="form-control" id="pan" name="pan" placeholder="AAAAA-1234-A"  required>
      </div>
      <div class="form-group">
        <label for="aadhaar">Aadhaar No</label>
        <input type="text" class="form-control" id="aadhaar" name="aadhaar" placeholder="dddd-dddd-dddd" required>
      </div>
      <div class="form-group">
        <label for="occupation">Occupation</label>
        <input type="text" class="form-control" id="occupation" name="occupation" required>
      </div>
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp" required>

      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="cpassword">Confirm Password</label>
        <input type="password" class="form-control" id="cpassword" name="cpassword" required>
        <small id="emailHelp" class="form-text text-muted">Make sure to type the same password</small>
      </div>

      <button type="submit" onsubmit="return validate_pan();" class="btn btn-primary" name="submit">SignUp</button>
    </form>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>