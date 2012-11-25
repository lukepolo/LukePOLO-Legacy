<?php
if(Input::server('HTTP_HOST') == 'boilerprojects.com')
{
	return array(
		'_root_'  => 'project/brain/home',  // The default route
		'_404_'   => 'core/404',    // The main 404 route
		
		'logout' => 'admin/logout',
		'login' => 'project/login',
		
		'my_projects' =>'project/brain',
		'projects' =>'project/brain',
		
		'project/edit/(:any)' =>'project/brain/edit/$1',
		'project/create' =>'project/brain/create',
		
		'my_profile' =>'project/brain/members/my_profile',
		'my_settings' =>'project/brain/members/my_settings',
		
		'sign_up' =>'project/brain/members/register',
		'register' =>'project/brain/members/register',
		
		'organization/create' => 'project/brain/organizations/create',
		
		// Redirect to an organization
		'org/(:any)' =>'project/brain/organizations/view/$1',
		'(:any)' => 'project_brain/$1',
	);
}
else
{
	return array(
		'_root_'  => 'projects',  // The default route
		'_404_'   => 'core/404',    // The main 404 route
	        'logout' => 'admin/logout'
	);
}