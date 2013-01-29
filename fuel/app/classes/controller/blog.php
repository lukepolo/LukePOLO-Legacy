<?php
class Controller_Blog extends Controller_Template
{
	public function action_index()
	{
		$data['blogs'] = Model_Blog::find()
			->order_by('created_at','desc')
			->get();
		
		$this->template->content = View::forge('blogs/index',$data);
	}
	
	public function action_create()
	{
		// make sure they are logged in
		if(Auth::check() === true)
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
		else
		{
			Session::set_flash('message','You should\'nt snoop, its not nice!');
			Response::redirect(Uri::base().'_404');
		}
	}
	
	public function action_edit($id)
	{
		$data = new stdClass;
		// make sure they are logged in
		if(Auth::check() === true)
		{
			$data->blog = Model_Blog::find()
				->where('id',$id)
				->get_one();
				
			if(Input::method() == "POST")
			{
				$data->blog->text = Input::post('text');
				$data->blog->title = Input::post('title');
				$data->blog->sub_title = Input::post('sub_title');
				$data->blog->slug = Input::post('slug');
				
				if($data->blog->save())
				{
					Response::redirect(Uri::base().'blog');
				}
				else
				{
					echo 'uh o error!';
				}
			}
			else
			{
				$this->template->content = View::forge('blogs/form',$data);
				
			}
		}
		else
		{
			Session::set_flash('message','You should\'nt snoop, its not nice!');
			Response::redirect(Uri::base().'_404');
		}
	}
}
