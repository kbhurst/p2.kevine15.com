
<!-- style sheet -->
<link rel="stylesheet" type="text/css" href="css/style.css" />


<!-- check to see if logged in or not -->
    <?php if($user): ?>
        <h2>Edit <?=$user["first_name"]?>" " <?=$user["last_name"]?>'s  Profile</h2>


    <!-- if not logged in go to login screen -->
    <?php else: ?>
         <?php            Router::redirect("/users/login");  ?>
    <?php endif; ?>



    <!--form -->

    <form id="profile_form" method='POST' action='/users/p_editprofile/<?=$user["user_id"]?>'>

        <!--Add first name -->
        First Name<br>
             <input type='text' name='first_name' value='<?=$user["first_name"];?>' required>
        <br><br>

        <!--Add last name-->
        Last Name<br>
            <input type='text' name='last_name' value='<?=$user["last_name"];?>' required>
        <br><br>

        <!--Fill in the email.  Note this will change the password-->
        Email<br>
            <input type='text' name='email' value='<?=$user["email"]; ?>' required>
        <br><br>


        <!--Last is the password.  I noticed a lot of sites require you to enter this rather than fill it in-->
        <!--possibly to prevent copying-->
        Enter in your password or create a new one<br>
        <input type='password' name='password'>
        <br><br>
        
                <?php if(isset($error)): ?>
                    <div class='nav'>
                        Update failed. 
                    </div>
                    <br>
                <?php endif; ?>

        <input type='submit' value='Update Profile'>
        <br><br>
        <br><br>

    </form>