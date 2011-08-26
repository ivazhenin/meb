<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ImgModel extends CI_Model {

	var $title   = '';
	var $content = '';
	var $date    = '';

	function __construct()
	{
		parent::__construct();
	}
	
	function get_last_ten_entries()
	{
		$query = $this->db->get('images', 10);
		return $query->result();
	}

	function insert_entry()
	{
		$this->title   = $_POST['title']; // please read the below note
		$this->content = $_POST['content'];
		$this->date    = time();

		$this->db->insert('entries', $this);
	}

	function update_entry()
	{
		$this->title   = $_POST['title'];
		$this->content = $_POST['content'];
		$this->date    = time();

		$this->db->update('entries', $this, array('id' => $_POST['id']));
	}
}
