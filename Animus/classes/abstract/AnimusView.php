<?php

	/*
	**	Abstract Class View
	*/

	interface AnimusView{	
            public function output();
            public function setViewData($key, $value);
            public function setHeaders($headerObject);

	}

?>