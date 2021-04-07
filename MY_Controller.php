<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
	public $data = array(); // khởi tạo biến trung gian để truyền dữ liệu sang view
	function __construct()
	{
		parent::__construct(); // kế thừa từ CI_Controller
		// lấy link
		$controller = $this->uri->rsegment(1);
		switch ($controller) {
			case "admin":
				$this->load->helper(); // tạo tại helpers với nội dung trả về là link của trang admin
				$this->_check_login(); // dùng để kiểm tra xem quản trị viên đã đăng nhập chưa.
				$login = $this->session->userdata('login'); // lấy dữ liệu từ session
				$this->load->model('admin_model'); // phần này các bạn có thể xem tại đây!
				$admin_info = $this->admin_model->get_info($login['id']);
				$this->data['admin_info'] = $admin_info;
				break;
			default:
				$this->load->model('catalog_model');
				$input = array();
				$input['where'] = array('parent_id' => 0);
				$catalog_list = $this->catalog_model->get_list($input);
				foreach ($catalog_list as $row) {
					$input['where'] = array(
						'parent_id' => $row->id
					);
					$subs = $this->catalog_model->get_list($input);
					$row->subs = $subs;
				}
				$this->data['catalog_list'] = $catalog_list;
				$this->load->model('news_model');
				$input = array();
				$input['limit'] = array(5, 0);
				$news_list = $this->news_model->get_list($input);
				$this->data['news_list'] = $news_list;
		}
	}
	private function _check_login()
	{
		$controller = $this->uri->rsegment(1);
		$controller = strtolower($controller);
		$login = $this->session->userdata('login');
		//neu ma chua dang nhap,ma truy cap 1 controller khac login
		if (!$login && $controller != 'login') {
			redirect(admin_url('login'));
		}
		//neu ma admin da dang nhap thi khong cho phep vao trang login nua.
		if ($login && $controller == 'login') {
			redirect(admin_url('home'));
		}
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */