<?php
class ControllerCardCard extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('card/card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('card/card');

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'card_name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_product_limit');
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$data['cards'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_product_limit'),
			'limit'           => $this->config->get('config_product_limit')
		);

		$this->load->model('tool/image');

		$card_total = $this->model_card_card->getTotalCards($filter_data);

		$results = $this->model_card_card->getCards($filter_data); 

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . "catalog/cards/".$result['image'])) {
				$image = $this->model_tool_image->resize("catalog/cards/".$result['image'], 150, 100);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 150, 100);
			}
			
			$href ="";
			if($result['quantity'] >= 0){
				$href = $this->url->link('checkout/cart', '', 'SSL');
			}
			
			$data['cards'][] = array(
				'card_id' 	 => $result['card_id'],
				'image'      => $image,
				'name'       => $result['card_name'],
				'price'      => $this->currency->format($result['price']),
				'quantity'   => $result['quantity'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'href'		 => $href	
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
	
		$data['text_no_results'] = $this->language->get('text_no_results');
	
		$data['entry_name'] = $this->language->get('entry_name');
		
		$data['button_filter'] = $this->language->get('button_filter');
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
		
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}
		if ($this->config->get('config_customer_price') && !$this->customer->isLogged()) {
			$data['attention'] = sprintf($this->language->get('text_login'), $this->url->link('account/login'), $this->url->link('account/register'));
		} else {
			$data['attention'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		/*
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		*/
		/*
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
*/
		
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
		
		$pagination = new Pagination();
		$pagination->total = $card_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_product_limit');
		$pagination->url = $this->url->link('card/card',  $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($card_total) ? (($page - 1) * $this->config->get('config_product_limit')) + 1 : 0, ((($page - 1) * $this->config->get('config_product_limit')) > ($card_total - $this->config->get('config_product_limit'))) ? $card_total : ((($page - 1) * $this->config->get('config_product_limit')) + $this->config->get('config_product_limit')), $card_total, ceil($card_total / $this->config->get('config_product_limit')));

		$data['filter_name'] = $filter_name;
		
		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('account/column_left');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/card/card_list.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/card/card_list.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/card/card_list.tpl', $data));
		}
		
	}
}