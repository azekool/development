<?php
class ControllerAccountMenu extends Controller {
	public function index() {
		
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/account', '', 'SSL');
			$this->response->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->load->language('account/menu');
		
		//main category
		$data['text_dashboard'] = $this->language->get('text_dashboard');
		$data['text_card'] = $this->language->get('text_card');
		$data['text_sales'] = $this->language->get('text_sales');
		$data['text_bookings'] = $this->language->get('text_bookings');
		$data['text_invoices'] = $this->language->get('text_invoices');
		$data['text_reports'] = $this->language->get('text_reports');
		$data['text_system'] = $this->language->get('text_system');
		$data['text_setting'] = $this->language->get('text_setting');
		
		
		$data['account'] =  $this->url->link('account/account', '', 'SSL');
		$data['card'] = $this->url->link('card/card', '', 'SSL');
		$data['sale'] = $this->url->link('sale/sale', '', 'SSL');
		$data['booking'] = $this->url->link('booking/booking', '', 'SSL');
		$data['invoice'] = $this->url->link('invoice/invoice', '', 'SSL');
		$data['report'] = $this->url->link('report/report', '', 'SSL');
		$data['setting'] = $this->url->link('setting/setting', '', 'SSL');
		
		
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/menu.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/account/menu.tpl', $data);
		} else {
			return $this->load->view('default/template/account/menu.tpl', $data);
		}
		
	}
}