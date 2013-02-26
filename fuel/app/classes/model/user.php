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
		
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
	);
}

/* End of file user.php */
