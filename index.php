<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="homepage.css">
    <title>iCare</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="header">

    <h1> <img src="logo.png" alt="Paris" width="150" height="150">iCare</h1>
    <h4>NEW ERA OF TREATMENT</h4>
</div>

<div class="topnav">
    <p></p>
</div>

<div class="row">
    <div class="column side">
        <div class="card">

        <h2>We are here for you</h2>
        <p>A place where your concerns are "one click" away from vanishing.</p>
            <br><br><br>

        </div>
    </div>

<div class="column middle">
    <div class="card">
    <form method="post" action="index.php">
        <?php include('errors.php'); ?>

        <label for="email" ><b>Email&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
        <input type="text" id="email" name="email" placeholder="email">
<br>
        <label for="pwd"><b>Password&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</b></label>
        <input type="password" id="pwd" name="pwd" placeholder="password">
<br>
        <label for="type"><b>Account Type</b></label>
        <select id="type" name="type">
            <option value="Doctor">Doctor</option>
            <option value="Patient">Patient</option>
            <option value="Admin">Admin</option>
        </select>
        <br>&nbsp&nbsp&nbsp
        <input type="submit" name="login_user" value="Sign in">
        &nbsp&nbsp&nbsp&nbsp
       <input type="submit" value="Sign up" formaction="SignUpLandingPage.html">
    </form>
    </div>
</div>

</div>

</body>
</html>