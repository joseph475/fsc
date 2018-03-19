<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Checklist_report_controller extends Front_Controller
{

	protected $report_deploy = true;
	protected $profile;

	public function __construct()
	{
		parent::__construct();

		ini_set('memory_limit', '-1');

		$this->config->set_item('compress_output', FALSE);

		// Check if user has parent access to this controller.
		// if (!is_allowed(getclass($this))) {
		// 	show_404();
		// }

		$this->profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') {
			redirect ('admin');
		}
	}

    // --------------------------------------------------------------------

    public function master_list($key = null)
    {
    	$setting = array('TITLE' => 'Principal Master List', 'ORIENTATION' => 'L',
						 'PAPER_SIZE' => 'Legal');

    	$principal = new stdClass();
    	$principal = $this->rest->get('principals', 
			array(
				'status'	   	=> ($key != 'all')? $key : '',
				'sort'		   	=> 'id',
				'order'		   	=> 'asc',
				'limit'			=> 10000
				), 'json');	

    	$pdf = $this->tcdpf_setup($setting);

    	$pdf->setPrintHeader(false);
    	$pdf->setPrintFooter(false);

    	$tcpdf->pdf = $pdf;
    	$tcpdf->results = isset($principal->data)? $principal->data : '';
		$tcpdf->status 	= ($key)? ucwords($key) : '';

    	if(!$key) redirect('principal-master-list');

    	$this->load->view('principal/master_list', $tcpdf);
    }

	private function tcdpf_setup($setting = array())
	{
		$this->load->library('pdf_tc');

		$setting['PAPER_SIZE'] = 'A4';

		$pdf_tc = new pdf_tc($setting['ORIENTATION'], 'mm', $setting['PAPER_SIZE'], true, 'UTF-8', false);
		$pdf_tc->SetTitle($setting['TITLE']);
		$pdf_tc->SetHeaderMargin(20);
		$pdf_tc->SetTopMargin(10);
		//$pdf_tc->setFooterMargin(20);
		$pdf_tc->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		$pdf_tc->SetAuthor('Jomel P. Dicen');
		$pdf_tc->SetDisplayMode('real', 'default');

		return $pdf_tc;
	}
}