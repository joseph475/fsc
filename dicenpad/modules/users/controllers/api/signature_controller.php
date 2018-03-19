<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signature_controller extends PTGI_rest_controller
{    
    function __construct()
    {
        parent::__construct();

        $this->load->library('user/signature');
    }

    function signature_get()
    {
        $id   = $this->get('id');   
        
        $cache = Cache::get_instance();
        $signature = $cache::get('signature' . $id);

        if (!$signature) {            
            $signature = new Signature($id);   
            $signature->load($id, 'user_id');           
            $cache::save('signature' . $signature->user_id, $signature, 1800);
        }
        
        $response = $signature->getData();   
        
        $this->response($response);
    }

    // --------------------------------------------------------------------
    
    /**
     * Creates a user's signature entries.
     * 
     * @return xml
     */
    function signature_post()
    {        
        $signature = new Signature();

        $this->response($this->_signature_save($signature, 'post'));
    }  

    // --------------------------------------------------------------------
    
    /**
     * Updates an signature entry.
     * 
     * @return xml
     */
    function signature_put()
    {        
        $signature = new Signature($this->get_user()->user_id);

        $this->response($this->_signature_save($signature, 'put'));
    }     

    private function _signature_save($signature, $mode)
    {
        $delete_photo = FALSE;

        $response = array('status' => 'failed', 'message' => '');

        $signature->user_id  = $this->get_user()->user_id;
        if($this->{$mode}('poea1')) $signature->poea1 = $this->{$mode}('poea1');
        if($this->{$mode}('poea2')) $signature->poea2 = $this->{$mode}('poea2');
        if($this->{$mode}('expire_doc')) $signature->expire_doc = $this->{$mode}('expire_doc');
        if($this->{$mode}('check1')) $signature->check1 = $this->{$mode}('check1');
        if($this->{$mode}('check2')) $signature->check2 = $this->{$mode}('check2');
        if($this->{$mode}('company')) $signature->company = $this->{$mode}('company');
        
        $id = $signature->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';
        } else {
            $response['message'] = $signature->get_validation_errors();
        }

        return $response;
    }
}