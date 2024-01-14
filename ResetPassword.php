<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
    <link rel="manifest" href="./favicon/site.webmanifest">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>finvestia.co.ke</title>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/site.webmanifest">
    <style>
        :root {
            --light: #f6f6f9;
            --primary: #1976d2;
            --light-primary: #cfe8ff;
            --grey: #eee;
            --dark-grey: #aaaaaa;
            --dark: #363949;
            --danger: #d32f2f;
            --light-danger: #fecdd3;
            --warning: #fbc02d;
            --light-warning: #fff2c6;
            --success: #388e3c;
            --light-success: #bbf7d0;

            --card-padding: 1.6rem;
            --padding-1: 16px;
            --padding-2: 8px;

            --card-border-radius: 1.6rem;
            --border-radius-1: 1rem;
            --border-radius-2: 10px;

            --box-shadow: 0.4rem 0.4rem 0 #717597;
            --box-shadow-2: 6px 6px 10px -1px rgba(224, 199, 199, 0.15);
        }

        .heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 70px;
            position: absolute;
            top: 0;
            background-color: var(--darkBack);
            margin-bottom: 30px;
        }

        .logo {
            width: auto;
            padding: 0 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
        }

        .logo h2 {
            color: var(--light);
            font-weight: bolder;
            font-size: 1.5rem;
        }

        .logo span {
            color: var(--secondary);
        }

        .logo img {
            width: 50px;
            height: 50px;
        }
    </style>
</head>

<body>
    <div class="heading">
        <div class="logo">
            <img src="./images/logo.png" alt="">
            <h2>fin<span>Vestia</span></h2>

        </div>


    </div>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
                <form class="login100-form validate-form" id="myForm" method="post" id="login_form_today">
                    <span class="login100-form-title p-b-49">
                        Change Your Password
                    </span>

                    <div class="response">
                        <p class="error" id="result" style="text-align:center; margin-top:20px; font-weight:bolder; color:green;"></p>

                    </div>
                    <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">

                    <div id="formWrapper">
                        <div class="wrap-input100 validate-input m-b-23" data-validate="password is reauired">
                            <span class="label-input100">New Password</span>
                            <input class="input100" id="newPass" type="password" name="newPassword" placeholder="Type Your New Password">
                            <span class="focus-input100" data-symbol="&#xf206;"></span>
                        </div>

                        <div class="wrap-input100 validate-input m-b-23" data-validate="Email Address is reauired">
                            <span class="label-input100">Confirm Password</span>
                            <input class="input100" id="confPass" type="password" name="confirmPassword" placeholder="Confirm Your Password">
                            <span class="focus-input100" data-symbol="&#xf190;"></span>
                        </div>

                        <div class="container-login100-form-btn">
                            <div class="wrap-login100-form-btn">
                                <div class="login100-form-bgbtn"></div>
                                <button class="login100-form-btn" type="submit" id="submitButton" name="submitButton">
                                    Change Password
                                </button>
                            </div>
                        </div>
                    </div>



                </form>
            </div>
        </div>
    </div>


    <div id="dropDownSelect1"></div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/daterangepicker/moment.min.js"></script>
    <script src="vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/countdowntime/countdowntime.js"></script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>


</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var formWrapper = document.getElementById('formWrapper');
        var form = document.getElementById("myForm");
        var submitButton = document.getElementById("submitButton");

        form.addEventListener("submit", function(e) {
            e.preventDefault();

            var formData = new FormData(form);
            formData.append('submitButton', true);

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "./ResetPasswordHandle.php", true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("result").innerHTML = xhr.responseText;
                    // formWrapper.style.display = "none";
                }
            };

            xhr.send(formData);
        });
    });
</script>
<script>
        // Disable right-click context menu
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
        });

        // Disable keyboard shortcuts (Ctrl + U, Ctrl + Shift + I)
        document.addEventListener('keydown', function(event) {
            if ((event.ctrlKey && event.key === 'u') || (event.ctrlKey && event.shiftKey && event.key === 'i')) {
                event.preventDefault();
            }
        });
    </script>
</html>