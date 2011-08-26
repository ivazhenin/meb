<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller
{
	var $data				=	array();	
	var $num_page		=	10;
	var $tbl_images	=	'cms_images';
	var $tbl_pages	=	'cms_pages';
	var $tbl_news		=	'cms_news';
	var $tbl_blocks	=	'cms_blocks';
	var $tbl_banners	=	'cms_banners';

	function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('pagination');
		$this->load->library('user_agent');
		$this->db->flush_cache();
		if($this->ion_auth->logged_in())
		{
			$this->data['user'] = $this->ion_auth->profile()->username;
		}
		else
			$this->data['user'] = '';
	}
	
	function _view()
	{
		$this->parser->parse('Admin/admin', $this->data);
	}
	
	public function index()
	{
		if (!$this->ion_auth->logged_in()) { redirect('admin/login', 'refresh'); return; }
		$this->data['content'] = $this->parser->parse('Admin/index', array(), true);
		$this->_view();
	}

	/**
	 * Работа с изображениями 
	  *
	 */	
	public function images($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$config['base_url'] = '/admin/images/';
		$config['total_rows'] = $this->db->count_all($this->tbl_images);;
		$config['per_page'] = $this->num_page; 
		$this->pagination->initialize($config); 
		$query = $this->db->order_by('id','asc')->get($this->tbl_images, $this->num_page, $id);
		$this->data['content'] = $this->parser->parse('Admin/image', array('images'=> $query->result()), TRUE);
		$this->_view();
	}
	
	public function imgedit($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$query = $this->db->get_where($this->tbl_images, array('id'=>$id));
		$row = $query->row();
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/image_edit', $row, TRUE);
		$this->_view();
	}
	
	public function imgeditsave()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$data = array('comment'=> $this->input->post('comment'));
		if(!$this->db->update($this->tbl_images, $data, array('id'=> $this->input->post('id'))))
			$res = array('refresh'=> 0, 'error'=>$this->db->_error_message());
		else
			$res = array('refresh'=> 1);
		echo json_encode($res);
	}
	
	public function imgupload()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if(count($_FILES)==0)
		{
			$this->data['content'] = $this->parser->parse('Admin/image_upload', array(), TRUE);
			$this->_view();
		}
		else
		{
			foreach($_FILES as $file)
			{
				$tmpfile = $file["tmp_name"];
				$name = uniqid();
				switch($file['type'])
				{
					case 'image/jpeg':
						$type = '.jpg';
					case 'image/png':
						$type = '.png';
					default:
						$type = '';
				}
				$filename = $name.$type;
				$thumbname = $name."_thumb".$type;
				$newfile = "./images/{$filename}";
				$newmfile = "./images/{$thumbname}";
				copy($tmpfile, $newfile);
				list($width, $height) = getimagesize($newfile);
				$config['image_library'] = 'gd2';
				$config['source_image'] = $newfile;
				$config['create_thumb'] = true;
				$config['width'] = 150;
				$config['height'] = 100;
				$config['maintain_ratio'] = false;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
				$data = array('filename'=>$name,'thumbname'=>$thumbname,'bigw'=>$width, 'bigh'=>$height);
				$this->db->insert($this->tbl_images, $data);	
			}
			redirect('/admin/images', 'refresh');
		}
	}
	
	public function imgdelete($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/images','refresh');
		$res = array();
		$res['refresh'] = $this->db->delete($this->tbl_images, array('id'=> $id));
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}

	public function imageupload()
	{
		foreach($_FILES as $file)
		{
			$tmpfile = $file["tmp_name"];
			$name = uniqid();
			switch($file['type'])
			{
				case 'image/jpeg':
					$type = '.jpg';
				case 'image/png':
					$type = '.png';
				default:
					$type = '';
			}
			$filename = $name.$type;
			$thumbname = $name."_thumb".$type;
			$newfile = "./images/{$filename}";
			copy($tmpfile, $newfile);
			echo '/images/'.$filename;
		}
	}

	public function persimgup()
	{
		foreach($_FILES as $file)
		{
			$tmpfile = $file["tmp_name"];
			$name = uniqid();
			switch($file['type'])
			{
				case 'image/png':
					$type = 'png';
				default:
					$type = 'jpg';
			}
			$filename = $name.".".$type;
			$newfile = "./images/{$filename}";
			copy($tmpfile, $newfile);
			$config['image_library'] = 'gd2';
			$config['source_image'] = $newfile;
			$config['create_thumb'] = false;
			$config['width'] = 100;
			$config['height'] = 450;
			$config['maintain_ratio'] = true;
			$this->load->library('image_lib', $config);
			$this->image_lib->resize();
			echo '/images/'.$filename;
		}
	}
	
	/**
	 * Работа с новостями
	 *
	 * 
	 *
	 */	
	public function news($year = null, $month = null, $day = null, $id = null)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$cond = array();
		if($month != null) $cond['month(pubdate)'] = $month;
		if($year != null) $cond['year(pubdate)'] = $year;
		if($day != null) $cond['day(pubdate)'] = $day;
		$query = $this->db->select('day(pubdate) as day,month(pubdate) as month,year(pubdate) as year, id, title, status')->order_by('pubdate','desc')->get_where($this->tbl_news, $cond);
		$this->data['content'] = $this->parser->parse('Admin/news', array('newslist'=>$query->result()), true);
		$this->_view();
	}
	
	public function newsedit($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$query = $this->db->select('*,day(pubdate) as day,month(pubdate) as month,year(pubdate) as year')->get_where($this->tbl_news, array('id' => $id));
		$row = $query->row();
		$row->pubdate = $row->day.".".$row->month.".".$row->year;
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/news_edit', $row, true);
		$this->_view();
	}
	
	public function newsnew()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$row->id = -1;
		$row->title = '';
		$row->newstext = '';
		$row->pubdate = date('d.m.Y');
		$row->status = 1;
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/news_edit', $row, true);
		$this->_view();
	}
	
	public function newseditsave()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$date = preg_split('/\./',$this->input->post('pubdate'));
		$data = array(
			'title'=> $this->input->post('title'),
			'status'=> $this->input->post('status'),
			'newstext'=>$this->input->post('newstext'),
			'pubdate'=>"{$date[2]}-{$date[1]}-{$date[0]}"
			);
		
		$res = array();
		if($this->input->post('id') > 0)
			$res['refresh'] = $this->db->update($this->tbl_news, $data, array('id'=> $this->input->post('id')));
		else
			$res['refresh'] = $this->db->insert($this->tbl_news, $data);
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}
	
	/**
	* Работа с баннерами
	*
	* 
	*
	*/	
	public function banners($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$config['base_url'] = '/admin/banners/';
		$config['total_rows'] = $this->db->count_all($this->tbl_banners);
		$config['per_page'] = $this->num_page; 
		$this->pagination->initialize($config); 
		$query = $this->db->select('*,day(startdate) as ds,month(startdate) as ms,year(startdate) as ys,day(enddate) as de,month(enddate) as me,year(enddate) as ye, ((startdate<=now()) and (enddate>=now())) as showed')->order_by('showed','desc')->order_by('id','asc')->get($this->tbl_banners, $this->num_page, $id);
		$this->data['content'] = $this->parser->parse('Admin/banner', array('banners'=> $query->result()), TRUE);
		$this->_view();
	}
	
	public function banedit($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$query = $this->db->select('*,day(startdate) as ds,month(startdate) as ms,year(startdate) as ys,day(enddate) as de,month(enddate) as me,year(enddate) as ye')->get_where($this->tbl_banners, array('id'=>$id));
		$row = $query->row();
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/bann_edit', $row, TRUE);
		$this->_view();
	}
	
	public function baneditsave()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$dates = preg_split('/\./',$this->input->post('startdate'));
		$datee = preg_split('/\./',$this->input->post('enddate'));
		$data = array(
			'comment'=> $this->input->post('comment'),
			'url'=> $this->input->post('url'),
			'startdate'=>"{$dates[2]}-{$dates[1]}-{$dates[0]}",
			'enddate'=>"{$datee[2]}-{$datee[1]}-{$datee[0]}"
			);
		
		$res = array();
		$res['refresh'] = $this->db->update($this->tbl_banners, $data, array('id'=> $this->input->post('id')));
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}

	public function banupload()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if(count($_FILES)==0)
		{
			$this->data['content'] = $this->parser->parse('Admin/bann_upload', array(), TRUE);
			$this->_view();
		}
		else
		{
			foreach($_FILES as $file)
			{
				$tmpfile = $file["tmp_name"];
				$name = uniqid();
				switch($file['type'])
				{
					case 'image/png':
						$type = 'png';
					case 'application/x-shockwave-flash':
						$type = 'swf';
					default:
						$type = 'jpg';
				}
				$filename = $name.".".$type;
				$newfile = "./bann/{$filename}";
				copy($tmpfile, $newfile);
				if($type == 'jpg' || $type == 'png')
				{
					$config['image_library'] = 'gd2';
					$config['source_image'] = $newfile;
					$config['create_thumb'] = false;
					$config['width'] = 160;
					$config['height'] = 450;
					$config['maintain_ratio'] = true;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}
				$data = array('filename'=>$filename, 'type'=>$type);
				$this->db->insert($this->tbl_banners, $data);	
			}
			redirect('/admin/banners', 'refresh');
		}
	}
	
	public function bandelete($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/banners','refresh');
		$res = array();
		$res['refresh'] = $this->db->delete($this->tbl_banners, array('id'=> $id));
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}

	/**
	* Работа со страницами и структурой
	*
	* 
	*
	*/	
	public function pages()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$query = $this->db->select('id, title')->get($this->tbl_pages);
		$this->data['content'] = $this->parser->parse('Admin/structure', array('pages'=> $query->result()), TRUE);
		$this->_view();
	}
	
	public function pagesload()
	{	
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$arr = $this->_listf(null);
		echo json_encode($arr);
	}
	
	public function pagesmove()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$par = $this->input->post('par');
		if($par=='_1') $par = null;
		$res = $this->db->update($this->tbl_pages, array('parent'=>$par), array('id'=>$this->input->post('id')));
		echo json_encode(array('success'=>$res));
	}
	
	public function pagesord()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$arr = preg_split('/;/', $this->input->post('arr'));
		$i = 1;
		$res = 1;
		foreach($arr as $val)
			if($val != '')
				$res &= $this->db->update($this->tbl_pages, array('ord'=>$i++), array('id'=>$val));
		echo json_encode(array('success'=>$res));
	}
	
	public function pageedit($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/pages','refresh');
		$query = $this->db->select('id, title, menu, titlepage, keywords, description')->get_where($this->tbl_pages, array('id'=>$id));
		$row = $query->row();
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/page_edit', $row, TRUE);
		$this->_view();
	}
	
	public function pageload($id=0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/pages','refresh');
		$query = $this->db->select('content')->where('id', $id)->get($this->tbl_pages);
		echo json_encode(array('page'=>$query->row()->content));
	}
	
	public function pagenew()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$row->id = -1;
		$row->title = '';
		$row->menu = 0;
		$row->titlepage='';
		$row->keywords='';
		$row->description='';
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/page_edit', $row, TRUE);
		$this->_view();
	}
	
	public function pageeditsave()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$data = array(
			'title'=> $this->input->post('title'),
			'titlepage'=> $this->input->post('titlepage'),
			'keywords'=> $this->input->post('keywords'),
			'description'=> $this->input->post('description'),
			'menu'=> $this->input->post('menu'),
			'content'=>$this->input->post('content')
			);
		
		$res = array();
		if($this->input->post('id') > 0)
			$res['refresh'] = $this->db->update($this->tbl_pages, $data, array('id'=> $this->input->post('id')));
		else
			$res['refresh'] = $this->db->insert($this->tbl_pages, $data);
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}
	
	public function pagedelete($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/pages','refresh');
		$res = array();
		$res['refresh'] = 1;
		$res['refresh'] &= $this->db->delete($this->tbl_pages, array('id'=> $id));
		$res['refresh'] &= $this->db->update($this->tbl_pages, array('parent'=>null), array('parent'=> $id));
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}
	
	function _listf($i)
	{
		$query = $this->db->select('id,title,parent')->where('parent', $i)->order_by('ord','asc')->get($this->tbl_pages);
		foreach($query->result() as $row)
		{
			$r = $this->_listf($row->id);
			if($r == null)
				$arr[] = array('title'=>$row->title, 'key'=>$row->id);
			else
				$arr[] = array('title'=>$row->title, 'key'=>$row->id, 'children'=>$r, 'expand'=>false);
		}
		if(!isset($arr))
			return null;
		else
			return $arr;
	}

	/**
	 * Работа с шаблонами элементов
	 *
	 * 
	 *
	 */	
	public function templates()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$query = $this->db->select('id, desc')->get($this->tbl_blocks);
		$this->data['content'] = $this->parser->parse('Admin/templates',array('templates'=> $query->result()), true);
		$this->_view();
	}
	
	public function tempedit($id = 0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/templates','refresh');
		$query = $this->db->get_where($this->tbl_blocks, array('id'=>$id));
		$row = $query->row();
		$row->back_link = $this->agent->referrer();
		$this->data['content'] = $this->parser->parse('Admin/tmpl_edit', $row, TRUE);
		$this->_view();
	}
	
	public function tmplload($id=0)
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		if($id==0) redirect('/admin/templates','refresh');
		$query = $this->db->select('value')->where('id', $id)->get($this->tbl_blocks);
		echo json_encode(array('value'=>$query->row()->value));
	}
	
	public function tmpleditsave()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$data = array('value'=> $this->input->post('value'));
		$res = array();
		$res['refresh'] = $this->db->update($this->tbl_blocks, $data, array('id'=> $this->input->post('id')));
		$res['error'] = $this->db->_error_message();
		echo json_encode($res);
	}
	
	public function files()
	{
		if (!$this->ion_auth->logged_in()) { redirect('/admin/login', 'refresh'); return; }
		$this->_view();
	}
	
	public function login()
	{
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == true)
		{
			$remember = (bool) $this->input->post('remember');
			if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
			{
				$this->session->set_flashdata('message', $this->ion_auth->messages());
				redirect('/admin', 'refresh');
			}
			else
			{
				$this->session->set_flashdata('message', $this->ion_auth->errors());
				redirect('/admin/login', 'refresh');
			}
		}
		else
		{  //the user is not logging in so display the login page
			//set the flash data error message if there is one
			$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

			$this->data['email'] = array('name' => 'email',
				'id' => 'email',
				'type' => 'text',
				'value' => $this->form_validation->set_value('email'),
				);
			$this->data['password'] = array('name' => 'password',
				'id' => 'password',
				'type' => 'password',
				);

			$this->load->view('Admin/login', $this->data);
		}
	}
	
	public function logout()
	{
		$this->data['title'] = "Logout";
		$logout = $this->ion_auth->logout();
		redirect('/', 'refresh');
	}
}
