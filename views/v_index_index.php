<link rel="stylesheet" type="text/css" href="css/style.css" />


<!-- check to see if the user is logged in-->
<?php if($user): ?>

<!-- if so display go to the posts page -->

        <?php Router::redirect("/posts");  ?>
		
		
<?php else: ?>

	<!-- else go to the home screen--> 
	
       <h1>Welcome to <?=APP_NAME?><?php if($user) echo ', '.$user->first_name; ?></h1>
       <br><br>
       <h3>Please log in or sign up</br>
       <br><br>
       <br><br>
	   <h4>+1 is edit profile and send email <h4>
<?php endif; ?>







