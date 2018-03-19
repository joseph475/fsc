<?php

abstract class Rest_ResponseFilter
{
	static function filter(array $data, $filters = array())
	{			
		foreach ($data as $index => $value) {				
			if (in_array($index, $filters)) {
				unset($data[$index]);
			}
		}

		return $data;		
	}
}