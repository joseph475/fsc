<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Crew_photo_controller extends PTGI_rest_controller
{    
	function __construct()
	{
		parent::__construct();

        $this->load->library('crew');
	}

    // --------------------------------------------------------------------
    
    /**
     * Returns photo URL of crew.     
     */
    public function crew_photo_get()
    {        
        if (($id = $this->get('id')) == FALSE) {
            $id = $this->get_user()->user_id;            
        }

        $crew = new Crew($id);    

        if ($this->get('thumbnail') == TRUE) {
            $url = $crew->getPhotoUrl(1);
        } else {
            $url = $crew->getPhotoUrl(2);
        }         

        $response = array('url' => $url);

        $this->response($response, 200, 'html');
    }
}