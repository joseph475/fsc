<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Memo_controller extends Front_Controller
{
	private $class = 'MEMO';

	public function __construct()
	{
		parent::__construct();

		// Check if user has parent access to this controller.
		if (!is_allowed(getclass($this->class))) show_404();
	}

    /**
	* This is the default action, lists all employees.
	*
	* @param int $page
	*/ 
	public function index()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');
		
		$memo = new stdClass();
		$memo->clssnme 				= $this->class;
		$memo->thumbnail_url 		= $profile->thumbnail_url;
		$memo->first_name 			= $profile->first_name;
		$memo->last_name 			= $profile->last_name;		
		$memo->user_id 				= $profile->user_id;
		$memo->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/memo/list/model.js');
		add_js('modules/memo/list/directory_view.js');
		add_js('modules/memo/list/options_view.js');
		add_js('modules/memo/list/paginated_view.js');
		add_js('modules/memo/list/paginated_collection.js');
		add_js('modules/memo/list/router.js');
		
		$this->layout->view('memo/list', $memo);
	}

	public function new_memo()
	{
		if($this->session->userdata('message')){
            $message = $this->session->userdata('message');
            $this->session->unset_userdata('message');
        }

		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$users = $this->rest->get('users', 
			array(
				'sort'		   	=> 'first_name',
				'order'		   	=> 'asc',
				'inactive'		=> 1,
				'limit'		   	=> 500
				), 'json');

		$memo = new stdClass();
		$memo->clssnme 				= $this->class;
		$memo->users 				= $users->data;
		$memo->notification 		= isset($message)? $message : '';
		$memo->thumbnail_url 		= $profile->thumbnail_url;
		$memo->first_name 			= $profile->first_name;
		$memo->last_name 			= $profile->last_name;
		$memo->principal_id 		= $profile->principal_id;

		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('libs/jquery.timeago.js');		
		add_js('libs/load-image.min.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');
		add_js('libs/ajaxfileupload.js');

		add_js('libs/jquery.MultiFile.min.js');

		add_css('jquery.fileupload-ui.css');

		add_js('modules/memo/new/entry.js');

		$this->layout->view('memo/add_memo', $memo);
	}

	public function save_memo()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$config['upload_path'] 		= './uploads/files/'; //bulletin
		$config['allowed_types'] 	= 'doc|docx|pdf|ppt|pptx|xlsx|xls|gif|jpg|png|rar|zip';
		$config['max_size']			= 4096;
		$config['encrypt_name']		= FALSE;
		$config['remove_spaces']	= TRUE;
	
		$this->load->library('upload', $config);

		$memo = new stdClass();
		$message = '';

		if ( ! $this->upload->do_upload()) {
			notification($this->upload->display_errors(), 'Message', 'alert-error');
			$message = "<div class='alert alert-error fade in'><a class='close' data-dismiss='alert' href='#'>&times;</a><strong>Message</strong><br/> " . $this->upload->display_errors() . "</div>";
		} else {				
			$data = array('upload_data' => $this->upload->data());

			$memo = $this->rest->post('memo', 
				array(
						'memo'		   	=> $_POST,
						'data'			=> $data
					), 'json');	

			if($memo->status == 'success') {
				notification('Memo successfully updated.', 'Message', 'alert-info');
			} 	

			redirect('create-upload');		
		}

		$users = $this->rest->get('users', 
			array(
				'sort'		   	=> 'first_name',
				'order'		   	=> 'asc',
				'inactive'		=> 1,
				'limit'		   	=> 500
				), 'json');

		$memo = new stdClass();
		$memo->clssnme 				= $this->class;
		$memo->users 				= $users->data;
		$memo->notification 		= isset($message)? $message : '';
		$memo->thumbnail_url 		= $profile->thumbnail_url;
		$memo->first_name 			= $profile->first_name;
		$memo->last_name 			= $profile->last_name;
		$memo->principal_id 		= $profile->principal_id;
		$this->layout->view('memo/add_memo', $memo);
	}

	public function update_memo()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$id = $this->input->post('id');

		$config['upload_path'] 		= './uploads/files/'; //bulletin
		$config['allowed_types'] 	= 'doc|docx|pdf|xlsx|xls|gif|jpg|png|rar|zip';
		$config['max_size']			= 4096;
		$config['encrypt_name']		= FALSE;
		$config['remove_spaces']	= TRUE;
	
		$this->load->library('upload', $config);

		$memo = new stdClass();
		
		$data = FALSE;
		if ( $this->upload->do_upload()) {				
			$data = array('upload_data' => $this->upload->data());			
		}

		$memo = $this->rest->put('memo', 
			array(
					'memo'		   	=> $_POST,
					'data'			=> $data
				), 'json');	

		if($memo->status == 'success') {
			notification('Memo successfully updated.', 'Message', 'alert-info');
		} 

		redirect('edit-upload/' . $id);
	}

	public function edit_memo($id)
	{
		if($this->session->userdata('message')){
            $message = $this->session->userdata('message');
            $this->session->unset_userdata('message');
        }

		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$memo = $this->rest->get('memo', array('id' => $id), 'json');

		$users = $this->rest->get('users', 
			array(
					'sort'		   	=> 'first_name',
					'order'		   	=> 'asc',
					'inactive'		=> 1,
					'limit'		   	=> 500
				), 'json');

		$memo_user = $this->rest->get('memo_users', 
			array(
					'memo_id'		=> $id,
					'limit'		   	=> 500
				), 'json');

		$result = array();

		if(isset($memo_user->data)) {
			foreach($memo_user->data as $value) {
			    $result[] = $value->user_id;        
			}
		}

		$memo->clssnme 				= $this->class;
		$memo->notification 		= isset($message)? $message : '';
		$memo->m_user 				= $result;
		$memo->users 				= $users->data;
		$memo->thumbnail_url 		= $profile->thumbnail_url;
		$memo->first_name 			= $profile->first_name;
		$memo->last_name 			= $profile->last_name;		
		$memo->principal_id 		= $profile->principal_id;

		add_css('validationEngine.jquery.css');
		add_js('libs/jquery.validationEngine.js');
		add_js('libs/jquery.validationEngine-en.js');

		add_js('libs/jquery.timeago.js');		
		add_js('libs/load-image.min.js');
		add_js('libs/tmpl.min.js');
		add_js('libs/jquery.ui.widget.js');
		add_js('libs/jquery.fileupload.js');
		add_js('libs/jquery.fileupload-fp.js');
		add_js('libs/jquery.iframe-transport.js');
		add_js('libs/ajaxfileupload.js');

		add_js('libs/jquery.MultiFile.min.js');

		add_css('jquery.fileupload-ui.css');

		add_js('modules/memo/new/entry.js');

		$this->layout->view('memo/edit_memo', $memo);
	}

	 /**
	* This is the default action, lists all employees.
	*
	* @param int $page
	*/ 
	public function download()
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$memo = new stdClass();
		$memo->clssnme 				= $this->class;
		$memo->thumbnail_url 		= $profile->thumbnail_url;
		$memo->first_name 			= $profile->first_name;
		$memo->last_name 			= $profile->last_name;
		$memo->user_id 				= $profile->user_id;
		$memo->principal_id 		= $profile->principal_id;

		add_js('libs/backbone.relational.js');
		add_js('libs/backbone-paginator.min.js');

		add_js('modules/memo/download/model.js');
		add_js('modules/memo/download/directory_view.js');
		add_js('modules/memo/download/options_view.js');
		add_js('modules/memo/download/paginated_view.js');
		add_js('modules/memo/download/paginated_collection.js');
		add_js('modules/memo/download/router.js');
		
		$this->layout->view('memo/download', $memo);
	}

	public function view_memo($memo_id = null)
	{
		$profile = $this->rest->get('user', null, 'json');
		if ($this->rest->status() == '404') redirect ('admin');

		$users = $this->rest->get('users', 
			array(
				'sort'		   	=> 'first_name',
				'order'		   	=> 'asc',
				'limit'			=> 100
				), 'json');

		$memo = $this->rest->get('memo_user', array('memo_id' => $memo_id, 'user_id' => $profile->user_id), 'json');

		$memo->clssnme 				= $this->class;
		$memo->thumbnail_url 		= $profile->thumbnail_url;
		$memo->first_name 			= $profile->first_name;
		$memo->last_name 			= $profile->last_name;
		$memo->principal_id 		= $profile->principal_id;

		$this->layout->view('memo/view_memo', $memo);
	}
}