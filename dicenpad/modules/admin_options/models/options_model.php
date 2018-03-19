<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Options_model extends MY_Model
{
    private $_table_name = 'admin_options';
    private $_primary_key = 'option_id';	

    protected $_allowed_filters = array(
        'option_group', 'option_code', 'exclude_ids', 'deleted'
    );
    
    protected $_search_fields = array(
        'jd_admin_options.option', 'option_code', 'option_group'
    );

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

	// --------------------------------------------------------------------

    public function get_option_group($group)
    {
    	return $this->get($group, 'option_group');
    }
   
}