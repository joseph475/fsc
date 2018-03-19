<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-01-21
 */

class Checklist_model extends MY_Model
{
    private $_table_name = 'checklist';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'id', 'docs_id', 'type_id'
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
        $this->db->select($this->_table_name .'.*, document.document, document.code,
             document.isdeck_off, document.isdeck_rat, document.isengine_off, document.isengine_rat, iscatering',
            FALSE
        );

        $this->db->join('document', 'document.id = checklist.docs_id', 'INNER');
    }

    function do_update($params)
    {
        $fields = $this->get_fields();
        $data = array();
        // Build the query based on the primary key value.
        foreach ($params as $key => $column) {
            if (in_array($key, $fields)) {
                $data[$key] = $column;
            }
        }

        $this->db->where('type_id', $params['type_id']);
        $this->db->where($this->_primary_key, $params[$this->_primary_key]);
        $this->db->update($this->_table_name, $data);

        return $params[$this->_primary_key];
    }
    
    public function insert_docs($typeid = 0)
    {
        $query = $this->db->query("DELETE FROM jd_checklist WHERE docs_id NOT IN (SELECT id FROM jd_document)");
        
        $query = $this->db->query("INSERT jd_checklist
                    (docs_id, type_id, published, sort_order)    

                    SELECT id, {$typeid}, 0, @curRow := @curRow + 1 AS row_number
                    FROM jd_document d
                    JOIN (SELECT @curRow := 0) r
                        WHERE NOT EXISTS
                            (SELECT DISTINCT * FROM jd_checklist AS c
                                WHERE c.docs_id = d.id AND c.type_id = {$typeid}) AND d.published = 1
                ");

        if($query) {
            return true;
        }

        return FALSE;
    }
}