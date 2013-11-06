<!DOCTYPE html>
<html>
<head>
	<title><?php if(isset($title)) echo $title; ?></title>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />	
					
	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>  

<div id="nav">


 <!--   <div id='menu'>

        <a href='/'>Home</a>  --!>
<link rel="stylesheet" type="text/css" href="css/style.css" />

        <!-- Menu for users who are logged in -->
        <?php if($user): ?>
		
		
		<ul>
			<li><a href="/">Home</a></li>
			<li><a href="/users/profile">Profile</a></li>
			<li><a href="/posts/index">Posts</a></li>
			<li><a href="/posts/add">Add Posts</a></li>
			<li><a href="/posts/users">Follow or Unfollow</a></li>
			<li><a href="/users/logout">Logout</a></li>
		</ul>

            <a href='/users/logout'>Logout</a>
            <a href='/users/profile'>Profile</a>

        <!-- Menu options for users who are not logged in -->
        <?php else: ?>

            <li><a href='/users/signup'>Sign up</a></li>
            <li><a href='/users/login'>Log in</a></li>

        <?php endif; ?>

   <!-- </div>  -->
</div>


    <br>

    <?php if(isset($content)) echo $content; ?>

</body>
</html>