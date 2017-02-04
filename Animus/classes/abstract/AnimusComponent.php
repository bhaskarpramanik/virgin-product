<?php

	/*
	**	Abstract Class Component
	*/

	abstract class AnimusComponent{
                abstract public function service();
                abstract public function execute();
                abstract public function setHttpResponseCode($code);
                abstract public function populateResponseDataset();
				
	}

?>