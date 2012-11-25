<?php
abstract class Controller_Template extends \Fuel\Core\Controller_Template {
	
	public function before()
	{
		// Lets render the template
		parent::before();
		$data = new stdClass;
		$data->controller = str_replace('controller_', '',strtolower($this->request->route->controller));
	
		// check to see if theres an error
		if($data->controller == 'core')
		{
		     $data->controller = 'Error | 404';
		     $title = $data->controller;
		}
		
		// default title , usually we change it within the controller
		$title = $data->controller;
		
		$this->template->title = ucwords($title);
		
		// used to select what menu we are currently on
		$data->method = strtolower($this->request->route->action);
		
		// TODO NEED TO ADD ADMIN MENU BACK IN
		//$data->current_user = Controller_Project_Brain_Members::current_user();
		//$this->template->current_user = Controller_Project_Brain_Members::current_user();
		
		$title = $data->controller.' | Luke Polo';
		
		$quotes = array(
		    'Luke Policinski',
		);
		
		$data->quote = $quotes[array_rand($quotes)];
		
		$this->template->footer = View::forge('core/footer');
		$this->template->header = View::forge('core/header',$data);
	}
}