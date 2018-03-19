<?php

abstract class Base 
{
	protected $_cache, 
	// Contains data mapped from tables to child classes
	$_data = array(), 
	$_id;
	
	protected $_validators = array();
	protected $_validation_errors = array();
	// --------------------------------------------------------------------
	
	/**
	 * Load an entity, if first parameter is int ,takes from the model.
	 *
	 * @param $id mixed
	 */
	public function __construct($id = null)
	{
		if (!is_null($id)) {
			if (!is_array($id) && !is_object($id)) {
				$this->load($id);	
			} else {
				$this->loadArray($id);
			}
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Save data to the model.
	 *
	 * @return mixed
	 */
	public function save()
	{
		if (count($this->_validators) > 0 && $this->validates() == FALSE) {			
			return FALSE;			
		}
		$model = $this->getModel();
		$this->{$model->get_primary_key()} = $this->getModel()->do_save($this->getData());
		$this->load($this->{$model->get_primary_key()});

		return $this->{$model->get_primary_key()};
	}

	// --------------------------------------------------------------------
	
	/**
	 * Save data to the model.
	 *
	 * @return mixed
	 */
	public function batch_save($data, $id)
	{
		if (count($this->_validators) > 0 && $this->validates() == FALSE) {			
			return FALSE;			
		}

		$model = $this->getModel();
		$this->{$model->get_primary_key()} = $this->getModel()->do_batch_save($data, $id);
		$this->load($this->{$model->get_primary_key()});

		return $this->{$model->get_primary_key()};
	}

	// --------------------------------------------------------------------
	
	/**
	 * Delete the entity.
	 *
	 * @return boolean
	 */
	public function delete()
	{
		return $this->getModel()->delete($this->getId());
	}


	public function getId()
	{
		$model = $this->getModel();

		if (isset($this->_data[$model->get_primary_key()])) {
			return $this->_data[$model->get_primary_key()];
		} else {
			return ;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Load properties via database.
	 *
	 * @param int $key
	 * @param string $field
	 */
	public function load($key, $field = '')
	{
		$data = $this->getModel()->get($key, $field);

		$this->loadArray($data);

		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Load properties from array.
	 *
	 * @param array $data
	 */
	public function loadArray($data)
	{
		if ($data && (is_array($data) || is_object($data))) {
			foreach ($data as $p => $val)
			{
				$this->$p = $val;
			}
		}

		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * PHP magic method to populate our $_data array.
	 * 
	 * @param string $name 
	 * @param mixed $value 
	 */
	public function __set($name, $value)
	{
		$this->_data[$name] = $value;
	}	

	// --------------------------------------------------------------------
	 
	public function __get($name)
	{
		return @$this->_data[$name];
	}

	// --------------------------------------------------------------------
	
	public function hasData()
	{
		return count($this->getData()) > 0;
	}

	// --------------------------------------------------------------------
	
	public function getData()
	{
		return $this->_data;
	}

	/**
	 * Return validation errors after saving.
	 * @return [type] [description]
	 */
	public function get_validation_errors()
	{
		return $this->_validation_errors;
	}

	// --------------------------------------------------------------------
	// 
	// Declare abstract to force implementing classes to have this method
	// 
	// --------------------------------------------------------------------
	abstract function getModel(); 

	// --------------------------------------------------------------------
	
	/**
	 * Checks if the entity conforms to business rules. Putting this method here instead of the 
	 * model, want to keep the model as database layer as much as possible hopefully.
	 * 
	 * @return boolean
	 */
	protected function validates()
	{
		foreach ($this->_validators as $element => $rules)
		{
			// Use Zend_Validate because CI's validation library only works form form inputs.
			$validator = new Zend_Validate();
			foreach ($rules as $i => $rule) {
				// Chaining validators.
				if (!is_array($rule)) {
					$validator->addValidator(new $rule());
				} else {
					// Set options if any (passed as array)
					$validator->addValidator(new $i($rule));
				}
			}

			if ($validator->isValid($this->$element) == FALSE) {				
				$this->_validation_errors[$element] = $validator->getMessages();
			}
		}

		return count($this->_validation_errors) == 0;
	}	
}