<?php namespace App\Controllers\Ajax;

use App\Controllers\BaseController;  
use App\Libraries\Payment_processor;  
use Stripe\Stripe;

class Payments extends BaseController
{
	public function index()
	{
		return view('welcome');
	}

	public function wallet()
	{ 
	    $duration = $this->request->getPost('duration');
	    $get_hub  = $this->hubs_m->get_hub(['id' => $this->request->getPost('id')]); 
	    $price    = $get_hub['price']*$duration;

	    if (logged_user("wallet") >= $price) 
	    {
			// remove this payment amount from wallet
			$this->usersModel->where('uid', user_id())->decrement('wallet', $price);
			return $this->process();
	    }
	}

	public function stripe($action = "payment_intents")
	{ 
    	Stripe::setApiKey(my_config('stripe_secret'));

	    $data['success']  = false;
	    $data['status']   = 'error';
	    $data['message']  = _lang('an_error_occurred'); 
	    $data['currency'] = my_config('stripe_currency', NULL, "USD"); 
		
		$post_data = $this->request->getPost();

	    if ($action === "payment_intents") 
	    {
	    	try 
	    	{
			  	$data = \Stripe\PaymentIntent::create([
			    	"amount" => $this->calculateOrderAmount($post_data["items"], 'stripe'),
			    	"currency" => $data['currency'],
			  	]);   
	    	} 
	    	catch (\Stripe\Exception\AuthenticationException $e) 
	    	{
	    		$data['message'] = toArray($e->getMessage()); 
	    	}
	    }
	    elseif ($action === "public-key") 
	    {
		    $data['success']  = true;
		    $data['status']   = 'success';
	    	$data['publicKey'] = my_config('stripe_public');  
	    }
	    elseif ($action === "success") 
	    {
	    	if ($post_data['data']['status'] === "succeeded") 
	    	{
				$this->recordPayment($this->request->getPost(), $post_data['data']['id'], "stripe");
	    		return $this->process(); 
	    	} 
	    }

        return $this->response->setJSON($data);
	}

	public function paystack($ref = "")
	{
		$processor = new Payment_processor;
		$verify    = $processor->paystackProcessor('verify', ['reference' => $ref])->data;

	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred'); 

		if ($verify['status'] == 1 && $verify['data']['status'] === 'success') 
		{
			$this->recordPayment($this->request->getPost(), $verify['data']['reference'], "paystack");
			return $this->process();
		}
		else
		{
			$data['message'] = $verify['message']; 
		}

        return $this->response->setJSON($data);
	}

	private function calculateOrderAmount($items, $proccessor = '', $skip = false)
	{ 
		$price = 0;


        $proccessor = (!empty($proccessor) && !in_array($proccessor, ['paystack'])) ? $proccessor : 'site'; 

	    if (isset($items['id']) && isset($items['type'])) 
	    { 
	    	if ($items['type'] === 'hub') 
	    	{
		    	$get_hub = $this->hubs_m->get_hub(['id' => $items['id']]); 
		    	$price   = $get_hub['price']*$items['duration'];
	    	}
	    }
        if (my_config('site_currency', NULL, "USD") !== my_config($proccessor . '_currency', NULL, "USD") && $skip === false) 
        {
            $price /= my_config($proccessor . '_currency_rate', NULL, "5.00");
        } 
	    return $price;
	}

	private function recordPayment($items, $reference = null, $method = null)
	{  
		$this->bookings_m->record_payment([
			"uid" => user_id(), 
			"amount" => $this->calculateOrderAmount($items, $method), 
			"reference" => $reference??rand(),
			"method" => $method,
			"description" => $this->orderDescription($items), 
			"date" => time()
		]);
	}

	private function orderDescription($items, $description = '')
	{ 
	    if (isset($items['id']) && isset($items['type'])) 
	    {
	    	if ($items['type'] === 'hub')
	    	{
		    	$get_hub  = $this->hubs_m->get_hub(['id' => $items['id']]); 
	    		$duration = ($get_hub['duration']*$items['duration'])/$get_hub['duration'];
		    	$description = "Booking payment for " . (($get_hub['name']??'') . " " . ($get_hub['hub_no']??''))??'hub' . " for " . $duration . " days.";
	    	}
	    }
	    return $description;
	}

	private function process($response = [])
	{	   
	    $data['success'] = false;
	    $data['status']  = 'error';
	    $data['message'] = _lang('an_error_occurred'); 

	    $item_id  = $this->request->getPost('id');
	    $type     = $this->request->getPost('type');
	    $from     = $this->request->getPost('checkin');
	    $duration = $this->request->getPost('duration');

	    if ($item_id && $type === 'hub') 
	    {
	   		$get_hub  = $this->hubs_m->get_hub(['id' => $item_id]);
	    	$price    = $this->calculateOrderAmount($this->request->getPost());
	    	$duration = $get_hub['duration']*$duration;
			$checkout_date = strtotime("$from + $duration Hours");
			$to            = date('Y-m-d H:i:s', $checkout_date);

			$hub  = $this->bookings_m->check(['rand' => true, 'status' => 1, 'hub_type' => $item_id, 'from' => $from, 'to' => $to]);
			if ($hub)
			{
				$book = $this->bookings_m->book([
					'uid' => user_id(), 'hub_id' => $hub['id'], 'checkin_date' => strtotime($from), 'checkout_date' => $checkout_date,
					'duration' => $duration, 'amount' => $price, 'status' => 1
				]);
				
				if ($book) 
				{ 
				    $data['success']  = true;
				    $data['status']   = 'success';
		    		$data['redirect'] = site_url("user/payments/success/?type=$type&id=$book");
	    			$data['message']  = _lang('hub_reserved_successfully'); 
	                if (my_config('sms_notify')) 
	                {
						\Config\Services::mailjet_sms(my_config('mailjet_bearer_token'), [
		                	"{$data['message']}\n$data['redirect']",
		                	phone_number(logged_user('phone_number'), logged_user('phone_code')),
		                	my_config('site_name')
		                ]);
	                }
				}
			}
			else
			{
				// add this payment amount to wallet so user can book again without paying
				$this->usersModel->where('uid', user_id())->increment('wallet', $price);
	    		$data['message'] = _lang('hub_no_longer_available', [money($price)]);
			}
	    }

        return $this->response->setJSON($data);
	} 
}
