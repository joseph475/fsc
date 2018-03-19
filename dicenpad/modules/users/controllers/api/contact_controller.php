<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Contact_controller extends PTGI_rest_controller
{    
	function __construct()
	{
		parent::__construct();

        $this->load->library('user/contact');
	}

    // --------------------------------------------------------------------
    
    /**
     * Get a user's contact entries.
     * 
     * @return xml
     */
    function contact_get()
    {
        $this->load->model('contact_model');
        $contacts = $this->contact_model->get_by_user($this->get('user_id'));
        
        $this->response($contacts);
    }

    // --------------------------------------------------------------------
    
    /**
     * Creates a user's contact entries.
     * 
     * @return xml
     */
    function contact_post()
    {        
        $contact = new Contact();

        $this->response($this->_contact_save($contact, 'post'));
    }  

    // --------------------------------------------------------------------
    
    /**
     * Updates an contact entry.
     * 
     * @return xml
     */
    function contact_put()
    {        
        $contact = new Contact($this->put('id'));

        $this->response($this->_contact_save($contact, 'put'));
    }     

    private function _contact_save($contact, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $contact->user_id      = $this->get_user()->user_id;
        $contact->contact_type = $this->{$mode}('contact_type');
        $contact->mobile       = $this->{$mode}('mobile');
        $contact->contact      = $this->{$mode}('contact');
        $contact->im_tag       = $this->{$mode}('im_tag');
        $contact->is_primary   = $this->{$mode}('is_primary');
        
        $id = $contact->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';            
        } else {
            $response['message'] = $contact->get_validation_errors();
        }

        return $response;
    }
}