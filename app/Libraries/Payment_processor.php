<?php namespace App\Libraries;  
use \Yabacon\Paystack\Exception\ApiException;
use \Yabacon\Paystack;

class Payment_processor
{
    function __construct() 
    {
        $this->session    = \Config\Services::session();
        $this->usersModel = model('App\Models\UsersModel', false);
    }

	public function bankOption($sel = '', $type = 0, $row = null)
	{  	 
		$process = [];

        if ($this->session->has('bank_list'))
        {
            $process = $this->session->get('bank_list');
        }
        else 
        {
        	if (my_config('pref_fetch_bank_mode') === 'db' || substr(my_config('paystack_secret'), 0, 3)!=='sk_')
        	{
		        $locale = model('App\Models\LocaleModel', false);
		        $process = array(
		        	'data'   => $locale->banks(),
		        	'status' => 1
		        );  
        	}
        	else
        	{
            	$process = $this->paystackProcessor('bank')->data; 
        	}

            if ($process['status'] == 1) 
            {
                $this->session->set('bank_list', $process);
            } 
            else 
            {
            	$this->session->remove(['bank_list']); 
            }
        }

		// foreach ($process['data'] as $option) 
		// {
		// 	$locale = model('App\Models\LocaleModel', false);
  //       	$process = $locale->save_banks($option);  
		// }	

		$select = '';

        if ($type === 0) 
        { 
			if (!empty($process['data']))
			{	
				foreach ($process['data'] as $option) 
				{ 
					$selected = ($sel == $option['name'] || $sel == $option['code'] ? ' selected="selected"' : ''); 
					$select  .= '
						<option value="' . $option['code'] . '" data-type="' . $option['type'] . '"' . $selected . '>'
							. $option['name'] . 
						'</option>';
				}	
			}
			else
			{
				$select = '<option readonly selected>No bank available</option>';
			}

			return $select; 
		}
        elseif ($type === 1) 
        { 
			if (!empty($process['data']))
			{
				foreach ($process['data'] as $bank) 
				{
					if ($sel == $bank['name'] || $sel == $bank['code'])
					{
						return ($row) ? $bank[$row] : $bank;
					}
				}
			}

			$bank = ['name' => 'Invalid Bank']; 
			return ($row) ? $bank[$row] : $bank;
        }
	}  

	/**
	 * Get the name of the owner of an account number
	 * Supply [account_number [,bank_code]] parameters
	 * @param  array $data [description]
	 * @return [type]        [description]
	 */
	public function fetchAccount($data=[], $row = '')
	{
	    $process = $this->paystackProcessor('resolve_bank', $data)->data; 
	    if ($process['status'] == 1 && !empty($process['data']['account_name'])) 
	    {
	        $data['name']    = $process['data']['account_name'];  
	        $data['bank_id'] = $process['data']['bank_id']; 
	        $data['success'] = true;
	        return ($row) ? $data[$row] : $data;
	    }
	    return;
	}

	public function paystackProcessor($action = 'balance', $post_data = array()) 
	{ 
        $secret_key = my_config('paystack_secret');
         
	    $data['status'] = 0;

	   	if (substr($secret_key, 0, 3)==='sk_') 
	   	{
		    if( localhosted(my_config('offline_access')) )
		    { 
    			try {
				    try
				    {
				    	$paystack = new Paystack($secret_key); 
				        $data = array();
				        // print_r($post_data);
				        
				        if ($action == 'balance') 
				        {
				        	$response = $paystack->balance->getList();
				        	if ($response) 
				        	{
				        		// ResultSet: [currency], [balance]
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'bank') 
				        {
				        	$response = $paystack->bank->getList();
				        	if ($response) 
				        	{
				        		// ResultSet:  [account_number], [slug], [code], [longcode], [gateway], [pay_with_bank], 
				        		// [active], [is_deleted], [country], [currency], [type], [id], [createdAt], [updatedAt]
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'resolve_bank') 
				        {
				        	$response = $paystack->bank->resolve($post_data);
				        	if ($response) 
				        	{
				        		// ResultSet:  [account_number], [account_name]
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'create_recipient') 
				        {
				        	$response = $paystack->transferrecipient->create($post_data);
				        	if ($response) 
				        	{
				        		// DataSet: [type], [name], [description], [account_number], [bank_code], [currency]

				        		// ResultSet:   [active], [createdAt], [currency], [description], [domain], [email], [id],
				        		// [integration], [metadata], [name], [recipient_code], [type], [updatedAt], [is_deleted],
				        		// [details] => ( [authorization_code], [account_number], [account_name], [bank_code], [bank_name] )
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'list_recipient') 
				        {
				        	$response = $paystack->transferrecipient->getList();
				        	if ($response) 
				        	{ 
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'initiate_transfer') 
				        {
				        	$response = $paystack->transfer->initiate($post_data); 
				        	if ($response) 
				        	{
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'initiate_bulk_transfer') 
				        {
				        	$response = $paystack->transfer->initiateBulk($post_data); 
				        	if ($response) 
				        	{
				        		$data = toArray($response);
				        	}
				        }
				        elseif ($action == 'otp_state' || isset($action['otp'])) 
				        { 
				        	if (isset($action['otp'])) 
				        	{
				        		if (is_numeric($action['otp']))
				        		{
				        			$response = $paystack->transfer->finalizeTransfer($action);
				        		}
				        		else
				        		{ 
				        			$response = $paystack->transfer->resendOtp($action);
				        		}
				        	}
				        	elseif ($post_data && is_numeric($post_data))
				        	{ 
				        		$response = $paystack->transfer->disableOtpFinalize(['otp' => $post_data]);
				        	} 
				        	elseif ($post_data && $post_data == 'enable') 
				        	{
				        		$response = $paystack->transfer->enableOtp();
				        	}
				        	else
				        	{
				        		$response = $paystack->transfer->disableOtp();
				        	}

				        	if ($response) 
				        	{ 
				        		$data = toArray($response);
				        	}
				        }  
				        elseif ($action == 'verify') 
				        {
				        	$response = $paystack->transaction->verify($post_data);
				        	if ($response) 
				        	{
				        		// ResultSet:  [], []
				        		$data = toArray($response);
				        	}
				        }
				    }
				    catch(ApiException $e)
				    {
				      	$data = toArray($e->getResponseObject()); 
				    }
	    		} 
	    		catch (\ErrorException $e) 
	    		{
		        	$data['message'] = $e->getMessage();
		        	$data['status'] = 0; 
	    		}
	       	}
		    else
		   	{
		   		$data['message'] = "You have disabled Api access for local mode.";
		   	}
	    }
	    else
	   	{
	   		$data['message'] = "You have provided an Invalid Api Secret Key for Paystack transactions.";
	   	}

        $this->data = $data;

        return $this;
	}
}
