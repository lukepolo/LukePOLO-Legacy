<?php
class Controller_Contact extends Controller_Template
{
	public function action_index()
	{
		$this->template->content = View::forge('contact/index');
	}
}
