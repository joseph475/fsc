<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';

class Pdf_tc extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }

    /**
	* Get an instance of CodeIgniter
	*
	* @access protected
	* @return void
	*/
	protected function ci()
	{
		return get_instance();
	}

	/**
	* Load a CodeIgniter view into domPDF
	*
	* @access public
	* @param string $view The view to load
	* @param array $data The view data
	* @return void
	*/
	public function load_view($view, $data = array())
	{
		$html = $this->ci()->load->view($view, $data, TRUE);

		$this->load_html($html);
	}
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */