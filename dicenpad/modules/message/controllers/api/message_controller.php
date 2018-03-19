<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message_controller extends HDI_rest_controller
{
	function __construct()
	{
		parent::__construct();		
        $this->load->library('Message');
	}

	// --------------------------------------------------------------------

	/**
	 * Get a message with ID of
	 * 
	 * @return mixed
	 */
    public function message_get()
    {
        $this->response($this->get('id'));
    }

    // --------------------------------------------------------------------
    
    /**
     * Add a new message via the API
     */
    public function message_post()
    {
    	$data = array();

    	$data['user_id'] = $this->get_user()->user_id;
    	$data['message'] = $this->post('message');
    	$data['recipient_id'] = $this->post('recipient_id');

    	$message = new Message($data);
    	$response = array();

    	if (!$message->save()) {
			$response['message'] = $message->get_validation_errors();
            $this->response($response, 400);
		} else {
			$response['id']       = $message->id;
            $response['resource'] = site_url('api/message/id/' . $message->id);
            $this->response($response, 201);
        }

    }
}