<?php

if (!function_exists('create_dropdown')) {
    function create_dropdown($model, $field) {
        $ci =& get_instance();
        $ci->load->model($model, 'dropdown_' . $model);
        $records = $ci->{'dropdown_' . $model}->fetch_all();
        
        $field = explode(',', $field);

        $values = array('' => 'Select...');
        foreach ($records->result_array() as $record) {
            $value = array();
            foreach ($field as $f) {
                 $value[] = $record[$f];
            }

            $values[$record[$ci->{'dropdown_' . $model}->get_primary_key()]] = implode(' ', $value);
        }
        
        return $values;
    }
}

function set_flashdata($type, $message) {
    $ci =& get_instance();
    
    if ($type == 'error') {

    } else {

    }

    $ci->session->set_flashdata('message', $message);
}

/**
 * Add a js file to the footer part.
 * 
 * @param String $file File OR directory relative to js path
 */
function add_js($file) {
    $ci =& get_instance();    
    
    if (is_dir($ci->config->item('js_dir') . $file)) {
        $files = get_filenames($ci->config->item('js_dir') . $file);
        $_file = array_map(
            function ($f, $dir) {
                return $dir . '/' . $f;
            },
            $files,
            array_fill(1, count($files), $file)
        );

        $file = $_file;        
    }

    $js = $ci->config->item('js');

    if (!$js) {
        $js = array();    
    }

    array_push($js, $file);

    $ci->config->set_item('js', $js);
}

function load_js($js = null) {
    $ci =& get_instance();

    $ci->load->library('minify');

    if (is_null($js)) {
        $js = $ci->config->item('js');
    }

    foreach ($js as $j) {
        if (is_array($j)) {
            load_js($j);
        } else {
           echo '<script type="text/javascript" src="' . js_dir($j) . '">' . "\n";
        }
    }

    return;
}

function add_css($file) {
    $ci =& get_instance();  

    $css = $ci->config->item('css');

    if (!isset($css)) {
        $css = array($file);
    } else {
        $css[] = $file;
    }

    $ci->config->set_item('css', $css);
}

function load_css() {
    $ci =& get_instance();

    $ci->load->library('minify');
    $css = $ci->config->item('css');    

    if ($css) {
        $ci->minify->css($css);
         echo $ci->minify->deploy_css();  
        foreach ($css as $j) {  
            //echo '<link type="text/css" rel="stylesheet" href="' . css_dir($j) . '" />';
        }
    }
}

/**
* Checks if the hash on the session is valid to increase security.
*
*/
function is_logged_in() {
    $ci =& get_instance();

    return ($ci->session->userdata('logged_in') && $ci->session->userdata('api_key') != '');
}

if (!function_exists('__autoload')) {    
    function __autoload($class) {
        $path = APPPATH . 'libraries/' . $class . '.php';    
        if (file_exists($path)) {
            include_once ($path);
            if (!class_exists($class, false) && !interface_exists($class)) {
                trigger_error("Unable to load class: $class", E_USER_WARNING);
            }
        } else {        
            // Try to break down directory.
            $path = APPPATH . 'libraries/' . str_replace('_', '/', $class) . '.php';        
            
            if (file_exists($path)) {
                include_once($path);            
                if (!class_exists($class, false) && !interface_exists($class)) {
                    trigger_error("Unable to load class: $class", E_USER_WARNING);
                }
            }
        }
    }
}

/**
 * Return blank if string is empty
 * @param  string $string String to be echoed
 * @return string
 */
function _p($obj, $string) {
    if (!is_array($obj)) {
        $obj = (array) $obj;
    }

    if (!isset($obj[$string])) {
        return '';
    }
    $string = $obj[$string];

    if (trim($string) == '' || !isset($string)) {
        return '';
    }

    return $string;    
}

function _d($date, $format = 'Y-m-d H:i:s') {
    if (is_null($date) || $date == '0000-00-00 00:00:00' || trim($date) == '') {
        return '';
    } else {
        return date($format, strtotime($date));
    }
}

// --------------------------------------------------------------------

if (!function_exists('is_allowed')) {    
    /**
     * Checks the API is resource is accessible
     * @param  string  $resource
     * @return boolean
     */
    function is_allowed($resource) {
        $ci =& get_instance();

        return $ci->rest->get('uat/access', array('resource' => $resource));
    }
}

function getclass($class, $is_read=true, $type=1){
    $action = '_READ';

    if(!$is_read){
        if($type == 2){
            $action = '_INSERT';
        } elseif($type == 3) {
            $action = '_UPDATE';
        } elseif($type == 4) {
            $action = '_DELETE';
        } elseif($type == 5) {
            $action = '_PRINT';
        }
    }
    return strtoupper($class . $action);
}
// --------------------------------------------------------------------

if (!function_exists('select_iso')) {    
    /**
     * Checks the API is resource is accessible
     * @param  string  $resource
     * @return boolean
     */
    function select_iso($form) {
        $ci =& get_instance();

        $res = $ci->rest->get('master_form', array('id'=> $form), 'json');

        return ($res->iso)? $res->iso : '';
    }
}

if (!function_exists('select_iso2')) {    
    /**
     * Checks the API is resource is accessible
     * @param  string  $resource
     * @return boolean
     */
    function select_iso2($form) {
        $ci =& get_instance();

        $res = $ci->rest->get('master_form', array('id'=> $form), 'json');

        return ($res->iso2)? $res->iso2 : '';
    }
}

