<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Replacement_plan_controller extends Front_Controller
{
	private $class = 'SCHEDULE';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}
   
	public function replacement_plan() 
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$replacement_plan = new stdClass();
		$replacement_plan->clssnme 				= $this->class;
		$replacement_plan->thumbnail_url 		= $profile->thumbnail_url;
		$replacement_plan->first_name 			= $profile->first_name;
		$replacement_plan->last_name 			= $profile->last_name;
		$replacement_plan->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/replacement_plan/list/model.js');
		add_js('modules/replacement_plan/list/directory_view.js');
		add_js('modules/replacement_plan/list/options_view.js');
		add_js('modules/replacement_plan/list/paginated_view.js');
		add_js('modules/replacement_plan/list/paginated_collection.js');
		add_js('modules/replacement_plan/list/router.js');
		
		$this->layout->view('replacement_plan/list', $replacement_plan);
	}
}