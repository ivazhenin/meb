<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
	
	var $tbl_images	=	'cms_images';
	var $tbl_pages	=	'cms_pages';
	var $tbl_news		=	'cms_news';
  var $tbl_akcii		=	'cms_akcii';
  var $tbl_blocks	= 'cms_blocks';
	var $tbl_banners	=	'cms_banners';

function shout()
{
date_default_timezone_set("Europe/Moscow");
$hostname = 'localhost';
$username = 'korova';
$password = 'korova';
$dbname = 'korova';
$userTable = "shoutbox";

$link = mysql_connect($hostname,$username,$password);
mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;	
mysql_query('set names utf8');

if(isset($_POST['name'])&& isset($_POST['id'])==false) 
{	
	$name = $_POST['name'];
	$news = $_POST['news'];
			
		/*** set all errors to execptions ***/
		//$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$query = "INSERT INTO $userTable VALUES(NULL,NOW(),'$name','$news')";
		$result = mysql_query($query);
		mysql_close();
		if($result = true)
		{
			//populate_shoutbox();
			echo("Fucking true");	
		}
}

if(isset($_POST['name']) && isset($_POST['id'])) 
{	
	$name = $_POST['name'];
	$news = $_POST['news'];	
	$id = $_POST['id'];
		$fild1 = 'news';
		$fild2 = 'name';
	$query = "UPDATE $userTable SET $fild1 = '$news', $fild2 = '$name' where id=$id";
		$result = mysql_query($query);
	
	mysql_close();
	if($result = true)
	{
		populate_shoutbox();	
	}
}

if(isset($_POST['refresh'])) 
{	
	//populate_shoutbox();
	//echo("Fucking");
        $hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
	$userTable = "shoutbox";
	$limit = "";
	if(isset($_POST['num_news']))
	{
		$limit = "limit 0,". $_POST['num_news'];
	}
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "select * from $userTable order by id desc $limit";/*limit 0,15*/
	$result = mysql_query($query);
	
	$str=array();
	while($data = mysql_fetch_array($result) )
	{

		$string = $data["news"];
		$shirt_news = explode ("|", $string);
		$str[] = array("id"=>$data["id"],"date_time"=>date("d.m.Y H:i", strtotime($data["date_time"])),"name"=>$data["name"],"news"=>$shirt_news["0"]);
	}
	mysql_close();
	echo json_encode($str);	
}

if(isset($_POST['id'])&&isset($_POST['del'])) 
{
	$ref = $_POST['id'];
	//delete_news($ref);
	$hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
        $userTable = "shoutbox";
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "delete from $userTable where id=$ref";
	$result = mysql_query($query);
	mysql_close();	
}

if(isset($_POST['id'])&&isset($_POST['edit'])) 
{
	$ref = $_POST['id'];
	//editnews($ref);
	$hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
	$userTable = "shoutbox";
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "select * from $userTable where id=$ref";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	mysql_close();
	echo json_encode(array("id"=>$data["id"],"date_time"=>date("d.m.Y H:i", strtotime($data["date_time"])),"name"=>$data["name"],"news"=>$data["news"]));	
}

if(isset($_POST['id'])&&isset($_POST['full'])) 
{
	$ref = $_POST['id'];
	//getfullnews($ref);
	$hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
	$userTable = "shoutbox";
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "select * from $userTable where id=$ref";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	mysql_close();
	echo $data["news"];
		
}

function delete_news($ref)
{
	$hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
        $userTable = "shoutbox";
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "delete from $userTable where id=$ref";
	$result = mysql_query($query);
	mysql_close();
}

function editnews($ref)
{
	$hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
	$userTable = "shoutbox";
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "select * from $userTable where id=$ref";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	echo json_encode(array("id"=>$data["id"],"date_time"=>date("d.m.Y H:i", strtotime($data["date_time"])),"name"=>$data["name"],"news"=>$data["news"]));
	mysql_close();
}

function getfullnews($ref)
{
	$hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
	$userTable = "shoutbox";
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "select * from $userTable where id=$ref";
	$result = mysql_query($query);
	$data = mysql_fetch_array($result);
	mysql_close();
	echo $data["news"];
}

function populate_shoutbox() {
	echo("Fucking");
        $hostname = 'localhost';
	$username = 'korova';
	$password = 'korova';
	$dbname = 'korova';
	$userTable = "shoutbox";
	$limit = "";
	if(isset($_POST['num_news']))
	{
		$limit = "limit 0,". $_POST['num_news'];
	}
	$link = mysql_connect($hostname,$username,$password);
	mysql_select_db("$dbname",$link)/* or die ("������ ������� ���� ������")*/;
	
	$query = "select * from $userTable order by id desc $limit";/*limit 0,15*/
	$result = mysql_query($query);
	
	$str=array();
	while($data = mysql_fetch_array($result) )
	{

		$string = $data["news"];
		$shirt_news = explode ("|", $string);
		$str[] = array("id"=>$data["id"],"date_time"=>date("d.m.Y H:i", strtotime($data["date_time"])),"name"=>$data["name"],"news"=>$shirt_news["0"]);
	}
	
	mysql_close();
	echo json_encode($str);

	
}

}
	
	function Welcome()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');
		//$this->db->cache_on();
		//$this->output->cache(1440);
	}
	
	function _menu()
	{
		$query = $this->db->select('id,title,menu')->order_by('ord','asc')->get_where($this->tbl_pages, array('menu'=>1));
		$res = '<ul>'; $r=1;
		foreach($query->result() as $row)
		{
			//<a href='index.php?pg={$data['id']}'><img src='images/menu_{$r}-0.png'/></a>
			$res .= "<li><div><a href='/welcome/index/{$row->id}'><strong>{$row->title}</strong></a></div></li>";
			$r++;
			$query1 = $this->db->select('id,title,menu')->get_where($this->tbl_pages, array('menu'=>2, 'parent'=>$row->id));
			$res1 = "<div class='menu{$row->id}'><ul>";
			$fl = false;
			foreach($query1->result() as $row1)
			{
				$res1 .= "<li><a class='lnk1' href='/welcome/index/{$row1->id}'>{$row1->title}</a></li>";
				$fl = true;
			}
			$res1 .= "</ul></div>";
			$res1 .="
				<script type=\"text/javascript\">
					$(document).ready(function(){
						$('li.menu{$row->id}').hover(function(){
							$('div.menu{$row->id}').css('visibility', 'visible');
							$('div.menu{$row->id}').slideDown();
						}, function () {
							$('div.menu{$row->id}').slideUp('fast');
						});
					});
				</script>
			";
			if($fl) $res .= $res1;
			$res .= "</li>";
		}
		$res .= '</ul>';
		return $res;
	}
	
	function _menu_vert()
	{
		$query = $this->db->select('id, title, menu')->order_by('ord','asc')->get_where($this->tbl_pages,array('parent'=>null));
		$res = '<ul>';
		foreach($query->result() as $row)
		{
			$res .= "<li class='vmenu vmenu{$row->id}'><a class='link' href='/welcome/index/{$row->id}'>{$row->title}</a>";
			$res .= $this->_inmenu($row->id);
			$res .= "</li>";
		}
		$res .= '</ul>';
		return $res;
	}
	
	function _inmenu($par)
	{
		$res = '';
		$query = $this->db->select('id, title, menu')->order_by('ord','asc')->get_where($this->tbl_pages,array('parent'=>$par));
		$res .= "<ul class='vmenu{$par}'>";
		foreach($query->result() as $row)
		{
			$res .= "<li><a href='/welcome/index/{$row->id}'>{$row->title}</a>";
			$res .= $this->_inmenu($row->id);
			$res .= "</li>";
		}
		$res .= "</ul>";
		return $res;
	}

	function _banner()
	{
		$res = '';
		$query = $this->db->query("select * from {$this->tbl_banners} where startdate<now() and enddate>now() order by rand() limit 0,1");
		$idf = uniqid();
		$row = $query->row();
		$res .= "<banner url='/bann/{$row->filename}' type='{$row->type}'></banner>";
		$res .= "<script type='text/javascript'> $(document).ready(function () { $('banner').each(function () { switch($(this).attr('type')) { case 'swf': $(this).flash( { swf:$(this).attr('url'), width:$(this).width() }); break; case 'jpg':case 'png': $('<img/>').attr('src', $(this).attr('url')).css('width','160px').appendTo($(this));break; } }); }); </script>";
		return $res;
	}

	function _blocks()
	{
		$query = $this->db->get($this->tbl_blocks);
		$res = array();
		foreach($query->result() as $row)
			$res['block_'.$row->id] = $row->value;	
		return $res;
	}
  
  function _news()
  {
    //$query = $this->db->query("select * from {$this->tblnews} order by pubdate desc limit 0,3 ");
    //foreach($query->result() as $row)
    //  $res['block_'.$row->id] = $row->value;	
    //return $res;
  }

  function _akcii()
  {
    //$query = $this->db->get($this->tbl_akcii);
    //foreach($query->result() as $row)
    //  $res['block_'.$row->id] = $row->value;	
    //return $res;
  }

	public function index($id = 1)
	{
		$query = $this->db->get_where($this->tbl_pages, array('id'=>$id));
		$row = $query->row();
		$row->menu = $this->_menu();
    $row->news = $this->_news();
    $row->akcii = $this->_akcii();
    $row->menu_vert = $this->_menu_vert();
		foreach($this->_blocks() as $key=>$value)
			$row->$key = $value;
		if($row->content == 'redirect;news')
			redirect('/welcome/news', 'refresh');
		$row->content = $this->parser->parse_string($row->content, array(), TRUE);
		$this->parser->parse('template', $row);
	}
	
	public function news($id = 0)
	{
    $query = $this->db->get_where($this->tbl_pages, array('id'=>4));
		$row = $query->row();
		$row->menu = $this->_menu();
		$row->menu_vert = $this->_menu_vert();
		foreach($this->_blocks() as $key=>$value)
			$row->$key = $value;
		if(!$id)
		{
			$query = $this->db->query("select *, day(pubdate) as day,month(pubdate) as month,year(pubdate) as year from {$this->tbl_news} order by pubdate desc limit 0,5");
			$row->content = $this->parser->parse('news', array('news'=>$query->result()), true);
		}
		else
		{
			$query = $this->db->query("select *, day(pubdate) as day,month(pubdate) as month,year(pubdate) as year from {$this->tbl_news} where id={$id}");
			$row->content = $this->parser->parse('news', $query->row(), true);
		}
		$this->parser->parse('template', $row);
	}
	
	public function captcha()
	{
		$RandomStr = md5(microtime());// md5 to generate the random string
		$ResultStr = substr($RandomStr,0,5);//trim 5 digit 
		$NewImage =imagecreatefromjpeg("./images/img.jpg");//image create by existing image and as back ground 
		$LineColor = imagecolorallocate($NewImage,233,239,239);//line color 
		$TextColor = imagecolorallocate($NewImage, 255, 255, 255);//text color-white
		imageline($NewImage,1,1,40,40,$LineColor);//create line 1 on image 
		imageline($NewImage,1,100,60,0,$LineColor);//create line 2 on image 
		imagestring($NewImage, 5, 20, 10, $ResultStr, $TextColor);// Draw a random string horizontally 
		$_SESSION['captcha'] = $ResultStr;// carry the data through session
		header("Content-type: image/jpeg");// out out the image 
		imagejpeg($NewImage);//Output image to browser 
	}
	
	public function order()
	{
		if(isset($_REQUEST["captcha"]) && isset($_SESSION["captcha"]) && ($_REQUEST["captcha"]!=$_SESSION["captcha"]))
		{
			echo "<span style='color:Red;'>Введены неверные символы</span>";
			exit(0);
		}

		$message = "<h1>Заявка от {$_REQUEST["nm"]}</h1>";
		$message .= "<p>Телефон: {$_REQUEST["tel"]}</p>";
		$message .= "<p>Email: {$_REQUEST["email"]}</p>";
		$message .= "<p>Текст заявки: {$_REQUEST["order"]}</p>";
		$email = $_REQUEST["email"];
		$to = "nsk-transport@yandex.ru";
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=utf-8'."\r\n";
		$headers .= 'Reply-To: '.$email . "\r\n" ;
		$subject = 'Заявка. '.$_REQUEST["nm"];
		$subject = '=?utf-8?B?'.base64_encode($subject).'?=';

		mail($to, $subject, $message, $headers);
		echo "<p>Заявка отправлена</p>";
	}
	
	public function test()
	{
		$this->db->cache_delete_all();
		redirect('/admin','refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */