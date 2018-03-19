<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signatory_controller extends PTGI_rest_controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->model('signatory_model', 'model');
        $this->load->library('signatory');
	}

	/**
     * Returns Vessels when called via get
     *
     * @param data array Key-Field pair of values to filter.
     *          
     * @return xml
     */
	function signatorys_get()
	{
        $search   = array();
        $response = FALSE;        
        
        $cache = Cache::get_instance();
        $response = $cache::get('signatory' . serialize($this->_args));

        if (!$response) {
            $response['_count'] = $this->model->count_results($this->_args);

            if ($response['_count'] > 0)
            {
                $response['data'] = $this->model->fetch($this->_args, TRUE)->result();
            }                 
            $response['l'] = $this->db->last_query();          
            //$cache::save('options' . serialize($this->_args), $response);
        }

        $this->response($response);
	}

    /**
    * Delete a record.
    * 
    */
    function signatory_delete()
    {   
        // Get signatory to determine if user is allowed to delete.
        $signatory = new Signatory($this->get('id'));

        if (!$signatory->hasData()) {
            // Throw a 404 if this signatory does not exist.
            $this->response(FALSE);
        } else {
            if ($signatory->delete()) {
                $this->response(TRUE);
            } else {
                $this->response(array($signatory->get_validation_errors()));
            }
        }
    }

    // --------------------------------------------------------------------
    /**
     * Post an options entry.
     * 
     * @return xml
     */
    function signatory_post()
    {        
        $signatory = new Signatory();

        $signatory->date_created    = date('Y-m-d H:i:s');
        $signatory->createdbypk     = $this->get_user()->user_id;
        $signatory->date_modified   = date('Y-m-d H:i:s');
        $signatory->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_signatory_save($signatory, 'post'));
    } 

    /**
     * Updates an signatory entry.
     * 
     * @return xml
     */
    function signatory_put()
    {        
        $signatory = new Signatory($this->put('id'));

        $signatory->date_modified   = date('Y-m-d H:i:s');
        $signatory->modifiedbypk    = $this->get_user()->user_id;

        $this->response($this->_signatory_save($signatory, 'put'));
    }  

    // --------------------------------------------------------------------   

    private function _signatory_save($signatory, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');
        $signatory->firstname           = $this->{$mode}('firstname');
        $signatory->lastname            = $this->{$mode}('lastname');
        $signatory->middlename          = $this->{$mode}('middlename');
        $signatory->admin_position_id   = $this->{$mode}('admin_position_id');
        $signatory->form_id             = $this->{$mode}('form_id');
        $signatory->published           = $this->{$mode}('published');
        $signatory->salutation          = $this->{$mode}('salutation');
        
        $id = $signatory->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $signatory->get_validation_errors();
        }

        return $response;
    }
}