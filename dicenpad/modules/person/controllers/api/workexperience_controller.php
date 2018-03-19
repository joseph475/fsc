<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Workexperience_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('WorkExperience');
	}

    public function work_get()
    {
        $this->response($this->get('id'));
    }
}