<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Allows to use caching drivers that are available on the server.
 *
 *  @author     Jose Mari Consador
 *  @version    0.1
 *  @date       2012-10-08
 */

class Cache
{	
	private static $instance;	
	private static $adapter;

	// --------------------------------------------------------------------

	private function __construct()
	{
		$ci =& get_instance();
		$ci->load->driver('cache');
		// Load cache drivers.	
	
		// if ( ! extension_loaded('memcached'))
		// {
		// 	dbug('The Memcached Extension must be loaded to use Memcached Cache.');
			
		// 	return FALSE;
		// }

		// $this->cache->memcache->save('var_name', 'var_value', 60);
		// echo $this->cache->memcache->get('var_name');

		// $memcache = new Memcache;
		// $memcache->connect('127.0.0.1', 11211) or die ("Could not connect"); 
		// $version = $memcache->getVersion();
		// echo "Server's version: ".$version."<br/>\n";
		// $tmp_object = new stdClass;
		// $tmp_object->str_attr = 'test';
		// $tmp_object->int_attr = 123; 
		// $memcache->set('key', $tmp_object, false, 10) or die ("Failed to save data at the server");
		// echo "Store data in the cache (data will expire in 10 seconds)<br/>\n"; 
		// $get_result = $memcache->get('key');
		// echo "Data from the cache:<br/>\n"; 
		// var_dump($get_result); 
		// exit;	
	
		if ($ci->cache->memcached->is_supported()) {
			self::$adapter = 'memcached';
			dbug('memcached');
		// } else if ($ci->cache->memcache->is_supported()) {
		// 	self::$adapter = 'memcache';
		// 	//dbug('memcache');
		} else if ($ci->cache->apc->is_supported()) {
			self::$adapter = 'apc';
			dbug('apc');
		} else {
			self::$adapter = 'file';
			//dbug('file');
		}
	}

	// --------------------------------------------------------------------

	public static function get_instance()
	{
		if (!self::$instance)
		{
			self::$instance = new Cache();
		}

		return self::$instance;
	}

	// --------------------------------------------------------------------

	/**
	 * Get item from cache store.
	 * @param  string $id 
	 * @return mixed
	 */
	public static function get($id)
	{
		$ci =& get_instance();
		return $ci->cache->{self::$adapter}->get(md5($id));
	}

	// --------------------------------------------------------------------

	/**
	 * Save item to cache store.
	 * 
	 * @param  string  $id   unique identifier of the item in the cache
	 * @param  mixed   $data data to be cached
	 * @param  integer $ttl  time in seconds to store in cache
	 * @return [type]        [description]
	 */
	public static function save($id, $data, $ttl = 180)
	{
		$ci =& get_instance();
		return $ci->cache->{self::$adapter}->save(md5($id), $data, $ttl);
	}

	// ------------------------------------------------------------------------

	/**
	 * Delete from Cache
	 *
	 * @param 	mixed		unique identifier of the item in the cache
	 * @return 	boolean		true on success/false on failure
	 */
	public static function delete($id)
	{
		$ci =& get_instance();
		return $ci->cache->{self::$adapter}->delete(md5($id));
	}

}