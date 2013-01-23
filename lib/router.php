<?php

/**
 * Takes in a request and an array of paths
 * and sets variables for a resource
 */
class Router
{
    private $route = null;
    private $variables = null;
    private $values = null;
    
    function __construct($request, $routes)
    {
        $patterns = array(
            "/{[a-zA-z0-9]+}/",
            "/\//",
            "/$/",
            "/^/",
        );

        $replacements = array(
            "([a-zA-Z0-9]+)",
            "\/",
            "?$/",
            "/^",
        );
        
        foreach($routes as $route)
        {
          $pattern = preg_replace($patterns,$replacements,$route["path"]);
          if (preg_match($pattern,$request)) $this->route = $route;
        }
        
        if ($this->route)
        {
          $pattern = preg_replace($patterns,$replacements,$this->route["path"]);
          preg_match_all("/{([a-zA-z0-9]*)}/",$this->route["path"],$varNames);
          $this->variables = $varNames[1];
          preg_match($pattern,$request,$values);
          unset($values[0]);
          $this->values = array_merge(array(),$values);
        }
    }

    public function getRoute()
    {
        return $this->route;
    }
    
    public function setVariables()
    {
    	if (!$this->route) return;
    	foreach($this->values as $key=>$var)
  		{
  			$s = $this->variables[$key];
  			global $$s;
  			$$s = $var;
  		}
    }
}