
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <title>finvestia.co.ke</title>
  <link rel="stylesheet" type="text/css" href="./css/util.css">
	<link rel="stylesheet" type="text/css" href="./css/main.css">
  <link rel="stylesheet" type="" href="./style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="apple-touch-icon" sizes="180x180" href="./favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="./favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="./favicon/favicon-16x16.png">
  <link rel="manifest" href="./favicon/site.webmanifest">
  <style>
  .termsandpolicy{
    color:#fefe;

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
  <div class="container">
    <div class="title">Registration</div>
    <div class="content">
      <form action="#" method="post" id="registrationForm">
        <div class="user-details">
          <div class="input-box">
            <span class="details">First Name</span>
            <input type="text" name="first_name" placeholder="Enter First Name" required>
          </div>
          <div class="input-box">
            <span class="details">Last Name</span>
            <input type="text" name="last_name" placeholder="Enter your Last Name" required>
          </div>
          <div class="input-box">
            <span class="details">Username</span>
            <input type="text" name="username" placeholder="Enter your username" required>
          </div>
          <div class="input-box">
            <span class="details">Email</span>
            <input type="email" name="email_address" placeholder="Enter your email" required>
          </div>
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="number" name="phone_Number" placeholder="Enter your number" required>
          </div>
          <div class="input-box">
            <span class="details">Password</span>
            <input type="password" name="password" placeholder="Enter your password" required>
          </div>
          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="password" name="conf_password" placeholder="Confirm your password" required>
          </div>
          <div class="input-box">
            <input type="text" name="refferer" value="
            <?php

            if (isset($_GET['ref'])) {
              $reffererUsername = $_GET['ref'];
            } else {
              $reffererUsername = 'ADMIN';
            }
            echo $reffererUsername;
            ?>
            " hidden>
          </div>
        </div>
        <div>
          <p class="error" id="error-message" style="color:var(--secondary);"></p>
        </div>
        <p class="termsandpolicy" style="font-size:.6rem;">By clicking the "Register" button below, you acknowledge that you have read, understood, and agree to the <a  style="color: aqua;" href="./terms.php" target="_blank">Terms and Conditions</a> and <a style="color: aqua;" href="./policy.php" target="_blank">Privacy Policy</a> of Finvestia. You consent to the collection, processing, and storage of your personal data in accordance with the terms outlined in the provided documents.</p>
        <div class="button">
          <input type="submit" value="Register">
        </div>
        <div class="button">
          <a href="./login.php">Sign In</a>
        </div>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('registrationForm').addEventListener('submit', function(event) {
      event.preventDefault(); // Prevent form submission

      // Get form data
      const formData = new FormData(this);

      // Create XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Configure the request
      xhr.open('POST', './RegisterUser.php', true);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      // Set up a callback for when the request is complete
      xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 300) {
          // Request was successful
          const response = JSON.parse(xhr.responseText);
          if (response.error) {
            // Display the error message on the page
            document.getElementById('error-message').textContent = response.error;
          } else if (response.success) {
            // If registration was successful, do something (optional)
            console.log(response.success); // Registration successful
          }
        } else {
          // Request failed
          console.error('Request failed:', xhr.statusText);
        }
      };

      // Handle network errors
      xhr.onerror = function() {
        console.error('Network error occurred');
      };

      // Send the request with the form data
      xhr.send(formData);
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
</body>

</html>