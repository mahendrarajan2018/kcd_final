<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senthur Murugan Transport</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style1.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/form.css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>
</head>
<body>
<div class="mobilebg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12 fullpad leftbg">
                <div class="login-img">
                    <h1 class="bold text-center text-white">Senthur Murugan Transport</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12 align-self-center px-lg-5 smallbg">
                <div class="let-pad">
                    <div class="d-block d-md-none pb-5">
                        <img src="images/yuvrajlogin.png" class="img-fluid" alt="Yuvraj Fireworks" title="Yuvraj Fireworks">
                    </div>
                    <div class="d-md-block pb-4">
                        <div class="icon text-center">
                            <i class="fa fa-user"></i>
                        </div>
                    </div>    
                    <h4 class="bold text-center">Welcome</h4>
                    <div class="row">
                        <form class="box w-100" action="login.php" method="POST">
                            <div class="col-lg-12 pt-4">
                                <div class="w-100">
                                    <label class="medium login-label">User Name</label>
                                    <input type="text" class="form-control medium smallfnt" name="" placeholder="xyz@email.com">
                                </div>
                            </div>
                            <div class="col-lg-12 pt-4">
                                <div class="w-100">
                                    <label class="medium login-label">Password</label>
                                    <input type="password" class="form-control medium smallfnt" id="password" name="password" placeholder="Enter Your Password*">
                                    <div style="position: relative; top: -31px; float: right; display: block;" class="input-group-append" data-toggle="tooltip" data-placement="right" title="Show Password">
                                        <button class="btn btn-secondary" style="padding: 2px 7px;" type="button" id="passwordBtn" data-toggle="button" aria-pressed="false"><i class="fa fa-eye"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 pt-4">
                                <button class="loginbtn bold"> Log In</button>
                            </div>
                        </form>
                    </div>
                </div>   
            </div>
        </div>
    </div>  
</div>
<script>
$(document).ready(function() {
  $(function() {
    $('[data-toggle="tooltip"]').tooltip();
  });

  const passBtn = $("#passwordBtn");

  passBtn.click(togglePassword);

  function togglePassword() {
    const passInput = $("#password");
    if (passInput.attr("type") === "password") {
      passInput.attr("type", "text");
    } else {
      passInput.attr("type", "password");
    }
  }
});
</script>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {

function OTPInput() {
const inputs = document.querySelectorAll('#otp > *[id]');
for (let i = 0; i < inputs.length; i++) { inputs[i].addEventListener('keydown', function(event) { if (event.key==="Backspace" ) { inputs[i].value='' ; if (i !==0) inputs[i - 1].focus(); } else { if (i===inputs.length - 1 && inputs[i].value !=='' ) { return true; } else if (event.keyCode> 47 && event.keyCode < 58) { inputs[i].value=event.key; if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } else if (event.keyCode> 64 && event.keyCode < 91) { inputs[i].value=String.fromCharCode(event.keyCode); if (i !==inputs.length - 1) inputs[i + 1].focus(); event.preventDefault(); } } }); } } OTPInput(); });
</script>    
</body>
</html>