<?php namespace App\Libraries; 

class Custom_rules
{
	public function validate_login(string $str, string $fields, array $data, string &$error = null): bool
	{
		$usersModel = model('App\Models\UsersModel', false);
        $enc_lib    = new \App\Libraries\Enc_lib;
        helper('ponzi_helper');
 

		if (empty($data['username'])) 
		{
			$fetch_user = $usersModel->get_user(user_id());
		}
		else
		{
			$fetch_user = $usersModel->user_by_username($data['username']);
		}

		$fields = explode('.', $fields);

		if ($fields[0] == 'username') 
		{
		    if (!$fetch_user)
		    {
		        $error = lang('Validation_.validate_login');
		        $error = str_ireplace('{field}', $fields[1], $error);
		        return false;
		    }
		} 
		elseif ($fields[0] == 'password') 
		{
		    if ($fetch_user && $enc_lib->passHashDyc($str, $fetch_user['password']))
		    {
	        	return true;
		    }

	        $error = lang('Validation_.validate_password');
	        $error = str_ireplace('{field}', $fields[1], $error);
	        return false;
		}

	    return true;
	}

	public function strong_password(string $password, string &$error = null): bool
	{
 		$pass_regex = "/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])(?=.*[a-z])(?=.*[ !#$%@&\"%'\(\) * +,-.\/[\\] ^ _`{|}~\"])[0-9A-Za-z !#$%&@\"%'\(\) * +,-.\/[\\] ^ _`{|}~\"]{8,}$/"; 

 		if (strlen($password) < 8) 
 		{
 			$error = lang('Validation_.min_length'); 
		    $error = str_ireplace('{field}', 'Password', $error);
		    $error = str_ireplace('{param}', '8', $error);
	        return false;
 		}
 		elseif (!preg_match($pass_regex, $password)) 
 		{
	        $error = lang('Validation_.strong_password'); 
	        return false;
 		}

	    return true;
	}
}
