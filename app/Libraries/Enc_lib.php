<?php namespace App\Libraries; 
 
class Enc_lib {

    public $pub_key = 'ss@pubkey';
    public $pvt_key = 'ss@pvtkey';

    function encrypt($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $this->pvt_key);
        $iv = substr(hash('sha256', $this->pub_key), 0, 16);
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
        return $output;
    }

    function dycrypt($string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $key = hash('sha256', $this->pvt_key);
        $iv = substr(hash('sha256', $this->pub_key), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        return $output;
    }

    function passHashEnc($password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        return $hashed_password;
    }

    function passHashDyc($password, $encrypt_password) {
        $isPasswordCorrect = password_verify($password, $encrypt_password);
        return $isPasswordCorrect;
    }
    
    public function get_random_password($chars_min = 6, $chars_max = 8, $use_upper_case = false, $use_lower_case = false, $include_numbers = false, $include_special_chars = false) 
    {
        $length = rand($chars_min, $chars_max);
        $selection   = 'aeuoyibcdfghjklmnpqrstvwxz';

        if ($use_upper_case) 
        {
            if ($use_lower_case) 
            {
                $selection = $selection;
            } 
            else 
            {
                $selection = 'AEUOYIBCDFGHJKLMNPQRSTVZXZ';
            }
        }

        if ($include_numbers) {
            $selection .= "1234567890";
        }
        if ($include_special_chars) {
            $selection .= "!@\"#$%&[]{}?|";
        }

        $password = "";
        for ($i = 0; $i < $length; $i++) {
            $current_letter = $use_upper_case ? (rand(0, 1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];
            $password .= $current_letter;
        }
        return $password;
    }

    /**
    /*  Generate a random token (MD5 or password_hash)
    **/
    function generateToken($length = 10, $type = 0, $prefix = '', $appendix = FALSE)
    {
        $str = ''; 
        $characters = array_merge(range('A','Z'), range('a','z'), range(0,9));
 
        for($i=0; $i < $length; $i++) 
        {
            $str .= $characters[array_rand($characters)];
        }
        if ($type == 1) 
        {   
            $rand_number = '';
            if ($appendix === TRUE) 
            {
                $length = ($length/2);
                $rand_number = substr(rand(10000,90000).rand(10000,90000).rand(10000,90000).rand(10000,90000), 0, $length);
            }

            $rand_letter = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
            $rand_sm = substr(str_shuffle("DEFGHOPQRSTUVWXYZ"), 0, 3);
            return $prefix.$rand_letter.$rand_number.'-'.$rand_sm;
        } 
        elseif ($type == 2) 
        {
            return hash('md5', $str.time());
        } 
        else 
        {
            return password_hash($str.time(), PASSWORD_DEFAULT);
        }
    }    

}
