<?php
class Controller_Resume extends Controller_Template
{
	public function action_index()
	{
		$this->template->content = View::forge('resume/index');
	}
}
