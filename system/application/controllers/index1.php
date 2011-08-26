<?php

class index1 extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	function index()
	{
		$this->load->library('xmlrpc');
		$this->load->library('xmlrpcs');

		$config['functions']['new_post']  = array('function' => 'My_blog.new_entry');
		$config['functions']['update_post'] = array('function' => 'My_blog.update_entry');

		$this->xmlrpcs->initialize($config);
		$this->xmlrpcs->serve();
	}
}