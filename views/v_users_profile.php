

<!-- Style sheet for page -->
	<link rel="stylesheet" type="text/css" href="/css/style.css" />


<!--check to see if logged in and display name-->
	<?php if(!$user): ?>
        <?php            Router::redirect("/users/login");  ?>
	
	<?php else: ?>
        <h2>This is the profile for <?=$user->first_name?> <?=$user->last_name?> </h2>
	<?php endif; ?>
	<br><br>

<!--notes on member time-->
	<?php if($user) 
        $convert_time = $user->created;
        echo 'Member since: ';
        echo date('M d Y', $convert_time); 
	?>
	<br><br>

	<h3><a href='/users/editProfile' >Edit my profile</a></h3>
	<hr/>

	
<!--add link to follow others -->
    <h3> Follow <a href='/posts/users'>Others</a></h3>


