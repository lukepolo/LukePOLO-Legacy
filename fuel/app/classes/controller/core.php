<?php
class Controller_Core extends Controller_Template
{
	public function action_index()
	{
		$this->template->content = View::forge('core/maintenance');
	}
	
	/**
	 * The 404 action for the application.
	 * 
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		$data = new stdClass;
		$message = Session::get_flash('message');
		
		if(empty($message) === true)
		{
			$messages = array('Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?');
			$data->title = $messages[array_rand($messages)].' <small>Must have slipped through my fingers!</small>';
		}
		else
		{
			$data->title = $message;
		}
		
		$this->template->content = View::forge('core/404',$data);
	}
}
