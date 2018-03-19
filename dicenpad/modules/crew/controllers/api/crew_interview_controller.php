<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_interview_controller extends PTGI_rest_controller
{    
	function __construct()
	{
		parent::__construct();

        $this->load->library('crew/interview');
	}

    // --------------------------------------------------------------------
    
    /**
     * Creates a user's about entries.
     * 
     * @return xml
     */
    function interview_post()
    {        
        $interview = new About();

        $this->response($this->_interview_save($interview, 'post'));
    }  

    // --------------------------------------------------------------------
    
    /**
     * Updates an interview entry.
     * 
     * @return xml
     */
    function interview_put()
    {        
        $interview = new Interview($this->put('id'));

        $this->response($this->_interview_save($interview, 'put'));
    }     

    private function _interview_save($interview, $mode)
    {
        $response = array('status' => 'failed', 'message' => '');

        $interview->crew_id         = $this->{$mode}('crew_id');
        $interview->position_id     = $this->{$mode}('intposition_id');
        $interview->vessel_id       = $this->{$mode}('intvessel_id');
        $interview->tentative_sched = $this->{$mode}('tentative_sched');
        $interview->age             = $this->{$mode}('age');
        $interview->vesseltype      = $this->{$mode}('vesseltype');
        $interview->prevkindvessel  = $this->{$mode}('prevkindvessel');
        $interview->prevkindengine  = $this->{$mode}('prevkindengine');
        $interview->prevkindcargo   = $this->{$mode}('prevkindcargo');
        $interview->prevtraderoute  = $this->{$mode}('prevtraderoute');
        $interview->prevsalary      = $this->{$mode}('prevsalary');
        $interview->prevforeignexp  = $this->{$mode}('prevforeignexp');
        $interview->recommendation  = $this->{$mode}('recommendation');
        $interview->goodforvessel   = $this->{$mode}('goodforvessel');
        $interview->interviewby     = $this->{$mode}('interviewby');
        $interview->checkedby       = $this->{$mode}('checkedby');
        $interview->approvedby      = $this->{$mode}('approvedby');
        $interview->datecreated     = date('m/d/Y');

        $interview->evalgrade1      = $this->{$mode}('evalgrade1');
        $interview->evalgrade2      = $this->{$mode}('evalgrade2');
        $interview->evalgrade3      = $this->{$mode}('evalgrade3');
        $interview->evalgrade4      = $this->{$mode}('evalgrade4');
        $interview->evalgrade5      = $this->{$mode}('evalgrade5');
        $interview->evalgrade6a     = $this->{$mode}('evalgrade6a');
        $interview->evalgrade6b     = $this->{$mode}('evalgrade6b');
        $interview->evalgrade6c     = $this->{$mode}('evalgrade6c');
        $interview->evalgrade6d     = $this->{$mode}('evalgrade6d');
        $interview->evalgrade6e     = $this->{$mode}('evalgrade6e');
        $interview->evalgrade7a     = $this->{$mode}('evalgrade7a');
        $interview->evalgrade7b     = $this->{$mode}('evalgrade7b');
        $interview->evalremark1     = $this->{$mode}('evalremark1');
        $interview->evalremark2     = $this->{$mode}('evalremark2');
        $interview->evalremark3     = $this->{$mode}('evalremark3');
        $interview->evalremark4     = $this->{$mode}('evalremark4');
        $interview->evalremark5     = $this->{$mode}('evalremark5');
        $interview->evalremark6     = $this->{$mode}('evalremark6');
        
        $id = $interview->save();

        if ($id) {
            $response['id'] = $id;
            $response['status']  = 'success';
        } else {
            $response['message'] = $interview->get_validation_errors();
        }

        return $response;
    }
}