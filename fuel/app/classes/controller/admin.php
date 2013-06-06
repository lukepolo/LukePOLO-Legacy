<?php
class Controller_Admin extends Controller_Template {
    
    public function action_index()
    {
        if(Auth::check())
        {
            Response::redirect(Uri::base());
	    
        }
        else
        {
        	$data = array();
            
	        if (Input::post())
	        {
	            // first of all, let's get a auth object
	            $auth = Auth::instance();
	            
	            // Check to see if they had a valid username / password
	            if(Auth::validate_user(Input::post('username'),Input::post('password')) && $auth->login())
	            {
					if(isset($_SERVER['HTTP_REFERER']))
					{
						Response::redirect($_SERVER['HTTP_REFERER']);
					}
					else
					{
						Response::redirect(Uri::base());
					}
	            }
	            else
	            {
	                // failed
	                $data['username'] = Input::post('username');
	                $data['login_error'] = 'Wrong username/password combo. Try again';
	            }           
	        }
		
	        // Show the login form
	        $this->template->content = View::forge('admin/index',$data);
        }
    }
    
    public function action_logout()
    {
        if(Auth::check())
        {
            Session::set_flash('success','Successfully logged out!');
            Auth::logout();
        }
        else
        {
            Session::set_flash('error','You were never logged in! Sneaky sneaky are we?!');
        }
        
		if(isset($_SERVER['HTTP_REFERER']))
		{
			Response::redirect($_SERVER['HTTP_REFERER']);
		}
		else
		{
			Response::redirect(Uri::base());
		}
    }
}