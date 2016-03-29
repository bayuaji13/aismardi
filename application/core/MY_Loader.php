<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Loader extends CI_Loader {
	public function template($template_name, $vars, $return = FALSE){
		$this->view('skin/header', $vars, $return);
		$this->view('frontpage'.$template_name, $vars, $return);
		$this->view('skin/footer', $vars, $return);
	}
}