<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Photo_controller extends PTGI_rest_controller
{    
	function __construct()
	{
		parent::__construct();

        $this->load->library('crew');
	}

    // --------------------------------------------------------------------
    
    /**
     * Returns photo URL of user.     
     */
    public function photo_get()
    {        
        if (($id = $this->get('id')) == FALSE) {
            $id = $this->get_user()->crew_id;            
        }

        $crew = new Crew($id);    

        if ($this->get('thumbnail') == TRUE) {
            $url = $crew->getPhotoUrl(2);
        } else {
            $url = $crew->getPhotoUrl(1);
        }         

        $response = array('url' => $url);

        $this->response($response, 200, 'html');
    }
}