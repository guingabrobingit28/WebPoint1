<?php
session_start();

include("connection.php");
include("functions.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./passReset.css">
</head>
<body>
<div class="container">
      <div class="forms-container">
        <div class="signin-signup">
            <!-- password reset -->
          <form id="form1" class="sign-in-form">
            <h2 class="title">Reset your password</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" id="email" name="email" placeholder="Enter your email" require/>
            </div>
            <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" id="password" name="password" required/>
            <i class="fas fa-eye toggle-password" id="toggle-password"></i>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password"  placeholder="Confirm Password" id="cfpassword" name="cfpassword" required/>
            <i class="fas fa-eye toggle-cfpassword" id="toggle-cfpassword"></i>
          </div>
            <input type="submit" name="pass_reset" id="pass_reset" value="Submit" class="btn solid" form="form1"/>
          </form>
        </div>
      </div>

        <!-- panel -->
      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
          </div>
          <img src="./images/login1.svg" class="image" alt="Login Image" />
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js" integrity="sha384-heAjqF+bCxXpCWLa6Zhcp4fu20XoNIA98ecBC1YkdXhszjoejr5y9Q77hIrv8R9i" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js" integrity="sha512-pumBsjNRGGqkPzKHndZMaAG+bir374sORyzM3uulLV14lN5LyykqNk8eEeUlUkB3U0M4FApyaHraT65ihJhDpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>

        //show and hide password
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);

          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });

        const toggleCfpassword = document.querySelector('.toggle-cfpassword');
        const cfpasswordInput = document.querySelector('#cfpassword');

        toggleCfpassword.addEventListener('click', function () {
          const type = cfpasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          cfpasswordInput.setAttribute('type', type);

          this.classList.toggle('fa-eye');
          this.classList.toggle('fa-eye-slash');
        });

        $(document).ready(function(){
            // when the button is clicked
            $("#pass_reset").click(function(e){
                e.preventDefault();
                const form = $("#form1")
                const formData = form.serialize();
                // get the password input field
                const password = form.find("input[name='password']").val();
                // for checking if the password is at least 12 characters, one capital letter, one small letter, contains number and a special character
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/;
                // if true then execute the ajax
                if(passwordRegex.test(password)){
                $.ajax({
                    url: 'passResetAPI.php',
                    method: 'post',
                    data: formData,
                    dataType: "json",
                }).done(function(response){
                    console.log(response);
                    if(response.status === 'success'){
                        Swal.fire({
                            icon: response.status,
                            title: 'Success!',
                            text: response.message
                        }).then((result) => {
                            window.location.href = 'reg_log.php';
                        });
                    }else{
                        Swal.fire({
                            icon: response.status,
                            title: 'Error!',
                            text: response.message
                        });
                    }
                }).fail(function(jqXHR, textStatus, errorThrown){
                    console.log('AJAX error: ' + textStatus + ' - ' + errorThrown);
                    console.log(jqXHR.responseText);
                });
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Password must be 12 characters long and contain at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&*()_+)'
                });
            }
            });
        });

    </script>
</body>
</html>