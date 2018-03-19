<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 *  @author     Jomel P. Dicen
 *  @version    1.0.0
 *  @date       2013-02-22
 */

class Docs_model extends MY_Model
{
    private $_table_name = 'crew_docs';
    private $_primary_key = 'id';	

    protected $_allowed_filters = array(
        'crew_id', 'hasflag', 
        'published' => 'document',
        'classify_id' => 'document'
    );

    protected $_search_fields = array(
        'crew_id', 'document'
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
        $this->db->select('crew_docs.id, IF(jd_crew_docs.date_issued <> "", DATE_FORMAT(jd_crew_docs.date_issued,"%e-%b-%y"), "") AS date_iss,
            IF(jd_crew_docs.date_expired <> "", DATE_FORMAT(jd_crew_docs.date_expired,"%e-%b-%y"), "") AS date_expr,
            crew_docs.crew_id, crew_docs.docs_id, crew_docs.docs_nos, crew_docs.date_issued, 
            crew_docs.date_expired, crew_docs.remarks, crew_docs.capacity, crew_docs.endo_remarks, crew_docs.published, 
            crew_docs.sort_order, crew_docs.file_docs, document.document, crew_docs.endorsement,
            crew_docs.encoding_modified, crew_docs.uploading_modified
            ', FALSE
        );

        //admin_options.option AS group_type, flag.flag, flag.id as flag_id, department.option as department

        $this->db->join('document', 'crew_docs.docs_id = document.id', 'inner');    
    }

    public function get_by_crew($crew_id=null,$dept_id=null,$div_id=null)
    {       
        $array = array($this->_table_name . '.crew_id' => $crew_id,
                        //$this->_table_name . '.published' => 1
                         );

        $this->db->order_by('document.sort_order', 'asc');        

        $docs = $this->get_crew($array);

        $c = array();
        if ($docs) {
            if (!is_array($docs)) {
                $docs = array($docs);
            }
            
            foreach ($docs as $doc) {
                $o_c = new Docs($doc);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }

    public function get_by_Dept($crew_id, $type = 0)
    {               
        $array = array( $this->_table_name . '.crew_id' => $crew_id);

        if($type == 0){
            $array['document.isdeck_rat'] = 1;   
        } elseif ($type == 1){
            $array['document.isengine_rat'] = 1;
        }        

        $this->db->order_by($this->_table_name . '.sort_order, jd_document.sub_order asc ');
        $docs = $this->get_crew($array);

        $c = array();
        if ($docs) {
            if (!is_array($docs)) {
                $docs = array($docs);
            }
            
            foreach ($docs as $doc) {
                $o_c = new Docs($doc);
                $c[] = $o_c->getData();
            }

            return $c;
        }

        return FALSE;
    }

    public function get_crew($keys)
    {
        $this->_set_join();

        $this->db->where($keys);
        $obj = $this->db->get($this->_table_name);

        if ($obj->num_rows > 0)
        {
            if ($obj->num_rows == 1)
            {   // row() returns an object which holds data from a single row.
                return $obj->row();
            }
            else
            {
                $obj = $obj->result();
                return $obj;
            }
        } 
        else
        {
            return FALSE;
        }
    }

    public function delete_docs($id){

        $data = array(
            'file_docs'     => ''
        );

        $this->db->where('id', $id);
        $this->db->update('jd_crew_docs', $data);
        return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
    }
    
}