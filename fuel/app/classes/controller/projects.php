<?php
class Controller_Projects extends Controller_Template
{
	public function action_index()
	{
		$this->template->content = View::forge('projects/index');
		$this->template->content_below = View::forge('projects/index_below');
	}
}