if (!function_exists('confirm_query')) {  
    function confirm_query($query=""){
        $data = array();
        if($query->num_rows() > 0){    
            foreach ($query->result() as $row){
               $data[] = $row;  
            }      
        }
        return $data; 
    }
}
// --------------------------------------------------------------------

if (!function_exists('select_signatory')) {    
    /**
     * Checks the API is resource is accessible
     * @param  string  $resource
     * @return boolean
     */
    function select_signatory($user_id = 0) {
        $ci =& get_instance();

        return $ci->rest->get('signature', array('id'=> $user_id), 'json');
    }
}


/**
*  Get Age
*  @var string YYY-MM-DD // MYSQL Format
*  @return int age
**/
function get_age($mysql_date) {
    list($y,$m,$d) = explode("-",$mysql_date);
    $age = date('Y')-$y;
    date('md')<$m.$d ? $age--:null;
    return $age;
}

function gen_chars($length = 6, $ischars = false) {
    // Available characters
    $chars = '0123456789' . (($ischars)? 'abcdefghjkmnoprstvwxyz' : '') ;

    $code  = '';
    // Generate code
    for ($i = 0; $i < $length; ++$i){
        $code .= substr($chars, (((int) mt_rand(0, strlen($chars))) - 1),1);
    }
    return strtoupper($code);
}

function serial($length = 6, $ischars = false) {
    // Available characters
    $chars = (($ischars)? 'abcdefghjkmnoprstvwxyz' : uniqid()) ;

    $code  = '';
    // Generate code
    for ($i = 0; $i < $length; ++$i){
        $code .= substr($chars, (((int) mt_rand(0, strlen($chars))) - 1),1);
    }
    return strtoupper($code);
}

function dbug($data=null){
    echo "<pre>";
    print_r($data);
    echo "</pre>"; 
    exit();   
}

function check_isexpired($date=null){
    if(strtotime($date) < time() ){ 
        return true;
    }

    return false;
}

function getLongestString() {
    $args = func_get_args();
    return max(array_map('strlen', $args));
}

function GeneratePassword($length, $chars)
{
    return substr(str_shuffle($chars), 0, $length);
}

function ReformatPhoneNumber($number)
{
    if (preg_match('/^(\d[ -]?){7,12}$/', $number, $matches)){
        return preg_replace('/[ -]/', '', $number);
    }
    throw new Exception('Invalid phone number');
}

function SplitEmailAddress($address)
{   
    list($user, $domain) = explode('@',$address);
    return array('user' => $user, 'domain' => $domain);
}

function GetUniqueOnes($arr)
{
    $res = implode(',',array_unique($arr));
   
    return $res;
}

function ReadXml($xmlstr)
{
    static $result = '';
    $xml = new SimpleXMLElement($xmlstr);

    if(count($xml->children()))
    {
        $result .= $xml->getName().PHP_EOL;
        foreach($xml->children() as $child)
        {
            ReadXml($child->asXML());
        }
    }
    else
    {
        $result .= $xml->getName().': '.(string)$xml.PHP_EOL;
    }

    return $result;
}

function MaxArray($arr)
{
    $GLOBALS['max'] = 0;
    array_walk_recursive($arr,create_function('$item,$key','if($item > $GLOBALS["max"]) $GLOBALS["max"] = $item;'));
    return $GLOBALS['max'];
}

function limit_string($x, $len = 150){
    if(strlen($x) <= $len) {
        return $x;
    } else {
        return substr($x, 0, $len) . '...';
    }
}

function get_client_ip() {
    $ip = $_SERVER['REMOTE_ADDR'];

    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
} 

function formatMoney($number, $fractional=false) {
    if ($fractional) {
    $number = sprintf('%.2f', $number);
    }
    while (true) {
    $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
    if ($replaced != $number) {
        $number = $replaced;
    } else {
        break;
    }
    }
    return $number;
}

function getRemainingDays($date){
    $date = date('d F Y', strtotime($date));
    $future = strtotime($date); //Future date.
    $timefromdb = strtotime(date('d F Y'));
    $timeleft = $future-$timefromdb;
    $daysleft = round((($timeleft/24)/60)/60); 
    return $daysleft;
}

function notification($message, $header='Status!', $alert = 'alert-danger'){
    $ci =& get_instance();

    $message = "<div class='alert {$alert} fade in'><a class='close' data-dismiss='alert' href='#'>&times;</a><strong>{$header}</strong><br/> {$message}</div>";

    return $ci->session->set_userdata('message', $message);
}

function search_arr($array, $key, $value)
{
    $results = array();
    if (is_array($array))
    {   
        if (isset($array[$key]) && $array[$key] == $value)
            $results[] = $array;

        foreach ($array as $subarray)
            $results = array_merge($results, search_arr($subarray, $key, $value));        
            
    }

    return $results;
}

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}

function arrayToObject($d) {
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object) array_map(__FUNCTION__, $d);
    }
    else {
        // Return object
        return $d;
    }
}

function getDuration($date2, $date1)
{
    $date1 = '2000-01-25';
    $date2 = '2010-02-20';

    $ts1 = strtotime($date1);
    $ts2 = strtotime($date2);

    $year1 = date('Y', $ts1);
    $year2 = date('Y', $ts2);

    $month1 = date('m', $ts1);
    $month2 = date('m', $ts2);

    return (($year2 - $year1) * 12) + ($month2 - $month1);
}
