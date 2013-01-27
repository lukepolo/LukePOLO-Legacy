<?php
class Controller_Blog extends Controller_Template
{
	public function action_index()
	{
		$data['blogs'] = Model_Blog::find('all');
		
		$this->template->content = View::forge('blogs/index',$data);
	}
	
	public function action_create()
	{
		if(Input::method() == "POST")
		{
			$blog = Model_Blog::forge(array(
				'text' => Input::post('text'),
				'title' => Input::post('title'),
				'sub_title' => Input::post('sub_title'),
				'slug' => Input::post('slug')
			));
			
			if($blog && $blog->save())
			{
				Response::redirect(Uri::base().'blog');
			}
			else
			{
				// NEED TO ADD ERROR CHECKING
				echo 'ERROR';die;
			}
		}
		
		$this->template->content = View::forge('blogs/form');
	}
	
	public function action_edit()
	{

	}
}
