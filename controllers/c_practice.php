
<?php
class practice_controller extends base_controller {

	public function test_db() {
	
	/*
	# Our SQL command
	  $q = 'INSERT INTO users SET 
		first_name = "Sam", 
		last_name = "Seaborn"';

	  $q = 'UPDATE users
	  SET email = "albert@aol.com"
	  WHERE first_name = "Sam"';
		
	echo $q;
	#  Run the command
		DB::instance(DB_NAME)->query($q);
		}#eof
	*/
	
	$new_user = Array(
		'first_name' => 'Albert',
		'last_name' => 'Einstein',
		'email' => 'albert@gmail.com',
		);
	
	DB::instance(DB_NAME)->insert('users',$new_user);
	
	} #eof
} #eoc