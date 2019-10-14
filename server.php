<?php
session_start();

// initializing variables

$errors = array();

// connect to the database
$link = mysqli_connect("localhost", "root", "", "icare");


// Patient REGISTER USER
if (isset($_POST['patient_reg_user'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $password = mysqli_real_escape_string($link, $_REQUEST['pwd']);
    $type = "Patient";

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($age)) {
        array_push($errors, "Age is required");
    }
    if (empty($nid)) {
        array_push($errors, "Nid is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // first check the database to make sure
    // a user does not already exist with the same nid and email
    $user_check_query = "SELECT * FROM patient WHERE NID='$nid' OR Email='$email' LIMIT 1";
    $result = mysqli_query($link, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nid'] === $nid) {
            array_push($errors, "Nid already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password);//encrypt the password before saving in the database

        $query = "INSERT INTO patient (NID,Name,Age,Gender,Email,Address,Pwd) 
VALUES ('$nid','$name','$age','$gender','$email','$address','$password')";

        $query2 = "INSERT INTO allusers (Nid,Pwd,Role) VALUES ('$nid','$password','$type')";

        mysqli_query($link, $query);
        mysqli_query($link, $query2);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        header('location: patientHomepage.php');
    }
}

//DoctorSide new patient reg

if (isset($_POST['doctor_patient_reg_user'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $password = mysqli_real_escape_string($link, $_REQUEST['pwd']);
    $type = "Patient";

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($age)) {
        array_push($errors, "Age is required");
    }
    if (empty($nid)) {
        array_push($errors, "Nid is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // first check the database to make sure
    // a user does not already exist with the same nid and email
    $user_check_query = "SELECT * FROM patient WHERE NID='$nid' OR Email='$email' LIMIT 1";
    $result = mysqli_query($link, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nid'] === $nid) {
            array_push($errors, "Nid already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password);//encrypt the password before saving in the database

        $query = "INSERT INTO patient (NID,Name,Age,Gender,Email,Address,Pwd) 
VALUES ('$nid','$name','$age','$gender','$email','$address','$password')";

        mysqli_query($link, $query);

        header('location: docExistingPage.php');
    }
}


//Doctor Reg User
if (isset($_POST['doctor_reg_user'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $ssc = mysqli_real_escape_string($link, $_REQUEST['ssc']);
    $sscSession = mysqli_real_escape_string($link, $_REQUEST['sscSession']);
    $sscinst = mysqli_real_escape_string($link, $_REQUEST['sscinst']);
    $hsc = mysqli_real_escape_string($link, $_REQUEST['hsc']);
    $hscSession = mysqli_real_escape_string($link, $_REQUEST['hscSession']);
    $hscinst = mysqli_real_escape_string($link, $_REQUEST['hscinst']);
    $bmdc = mysqli_real_escape_string($link, $_REQUEST['bmdc']);
    $mbbs = mysqli_real_escape_string($link, $_REQUEST['mbbs']);
    $mbbsInst = mysqli_real_escape_string($link, $_REQUEST['mbbsInst']);
    $postGrad = mysqli_real_escape_string($link, $_REQUEST['postGrad']);
    $password = mysqli_real_escape_string($link, $_REQUEST['pwd']);
    $type = "Doctor";

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($age)) {
        array_push($errors, "Age is required");
    }
    if (empty($nid)) {
        array_push($errors, "Nid is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($ssc)) {
        array_push($errors, "SSC Grade is required");
    }
    if (empty($sscSession)) {
        array_push($errors, "SSC Session is required");
    }
    if (empty($sscinst)) {
        array_push($errors, "SSC institution is required");
    }
    if (empty($hsc)) {
        array_push($errors, "HSC Grade is required");
    }
    if (empty($hscSession)) {
        array_push($errors, "HSC Session is required");
    }
    if (empty($hscinst)) {
        array_push($errors, "HSC institution is required");
    }
    if (empty($bmdc)) {
        array_push($errors, "BMDC Reg No is required");
    }
    if (empty($mbbs)) {
        array_push($errors, "MBBS session is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // first check the database to make sure
    // a user does not already exist with the same nid and email
    $user_check_query = "SELECT * FROM doctor WHERE NID='$nid' OR Email='$email' LIMIT 1";
    $result = mysqli_query($link, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nid'] === $nid) {
            array_push($errors, "Nid already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password);//encrypt the password before saving in the database

        $query = "INSERT INTO doctor (NID,Name,Age,Gender,Email,Address,SSC_GPA,SSC_Session,SSC_inst,HSC_GPA,HSC_Session,
HSC_inst,BMDC_RegNo,MBBS_Session,MBBS_inst,PostGrad_deatails,Pwd) 
VALUES ('$nid','$name','$age','$gender','$email','$address','$ssc','$sscSession','$sscinst','$hsc','$hscSession','$hscinst',
'$bmdc','$mbbs','$mbbsInst','$postGrad','$password')";


        mysqli_query($link, $query);
        mysqli_query($link, $query2);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        header('location: doctorHomepage.php');
    }


}


//Admin_reg_user
if (isset($_POST['admin_reg_user'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $gender = mysqli_real_escape_string($link, $_REQUEST['gender']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $password = mysqli_real_escape_string($link, $_REQUEST['pwd']);
    $type = "Admin";

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($name)) {
        array_push($errors, "Name is required");
    }
    if (empty($age)) {
        array_push($errors, "Age is required");
    }
    if (empty($nid)) {
        array_push($errors, "Nid is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($address)) {
        array_push($errors, "Address is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    // first check the database to make sure
    // a user does not already exist with the same nid and email
    $user_check_query = "SELECT * FROM admin WHERE NID='$nid' OR Email='$email' LIMIT 1";
    $result = mysqli_query($link, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['nid'] === $nid) {
            array_push($errors, "Nid already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password);//encrypt the password before saving in the database

        $query = "INSERT INTO admin (NID,Name,Age,Gender,Email,Address,Pwd) 
VALUES ('$nid','$name','$age','$gender','$email','$address','$password')";


        mysqli_query($link, $query);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    }
}


// LOGIN USER
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($link, $_POST['email']);
    $password = mysqli_real_escape_string($link, $_POST['pwd']);
    $type = mysqli_real_escape_string($link, $_POST['type']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        if ($type === "Patient") {
            $password = md5($password);
            $query = "SELECT * FROM patient WHERE Email='$email' AND Pwd='$password'";
            $results = mysqli_query($link, $query);
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: patientHomepage.php');
            } else {
                array_push($errors, "Wrong email/password combination");
            }
        }

        if ($type === "Doctor") {
            $password = md5($password);
            $query = "SELECT * FROM doctor WHERE Email='$email' AND Pwd='$password'";
            $results = mysqli_query($link, $query);
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: doctorHomepage.php');
            } else {
                array_push($errors, "Wrong email/password combination");
            }
        }

        if ($type === "Admin") {
            $password = md5($password);
            $query = "SELECT * FROM admin WHERE Email='$email' AND Pwd='$password'";
            $results = mysqli_query($link, $query);
            if (mysqli_num_rows($results) == 1) {
                $_SESSION['email'] = $email;
                $_SESSION['success'] = "You are now logged in";
                header('location: adminHomepage.php');
            } else {
                array_push($errors, "Wrong email/password combination");
            }
        }
    }
}

//Admin Settings Update
if (isset($_POST['admin_Setting'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $pwd = mysqli_real_escape_string($link, $_REQUEST['pwd']);

    if (empty($pwd)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
    $password = md5($pwd);//encrypt the password before saving in the database

    $query = "Update admin  Set Name = '$name',Age = $age ,Email ='$email',Address = '$address',Pwd = '$password'
    where NID = '$nid'";


    mysqli_query($link, $query);
    $_SESSION['email'] = $email;
    $_SESSION['success'] = "You are now logged in";
    header('location: index.php');
    } else {
        header('location: adminSettings.php');
    }

}


//patient settings update
if (isset($_POST['patient_setting'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $pwd = mysqli_real_escape_string($link, $_REQUEST['pwd']);

    if (empty($pwd)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password = md5($pwd);//encrypt the password before saving in the database

        $query = "Update patient  Set Name = '$name',Age = $age ,Email ='$email',Address = '$address',Pwd = '$password'
    where NID = '$nid'";


        mysqli_query($link, $query);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    } else {
        header('location: patientSettings.php');
    }
}

//Doctor settings update
if (isset($_POST['doctor_setting'])) {
    // receive all input values from the form
    $name = mysqli_real_escape_string($link, $_REQUEST['name']);
    $age = mysqli_real_escape_string($link, $_REQUEST['age']);
    $nid = mysqli_real_escape_string($link, $_REQUEST['nid']);
    $email = mysqli_real_escape_string($link, $_REQUEST['email']);
    $address = mysqli_real_escape_string($link, $_REQUEST['address']);
    $ssc = mysqli_real_escape_string($link, $_REQUEST['ssc']);
    $sscSession = mysqli_real_escape_string($link, $_REQUEST['sscSession']);
    $sscinst = mysqli_real_escape_string($link, $_REQUEST['sscinst']);
    $hsc = mysqli_real_escape_string($link, $_REQUEST['hsc']);
    $hscSession = mysqli_real_escape_string($link, $_REQUEST['hscSession']);
    $hscinst = mysqli_real_escape_string($link, $_REQUEST['hscinst']);
    $bmdc = mysqli_real_escape_string($link, $_REQUEST['bmdc']);
    $mbbs = mysqli_real_escape_string($link, $_REQUEST['mbbs']);
    $mbbsInst = mysqli_real_escape_string($link, $_REQUEST['mbbsInst']);
    $postGrad = mysqli_real_escape_string($link, $_REQUEST['postGrad']);
    $pwd = mysqli_real_escape_string($link, $_REQUEST['pwd']);

    if (empty($pwd)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password = md5($pwd);//encrypt the password before saving in the database

        $query = "Update doctor  Set Name = '$name',Age = $age ,Email ='$email',Address = '$address',SSC_GPA = '$ssc',
SSC_Session = '$sscSession',SSC_inst = '$sscinst' , HSC_GPA = '$hsc', HSC_Session = '$hscSession' , HSC_inst = '$hscinst', BMDC_RegNo = '$bmdc',
MBBS_Session = '$mbbs', MBBS_inst = '$mbbsInst', PostGrad_deatails = '$postGrad', Pwd = '$password'
    where NID = '$nid'";


        mysqli_query($link, $query);
        $_SESSION['email'] = $email;
        $_SESSION['success'] = "You are now logged in";
        header('location: index.php');
    } else {
        header('location: doctorSettings.php');
    }
}

?>