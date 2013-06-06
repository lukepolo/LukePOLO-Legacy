<?php

class Controller_Ajax extends Controller_Template {
	public $template = 'core/ajax_template';
		
	public function action_email()
	{
		$session = Session::get(ip2long(Input::real_ip()));
		
		if(Input::method() === "POST" && empty($session) === true)
		{
			$return_array = array();
			
			\Package::load('email');
			
			$name = ucwords(Input::post('name'));
			$email_address = Input::post('email');
			$message = Input::post('message');
			
			
			// Create an instance
			$email = Email::forge();
			
			if(empty($email_address) === true)
			{
				$email_address = $name;
			}
			// Set the from address
			$email->from($email_address, $name);
			
			// Set the to address
			$email->to('Luke@LukePOLO.com', 'Luke Policinski');
			
			// Set a subject
			$email->subject('Contact Form From '.$name);
			
			// Set multiple to addresses
			
			$email->to('Luke@LukePOLO.com');
			
			// And set the body.
			$email->htmL_body($message);
			
			if($email->send())
			{
				Session::set(ip2long(Input::real_ip()), true);
				
				$return_array['message'] = 'Thank you for emailng me!';
			}
			else
			{
				// THERE HAS BEEN AN ERROR
				$return_array['error'] = 'Not sure what happend! Email me (not using this contact form) so I can fix this!';
			}
		}
		else
		{
			if(empty($session) === true)
			{
				$return_array['error'] = 'Not sure what happend! Email me (not using this contact form) so I can fix this!';
			}
			else
			{
				$return_array['error'] = 'You already emailed me! Use a differn\'t method!';
			}
		}
		echo json_encode($return_array);
		return false;
	}
}

