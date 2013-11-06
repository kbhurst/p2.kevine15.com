
<link rel="stylesheet" type="text/css" href="css/style.css" />


<!-- build form -->

<form method='POST' action='/users/p_login'>

  <h2>Log In</h2>
  <br><br>

    Email<br>
    <input type='text' name='email'>    
    <br><br>

    Password<br>
    <input type='password' name='password'>
    <br><br>


<!-- If error occurs make them try again -->

    <?php if(isset($error)): ?>
     
            <h3> Login failed. Please check your email and password and try again. </h3>
   
        <br>
    <?php endif; ?>

    <input type='submit' value='Log in'>
    <br><br>

</form>