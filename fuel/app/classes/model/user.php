<?php
class Model_User extends Orm\Model {
	
	protected static $_properties = array(
		'id',
		'username',
		'email',
		'password',
		'profile_fields',
		'group',
		'last_login',
		'login_hash',
		'created_at',
		'updated_at',
	);
		
	protected static $_has_one = array(
		'project_brain_members' => array(
			'key_from' => 'username',
			'model_to' => 'model_project_brain_members',
			'key_to' => 'alias',
			'cascade_save' => true,
			'cascade_delete' => false,
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
	);
	
	public static function validate($forge)
	{
		$val = Validation::forge($forge);
		$val->add_field('username', 'Username', 'required|max_length[255]');
		$val->add_field('email', 'Email', 'required|max_length[255]');
		return $val;
	}
	
}

/* End of file user.php */