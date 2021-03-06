<?php
class ControllerTransactionTransaction extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('transaction/transaction');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');

		$this->getList();
	}

	public function add() {
		$this->load->language('transaction/transaction');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_transaction_transaction->addTransaction($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('transaction/transaction');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_transaction_transaction->editTransaction($this->request->get['transaction_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('transaction/transaction');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('transaction/transaction');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $transaction_id) {
				$this->model_transaction_transaction->deleteTransaction($transaction_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'ad.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$filter_customer = $this->request->get['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = '';
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = '';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode($this->request->get['filter_customer']);
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['insert'] = $this->url->link('transaction/transaction/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('transaction/transaction/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['transactions'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'filter_customer'   => $filter_customer,
			'filter_date_start'	=> $filter_date_start,
			'filter_date_end'	=> $filter_date_end,
			'limit' => $this->config->get('config_limit_admin')
		);

		$transaction_total = $this->model_transaction_transaction->getTotalTransactions();

		$results = $this->model_transaction_transaction->getTransactions($filter_data);

		foreach ($results as $result) {
			$data['transactions'][] = array(
				'transaction_id'     => $result['transaction_id'],
				'customer_name'      => $result['customer_name'],
				'amount'  			 => $result['amount'],
				'type_name'   		 => $result['type_name'],
				'comment'			 => $result['comment'],
				'username'			 => $result['username'],
				'edit'               => $this->url->link('transaction/transaction/edit', 'token=' . $this->session->data['token'] . '&transaction_id=' . $result['transaction_id'] . $url, 'SSL')
			);
		}
		
		$data['customers'] = $this->model_transaction_transaction->getCustomers();

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_customer_name'] = $this->language->get('column_customer_name');
		$data['column_amount'] = $this->language->get('column_amount');
		$data['column_type_name'] = $this->language->get('column_type_name');
		$data['column_comment'] = $this->language->get('column_comment');
		$data['column_username'] = $this->language->get('column_username');
	
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');
		
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_customer'] = $this->language->get('entry_customer');
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_customer_name'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . '&sort=c.name' . $url, 'SSL');
		$data['sort_amount'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . '&sort=t.amount' . $url, 'SSL');
		$data['sort_type_name'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . '&sort=tt.type_name' . $url, 'SSL');
		$data['sort_comment'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . '&sort=t.comment' . $url, 'SSL');
		$data['sort_username'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . '&sort=u.username' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		
		if (isset($this->request->get['filter_customer'])) {
			$url .= '&filter_customer=' . urlencode($this->request->get['filter_customer']);
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		$pagination = new Pagination();
		$pagination->total = $transaction_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($transaction_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($transaction_total - $this->config->get('config_limit_admin'))) ? $transaction_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $transaction_total, ceil($transaction_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		$data['filter_date_start'] = $filter_date_start;
		$data['filter_date_end'] = $filter_date_end;
		$data['filter_customer'] = $filter_customer;
		
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('transaction/transaction_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['transaction_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');

		$data['entry_customer'] = $this->language->get('entry_customer');
		$data['entry_transaction_type'] = $this->language->get('entry_transaction_type');
		$data['entry_amount'] = $this->language->get('entry_amount');
		$data['entry_comment'] = $this->language->get('entry_comment');
		
		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
/*
		if (isset($this->error['customer_id'])) {
			$data['error_customer_id'] = $this->error['customer_id'];
		} else {
			$data['error_customer_id'] = array();
		}
		
		if (isset($this->error['transaction_type_id'])) {
			$data['error_transaction_type_id'] = $this->error['transaction_type_id'];
		} else {
			$data['error_transaction_type_id'] = array();
		}
*/		
		if (isset($this->error['amount'])) {
			$data['error_amount'] = $this->error['amount'];
		} else {
			$data['error_amount'] = array();
		}
		

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['transaction_id'])) {
			$data['action'] = $this->url->link('transaction/transaction/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('transaction/transaction/edit', 'token=' . $this->session->data['token'] . '&transaction_id=' . $this->request->get['transaction_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('transaction/transaction', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['transaction_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$transaction_info = $this->model_transaction_transaction->getTransaction($this->request->get['transaction_id']);
		}

		
		if (isset($this->request->post['transaction_type_id'])) {
			$data['transaction_type_id'] = $this->request->post['transaction_type_id'];
		} elseif (!empty($transaction_info)) {
			$data['transaction_type_id'] = $transaction_info['transaction_type_id'];
		} else {
			$data['transaction_type_id'] = '';
		}
		$data['transaction_types'] = $this->model_transaction_transaction->getTransactionTypes();
		
		if (isset($this->request->post['customer_id'])) {
			$data['customer_id'] = $this->request->post['customer_id'];
		} elseif (!empty($transaction_info)) {
			$data['customer_id'] = $transaction_info['customer_id'];
		} else {
			$data['customer_id'] = '';
		}
		
		$data['customers'] = $this->model_transaction_transaction->getCustomers();
		
		if (isset($this->request->post['amount'])) {
			$data['amount'] = $this->request->post['amount'];
		} elseif (!empty($transaction_info)) {
			$data['amount'] = $transaction_info['amount'];
		} else {
			$data['amount'] = '';
		}
		
		if (isset($this->request->post['comment'])) {
			$data['comment'] = $this->request->post['comment'];
		} elseif (!empty($transaction_info)) {
			$data['comment'] = $transaction_info['comment'];
		} else {
			$data['comment'] = '';
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($transaction_info)) {
			$data['sort_order'] = $transaction_info['sort_order'];
		} else {
			$data['sort_order'] = '';
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('transaction/transaction_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'transaction/transaction')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
/*
		if (!isset($this->request->post['customer_id']) || ((int)$this->request->post['customer_id']) <=0) {
			$this->error['customer_id'] = $this->language->get('error_customer_id');
		}
		
		if (!isset($this->request->post['transaction_type_id']) || ((int)$this->request->post['transaction_type_id']) <=0) {
			$this->error['transaction_type_id'] = $this->language->get('error_transaction_type_id');
		}
*/	
		if (!isset($this->request->post['amount']) || abs(((int)$this->request->post['amount'])) ==0) {
			$this->error['amount'] = $this->language->get('error_amount');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'transaction/transaction')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('transaction/product');

		foreach ($this->request->post['selected'] as $transaction_id) {
			$product_total = $this->model_transaction_product->getTotalProductsByTransactionId($transaction_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('transaction/transaction');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_transaction_transaction->getTransactions($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'transaction_id'    => $result['transaction_id'],
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'transaction_group' => $result['transaction_group']
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}