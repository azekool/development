<?php
class ControllerAccountColumnLeft extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
		
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		

			$data['firstname'] = $this->customer->getFirstName();
			$data['lastname'] = $this->customer->getLastName();
			$data['email'] = $this->customer->getEmail();
			$this->load->model('tool/image');
			$data['image'] = $this->model_tool_image->resize('no_image.png', 45, 45);
			$data['balance'] = $this->customer->getBalance();
			$data['menu'] = $this->load->controller('account/menu');
			$data['stats']="";
			//$data['stats'] = $this->load->controller('common/stats');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/column_left.tpl')) {
				return $this->load->view($this->config->get('config_template') . '/template/account/column_left.tpl', $data);
			} else {
				return $this->load->view('default/template/account/column_left.tpl', $data);
			}
		}
	
}