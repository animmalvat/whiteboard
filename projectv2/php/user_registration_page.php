<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <title>Registration Form</title>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link href="https://fonts.googleapis.com/css?family=Raleway:500" rel="stylesheet">
      <link rel="stylesheet" href="lib/bxslider/dist/jquery.bxslider.min.css">
      <link rel="stylesheet" type="text/css" href="http://localhost/projectv2/css/registration.css">
   </head>
   <body>
      <div class="box">
         <div class="co-form">
            <div class="heading">
               <h3 style="padding-bottom: 5px;">White Board</h3>
               <p style="font-size:20px; color: #888888;">Register to start using White Board</p>
            </div>
            <div class="form1">
               <form action="http://localhost/projectv2/php/user_registration.php" method="post" id='registrationForm' onsubmit=' return validate();'>
                  <div class="name" style="padding-top: px;">
                     <div class="n-m" style="margin-right: 15px; display:inline; float:left;">
                        <span>First Name</span>
                        <input class="input100" type="text" name="firstname" required>
                     </div>
                     <!-- firstname -->
                     <div class="n-m" style="display: inline;/* float:  left; *">
                        <span>Last Name</span>
                        <input class="input100" type="text" name="lastname" style="display: inline;width: 48%;" required>
                     </div>
                     <!-- lastname -->
                  </div>
                  <!-- name -->
                  <div class="n-m">
                     <span>Email</span>
                     <input class="input100" type="Email" name="email" onchange='ValidateEmail()' id='email' style="width: 207%;" required>
                  </div>
                  <!-- email -->
                  <div class="Password">
                     <div class="n-m inline" style="margin-right: 15px">
                        <span>Password</span>
                        <input class="input100" type="password" name="password" id='password'>
                     </div>
                     <div class="n-m inline">
                        <span>Confirm Password</span>
                        <input class="input100" type="password" onchange='passwordRequiredAndSame();' id='cpassword' name="confirmpassword">
                     </div>
                     <p style="font-size: 12px; color: #888888;">Use more than 8 characters with letters,numbers &amp; symbols.</p>
                  </div>
                  <!-- password -->
                  <div class="n-m" style="padding-top: 12px;">
                     <span>Contact</span>
                     <input class="input100" name="contact" id='contact' onchange="phonenumber()" style="width: 207%; " required>
                  </div>
                  <!-- contact -->
                   
                   <?php 
                           if(isset($_GET['error_msg'])) {
                           	echo "<div style='color: #b00020; font-size: 14px;'>".$_GET['error_msg']."</div>";
                           }
                   ?>
                   
                  <div class="end">
                     <a href="http://localhost/projectv2/php/user_login_page.php" class="login inline"><span>Log In instead</span></a>
                     <div class="co-btn" style="">
                        <input type="submit" class="btn-f inline">
                     </div>
                  </div>
                    
                  <!-- end -->
               </form>
            </div>
            <!-- form1 -->
            <div class="help-aboutus">
               <a href="http://localhost/projectv1/html/help.html">Help</a>
               <a href="http://localhost/projectv1/html/about.html">About Us</a>
            </div>
         </div>
      </div>
       
       <script>
        function ValidateEmail() 
            {
                mail = document.getElementById('email').value;
                 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
                  {
                      console.log('kuchh nahi hai');
                    return (true);
                  }
                    alert("Please Enter a valid email address");
                    return (false);
            }
           
           function phonenumber(){
               phone = document.getElementById('contact').value;
               var phoneno = /^\d+$/;
               if(phoneno.test(phone)) {
                   return true;
               }
               else {
                    alert("Please Enter a Valid Phone Number");
                    return false;
                }
           }
           
           function validate() {
               if(  ValidateEmail() &&   phonenumber() &&   passwordRequiredAndSame()) {
                    return true;
               } else{
                   return false;
               }
           }
           
           function passwordRequiredAndSame() {
               var password = document.getElementById('password').value;
               var cpassword = document.getElementById('cpassword').value;
               if(password == cpassword) {
                   password1 = password.trim();
                   if(password1 == "") {
                       alert('please enter password');
                   } else {
                       return true;
                   }
               } else {
                   alert('password do not match with confirm password');
               }
               
           }
       </script>
   </body>
</html>