<?
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//	DESCRIPTION
//	mixed call_user_func_array  ( callback $function  , array $param_arr  )
//  Call a user defined function  with the parameters in param_arr . 
//
//	PARAMETERS
//	function 
//		The function to be called.
//  param_arr 
//		The parameters to be passed to the function, as an indexed array.
//
//	RETURN VALUES
//	Returns the function result, or FALSE on error.
//
//	NOTES
//	Referenced variables in param_arr  are passed to the function by a reference, others are passed by a value. In other words, it does not depend on the function signature 	whether the parameter is passed by a value or by a reference. 
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//	DESCRIPTION
//	mixed call_user_func ( callback $function [, mixed $parameter [, mixed $... ]] )
//	Call a user defined function given by the function parameter.
//
//	PARAMETERS
//	function
//	    The function to be called. Class methods may also be invoked statically using this function by passing array($classname, $methodname) to this parameter. Additionally //		class methods of an object instance may be called by passing array($objectinstance, $methodname) to this parameter.
//	parameter
//	    Zero or more parameters to be passed to the function. 
//
//	RETURN VALUES
//	Returns the function result, or FALSE on error.
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

class GenericEventClass {

	
	function __construct() { }
	
	function __destruct() { }



	function DispachEvent($aEventHandler,&$aParams = null){

		// Verifico che i parametri siano o meno un array
		if (is_array($aParams)) {

			// Verifico che l'evento da chiamare sia un metodo di una sottoclasse
			// oppure sia dichiarato come funzione esterna alla classe

			if (method_exists(&$this, $aEventHandler)) { $result = call_user_func_array(array(&$this, $aEventHandler),&$aParams); }
			else if (function_exists($aEventHandler)) { $result = call_user_func_array($aEventHandler,&$this,&$aParams); }

			
		} else {



			if (method_exists(&$this, $aEventHandler)) { $result = call_user_func(array(&$this, $aEventHandler),&$aParams); }
			else if (function_exists($aEventHandler)) { $result = call_user_func($aEventHandler,&$this,&$aParams); }

		}

		return $result;
	}


}



?>