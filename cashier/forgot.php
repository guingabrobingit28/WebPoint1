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
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-aFq/bzH65dt+w6FI2ooMVUpc+21e0SRygnTpmBvdBgSdnuTN7QbdgL+OapgHtvPp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <link rel="stylesheet" href="./forgot.css">
</head>
<body>

    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
            <!-- Forgot Password -->
          <form id="form1" class="sign-in-form">
            <h2 class="title">Enter your email</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="text" id="email" name="email" require/>
            </div>
            <input type="submit" name="forgot_pass" id="forgot_pass" value="Submit" class="btn solid" form="form1"/>
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

        $(document).ready(function(){
            // when the button is clicked get all the data from the form
            $("#forgot_pass").click(function(e){
                e.preventDefault();
                const form = $("#form1");
                // this will get all the input field from the form
                const formData = form.serialize();

                // send an ajax request to the API
                $.ajax({
                    url: 'forgotAPI.php',
                    method: 'post',
                    data: formData,
                    // must include this dataType
                    // go to the forgotAPI.php file
                    dataType: "json",
                }).done(function(response){
                    if(response.status === 'success'){
                        Swal.fire({
                            icon: response.status,
                            title: 'Success!',
                            text: response.message
                        });
                        return;
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
            });
        });
    </script>
</body>
</html>