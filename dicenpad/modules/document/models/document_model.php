<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Document_model extends MY_Model
{
    private $_table_name = 'document';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'id' => 'admin_options', 
        'classify_id' => 'document',
        'published',
        'exclude_ids'
    );
    
    protected $_search_fields = array( 
        'document'
    );

	// --------------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        // Set the values for MY_Model::_table and MY_Model::_primary .
        $this->set_table_name($this->_table_name);
        $this->set_primary_key($this->_primary_key);
    }

    public function _set_join()
    {
        $this->db->select($this->_table_name . '.*, admin_options.option, 
            admin_options.option_id', FALSE
        );

        $this->db->join('admin_options', 'document.classify_id = admin_options.option_id', 'left'); 
    }

    public function insert_docs($key)
    {
        $query = $this->db->query("DELETE FROM jd_crew_docs WHERE docs_id NOT IN (SELECT id FROM jd_document)");

        $query = $this->db->query("INSERT jd_crew_docs 
                    (crew_id, docs_id, docs_nos, date_issued, date_expired, 
                    remarks, hasflag, published, sort_order)    

                    SELECT {$key}, d.id, '0',  '0000-00-00', '0000-00-00', '',
                        d.hasflag, d.inresume, @curRow := @curRow + 1 AS row_number
                    FROM jd_document d
                    JOIN (SELECT @curRow := 0) r
                        WHERE NOT EXISTS
                            (SELECT DISTINCT * FROM jd_crew_docs AS c
                                WHERE c.docs_id = d.id AND c.crew_id = {$key}) AND d.published = 1
                ");

        //AND department_id IN ((SELECT department_id FROM jd_crew INNER JOIN jd_position ON jd_position.id = jd_crew.position_id WHERE crew_id = 2), 0)

        if($query) {
            return true;
        }

        return FALSE;
    }
}