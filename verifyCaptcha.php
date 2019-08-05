<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
<form id="reservation-form" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>"  method="POST">
    <?php
    session_start();
    $error = '';
    if($_POST) {
        if (sha1($_POST['captcha_challenge']) == $_SESSION['captcha_text']) {
            $error .= "The captcha code you entered matches. Succes!.  <br />";
        } else {
            $error .= "The captcha code you entered does not match. Please try again. <br />";
        }
    }
    ?>
<div class="elem-group">
    <label for="captcha">Please Enter the Captcha Text</label>
    <img src="captcha.php" alt="CAPTCHA" class="captcha-image">
    <br>
    <input type="text" id="captcha" name="captcha_challenge"  pattern="[A-Z0-9]{4,6}" required>
    <button type="button" id="refresh-captcha"><i class="fa fa-refresh" aria-hidden="true"></i></button>
    <input id="button" type="submit" value="check">
</div>
</form>

<?php echo $error ?>



<script>
    var refreshButton = document.getElementById('refresh-captcha');
    refreshButton.onclick = function() {
        console.log('a');
        document.querySelector(".captcha-image").src = 'captcha.php?' + Date.now();
    }
</script>