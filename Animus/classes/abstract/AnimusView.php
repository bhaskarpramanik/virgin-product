<?php

	/*
	**	Abstract Class View
    *   @author bhaskarpramanik
	*/

	interface AnimusView{	
            public function output();
            public function setViewData($key, $value);
            public function setHeaders($headerObject);

	}

?>