
<?php
class users_controller extends base_controller {

	 public function __construct() {
		parent::__construct();
			//echo "users_controller construction called<br><br>";
		
	
	#Setup CSS and JS and setup the view
		$client_files_head = Array (
			'../css/style.css'
			);
			
		$this->template->client_files_head = Utils::load_client_files($client_files_head);
		
	#Setup CSS and JS in body and setup the view
		$client_files_body = Array (
			'../css/style.css'
			);
			
		$this->template->client_files_body = Utils::load_client_files($client_files_body); 
		}
	
	
	
	public function index() {
		echo "This is the index page";
		}
		
		
	#Signup function
		public function signup() {
		
		#Setup view for signup
		$this->template->content = View::instance('v_users_signup');
		$this->template->title   ="Sign up";
		
		#Render template
			echo $this->template;
	}
		
		
	public function p_signup() {
	
		# Dump out the results of POST to see what the form submitted
		//print_r($_POST);
		
			$this->template->content = View::instance('v_users_signup');
            $this->template->title = "Sign up";
		
		
		#Boolean check variable.  Always set it to a default value of false
		$error = false;
		$this->template->content->error = '<br>';
		
	    $_POST = DB::instance(DB_NAME)->sanitize($_POST);
        $existing = DB::instance(DB_NAME)->select_field("SELECT email FROM users WHERE email = '" . $_POST['email'] . "'");

		if (isset($existing)) {
               $error = true;
               echo 'The email address already exists.  Please use another address.';
	
		//  echo $this->template;   	
			 }

		 else {
	
			# More data we want stored with the user
			$_POST['created']	= Time::now();
			$_POST['modified']	= Time::now();
			
			#Encrypt the password
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);
			
			#Create an encrypted token via their email address and a random string
			#Token is from database
			$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 
			
			# Insert this user into the database
			$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

		
		/*	#Setup email address after signing up
		            $to =  $_POST['email'];
					$from = 'khurst@sendgrid.net';
                    $subject = "Thank you for signing up with Squirrel";
                    $body = "Enjoy!";
                      
			
			mail($to, $from, $subject, $body, true);
			}
		
			Router::redirect('/users/login');
	*/
			
		# For now, just confirm they've signed up - 
		# You should eventually make a proper View for this
		echo 'You\'re signed up';

	Router::redirect('/users/login');
	
		#Dump out the results of the POST to see what the form submitted
		#As a reminder, the <pre> markup is used to preserve the format of the output
		#As a reminder, the print_r() displays information about a variable in a way that is readable
		#by humans. Array values will be presented in a format that displays keys and elements. key=>element
		
		
		#echo '<pre>';
		#print_r($_POST);
		#echo '</pre>';
		}

	}


		
	public function login($error = NULL) {

		# Set up the view
		$this->template->content = View::instance("v_users_login");

		# Pass data to the view
		$this->template->content->error = $error;

		# Render the view
		echo $this->template;

}
	
	public function logout() {
		
			 # Generate and save a new token for next login
			$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

			# Create the data array we'll use with the update method
			# In this case, we're only updating one field, so our array only has one entry
			$data = Array("token" => $new_token);

			# Do the update
			DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

			# Delete their token cookie by setting it to a date in the past - effectively logging them out
			setcookie("token", "", strtotime('-1 year'), '/');

			# Send them back to the main index.
			Router::redirect("/");

		} #oef logout
		
		//Please ignore.  This is all new to me so I'm attempting to create new functions and
		//views in order to understand them better, rather than feel like I'm just following
		//instructions without knowing what is going on.
		
		
		public function test() {
		
			$this->template->content = View::instance('v_users_test');
			echo $this->template;
			}

		public function profile() {

			# If user is blank, they're not logged in; redirect them to the login page
			if(!$this->user) {
				//Router::redirect('/users/login');
				die('This is for members only.  Please sign up to access the information. <a href="users/signup">Signup</a>');
			}

			# If they were not redirected away, continue:

			# Setup view
			$this->template->content = View::instance('v_users_profile');
			$this->template->title   = "Profile of ".$this->user->first_name;

			# Render template
			echo $this->template;
	} #eof profile
	


	
		public function p_login() {

			# Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

			# Hash submitted password so we can compare it against one in the db
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

			# Search the db for this email and password
			# Retrieve the token if it's available
			$q = "SELECT token 
				FROM users 
				WHERE email = '".$_POST['email']."' 
				AND password = '".$_POST['password']."'";

			$token = DB::instance(DB_NAME)->select_field($q);

			# If we didn't find a matching token in the database, it means login failed
			if(!$token) {

				# Send them back to the login page
				Router::redirect("/users/login/error");

			# But if we did, login succeeded! 
			} 
			
			else {

				/* 
				Store this token in a cookie using setcookie()
				Important Note: *Nothing* else can echo to the page before setcookie is called
				Not even one single white space.
				param 1 = name of the cookie
				param 2 = the value of the cookie
				param 3 = when to expire
				param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
				*/
				setcookie("token", $token, strtotime('+1 year'), '/');

				# Send them to the main page - or wherever you want them to go
				Router::redirect("/");

				}

			}
			
			
			
		public function editprofile() {
        
             if(!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
			}
        
            #Set up the view
            $this->template->content = View::instance('v_users_editprofile');
            $this->template->title = "Edit Profile";
            
            # Prepare the data array to be inserted
            $data = Array(
                "first_name" => $this->user->first_name,
                "last_name"	 => $this->user->last_name,
                "email" 	 => $this->user->email,
                "password"	 => $this->user->password,
                "user_id"	 => $this->user->user_id
                );
            
            #Pass the data to the View
            $this->template->content->user = $data;
            
            #Display the view
            echo $this->template;
        }
        
        public function p_editprofile($id) {
        
			#check to see if logged in
            if(!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
			}
        
            # Set up the View
            $this->template->content = View::instance('v_users_p_editprofile');
            
            $q = 'SELECT password 
                    FROM users
                    WHERE user_id = '.$id;
                    
            $current_password = DB::instance(DB_NAME)->query($q);    
           
            if ($_POST['password'] != ''){
            
                    # Encrypt the password (with salt)
                    $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);   
            } 
                  
            # Change the modified time  
            $_POST['modified'] = Time::now();
            
			
			# update DB with info
            
			$_POST['user_id']  = $this->user->user_id;  
            $where_condition = 'WHERE user_id = '.$id;    
            $updated_post = DB::instance(DB_NAME)->update('users', $_POST, $where_condition);
                 
            #go gack to the login page
            Router::redirect("/users/profile");
                }
	
	
}  # end of the class
	

	

	