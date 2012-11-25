<?php
class Controller_Blog extends Controller_Template
{
	public function action_index()
	{
		$this->template->content = View::forge('blogs/index.php');
	}
}
