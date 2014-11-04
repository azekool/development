<?php
class ControllerCatalogCard extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('card/card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('card/card');

		$this->getList();
	}

	public function add() {
		$this->load->language('card/card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('card/card');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_card_card->addCard($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response>re-direct($this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('card/card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('card/card');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_card_card->editCard($this->request->get['card_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('card/card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('card/card');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $card_id) {
				$this->model_card_card->deleteCard($card_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('card/card');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('card/card');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $card_id) {
				$this->model_card_card->copyCard($card_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
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

			$this->response->redirect($this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		$data['insert'] = $this->url->link('card/card/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['copy'] = $this->url->link('card/card/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$data['delete'] = $this->url->link('card/card/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$data['cards'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$card_total = $this->model_card_card->getTotalCards($filter_data);

		$results = $this->model_card_card->getCards($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$card_specials = $this->model_card_card->getCardSpecials($result['card_id']);

			foreach ($card_specials  as $card_special) {
				if (($card_special['date_start'] == '0000-00-00' || $card_special['date_start'] < date('Y-m-d')) && ($card_special['date_end'] == '0000-00-00' || $card_special['date_end'] > date('Y-m-d'))) {
					$special = $card_special['price'];

					break;
				}
			}

			$data['cards'][] = array(
				'card_id' => $result['card_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => ($result['status']) ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('card/card/edit', 'token=' . $this->session->data['token'] . '&card_id=' . $result['card_id'] . $url, 'SSL')
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_status'] = $this->language->get('entry_status');

		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_insert'] = $this->language->get('button_insert');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

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

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('card/card', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, 'SSL');
		$data['sort_price'] = $this->url->link('card/card', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, 'SSL');
		$data['sort_quantity'] = $this->url->link('card/card', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, 'SSL');
		$data['sort_status'] = $this->url->link('card/card', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, 'SSL');
		$data['sort_order'] = $this->url->link('card/card', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $card_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('card/card', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($card_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($card_total - $this->config->get('config_limit_admin'))) ? $card_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $card_total, ceil($card_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('card/card_list.tpl', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');
		
		$data['text_form'] = !isset($this->request->get['card_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_subtract'] = $this->language->get('entry_subtract');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length_class'] = $this->language->get('entry_length_class');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_recurring'] = $this->language->get('entry_recurring');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_sku'] = $this->language->get('help_sku');
		$data['help_upc'] = $this->language->get('help_upc');
		$data['help_ean'] = $this->language->get('help_ean');
		$data['help_jan'] = $this->language->get('help_jan');
		$data['help_isbn'] = $this->language->get('help_isbn');
		$data['help_mpn'] = $this->language->get('help_mpn');
		$data['help_minimum'] = $this->language->get('help_minimum');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_stock_status'] = $this->language->get('help_stock_status');
		$data['help_points'] = $this->language->get('help_points');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_download'] = $this->language->get('help_download');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_recurring_add'] = $this->language->get('button_recurring_add');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_recurring'] = $this->language->get('tab_recurring');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['date_available'])) {
			$data['error_date_available'] = $this->error['date_available'];
		} else {
			$data['error_date_available'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
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

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL')
		);

		if (!isset($this->request->get['card_id'])) {
			$data['action'] = $this->url->link('card/card/add', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$data['action'] = $this->url->link('card/card/edit', 'token=' . $this->session->data['token'] . '&card_id=' . $this->request->get['card_id'] . $url, 'SSL');
		}

		$data['cancel'] = $this->url->link('card/card', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['card_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$card_info = $this->model_card_card->getCard($this->request->get['card_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['card_description'])) {
			$data['card_description'] = $this->request->post['card_description'];
		} elseif (isset($this->request->get['card_id'])) {
			$data['card_description'] = $this->model_card_card->getCardDescriptions($this->request->get['card_id']);
		} else {
			$data['card_description'] = array();
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($card_info)) {
			$data['image'] = $card_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($card_info) && is_file(DIR_IMAGE . $card_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($card_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($card_info)) {
			$data['model'] = $card_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($card_info)) {
			$data['sku'] = $card_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($card_info)) {
			$data['upc'] = $card_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($card_info)) {
			$data['ean'] = $card_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($card_info)) {
			$data['jan'] = $card_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($card_info)) {
			$data['isbn'] = $card_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($card_info)) {
			$data['mpn'] = $card_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($card_info)) {
			$data['location'] = $card_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['card_store'])) {
			$data['card_store'] = $this->request->post['card_store'];
		} elseif (isset($this->request->get['card_id'])) {
			$data['card_store'] = $this->model_card_card->getCardStores($this->request->get['card_id']);
		} else {
			$data['card_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($card_info)) {
			$data['keyword'] = $card_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($card_info)) {
			$data['shipping'] = $card_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($card_info)) {
			$data['price'] = $card_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('card/recurring');

		$data['recurrings'] = $this->model_card_recurring->getRecurrings();

		if (isset($this->request->post['card_recurrings'])) {
			$data['card_recurrings'] = $this->request->post['card_recurrings'];
		} elseif (!empty($card_info)) {
			$data['card_recurrings'] = $this->model_card_card->getRecurrings($card_info['card_id']);
		} else {
			$data['card_recurrings'] = array();
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($card_info)) {
			$data['tax_class_id'] = $card_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($card_info)) {
			$data['date_available'] = ($card_info['date_available'] != '0000-00-00') ? $card_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($card_info)) {
			$data['quantity'] = $card_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($card_info)) {
			$data['minimum'] = $card_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($card_info)) {
			$data['subtract'] = $card_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($card_info)) {
			$data['sort_order'] = $card_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($card_info)) {
			$data['stock_status_id'] = $card_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($card_info)) {
			$data['status'] = $card_info['status'];
		} else {
			$data['status'] = 1;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($card_info)) {
			$data['weight'] = $card_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($card_info)) {
			$data['weight_class_id'] = $card_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($card_info)) {
			$data['length'] = $card_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($card_info)) {
			$data['width'] = $card_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($card_info)) {
			$data['height'] = $card_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($card_info)) {
			$data['length_class_id'] = $card_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('card/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($card_info)) {
			$data['manufacturer_id'] = $card_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($card_info)) {
			$manufacturer_info = $this->model_card_manufacturer->getManufacturer($card_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('card/category');

		if (isset($this->request->post['card_category'])) {
			$categories = $this->request->post['card_category'];
		} elseif (isset($this->request->get['card_id'])) {
			$categories = $this->model_card_card->getCardCategories($this->request->get['card_id']);
		} else {
			$categories = array();
		}

		$data['card_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_card_category->getCategory($category_id);

			if ($category_info) {
				$data['card_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name' => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('card/filter');

		if (isset($this->request->post['card_filter'])) {
			$filters = $this->request->post['card_filter'];
		} elseif (isset($this->request->get['card_id'])) {
			$filters = $this->model_card_card->getCardFilters($this->request->get['card_id']);
		} else {
			$filters = array();
		}

		$data['card_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_card_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['card_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('card/attribute');

		if (isset($this->request->post['card_attribute'])) {
			$card_attributes = $this->request->post['card_attribute'];
		} elseif (isset($this->request->get['card_id'])) {
			$card_attributes = $this->model_card_card->getCardAttributes($this->request->get['card_id']);
		} else {
			$card_attributes = array();
		}

		$data['card_attributes'] = array();

		foreach ($card_attributes as $card_attribute) {
			$attribute_info = $this->model_card_attribute->getAttribute($card_attribute['attribute_id']);

			if ($attribute_info) {
				$data['card_attributes'][] = array(
					'attribute_id'                  => $card_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'card_attribute_description' => $card_attribute['card_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('card/option');

		if (isset($this->request->post['card_option'])) {
			$card_options = $this->request->post['card_option'];
		} elseif (isset($this->request->get['card_id'])) {
			$card_options = $this->model_card_card->getCardOptions($this->request->get['card_id']);
		} else {
			$card_options = array();
		}

		$data['card_options'] = array();

		foreach ($card_options as $card_option) {
			$card_option_value_data = array();

			if (isset($card_option['card_option_value'])) {
				foreach ($card_option['card_option_value'] as $card_option_value) {
					$card_option_value_data[] = array(
						'card_option_value_id' => $card_option_value['card_option_value_id'],
						'option_value_id'         => $card_option_value['option_value_id'],
						'quantity'                => $card_option_value['quantity'],
						'subtract'                => $card_option_value['subtract'],
						'price'                   => $card_option_value['price'],
						'price_prefix'            => $card_option_value['price_prefix'],
						'points'                  => $card_option_value['points'],
						'points_prefix'           => $card_option_value['points_prefix'],
						'weight'                  => $card_option_value['weight'],
						'weight_prefix'           => $card_option_value['weight_prefix']
					);
				}
			}

			$data['card_options'][] = array(
				'card_option_id'    => $card_option['card_option_id'],
				'card_option_value' => $card_option_value_data,
				'option_id'            => $card_option['option_id'],
				'name'                 => $card_option['name'],
				'type'                 => $card_option['type'],
				'value'                => isset($card_option['value']) ? $card_option['value'] : '',
				'required'             => $card_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['card_options'] as $card_option) {
			if ($card_option['type'] == 'select' || $card_option['type'] == 'radio' || $card_option['type'] == 'checkbox' || $card_option['type'] == 'image') {
				if (!isset($data['option_values'][$card_option['option_id']])) {
					$data['option_values'][$card_option['option_id']] = $this->model_card_option->getOptionValues($card_option['option_id']);
				}
			}
		}

		$this->load->model('sale/customer_group');

		$data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		if (isset($this->request->post['card_discount'])) {
			$card_discounts = $this->request->post['card_discount'];
		} elseif (isset($this->request->get['card_id'])) {
			$card_discounts = $this->model_card_card->getCardDiscounts($this->request->get['card_id']);
		} else {
			$card_discounts = array();
		}

		$data['card_discounts'] = array();

		foreach ($card_discounts as $card_discount) {
			$data['card_discounts'][] = array(
				'customer_group_id' => $card_discount['customer_group_id'],
				'quantity'          => $card_discount['quantity'],
				'priority'          => $card_discount['priority'],
				'price'             => $card_discount['price'],
				'date_start'        => ($card_discount['date_start'] != '0000-00-00') ? $card_discount['date_start'] : '',
				'date_end'          => ($card_discount['date_end'] != '0000-00-00') ? $card_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['card_special'])) {
			$card_specials = $this->request->post['card_special'];
		} elseif (isset($this->request->get['card_id'])) {
			$card_specials = $this->model_card_card->getCardSpecials($this->request->get['card_id']);
		} else {
			$card_specials = array();
		}

		$data['card_specials'] = array();

		foreach ($card_specials as $card_special) {
			$data['card_specials'][] = array(
				'customer_group_id' => $card_special['customer_group_id'],
				'priority'          => $card_special['priority'],
				'price'             => $card_special['price'],
				'date_start'        => ($card_special['date_start'] != '0000-00-00') ? $card_special['date_start'] : '',
				'date_end'          => ($card_special['date_end'] != '0000-00-00') ? $card_special['date_end'] :  ''
			);
		}

		// Images
		if (isset($this->request->post['card_image'])) {
			$card_images = $this->request->post['card_image'];
		} elseif (isset($this->request->get['card_id'])) {
			$card_images = $this->model_card_card->getCardImages($this->request->get['card_id']);
		} else {
			$card_images = array();
		}

		$data['card_images'] = array();

		foreach ($card_images as $card_image) {
			if (is_file(DIR_IMAGE . $card_image['image'])) {
				$image = $card_image['image'];
				$thumb = $card_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['card_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $card_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('card/download');

		if (isset($this->request->post['card_download'])) {
			$card_downloads = $this->request->post['card_download'];
		} elseif (isset($this->request->get['card_id'])) {
			$card_downloads = $this->model_card_card->getCardDownloads($this->request->get['card_id']);
		} else {
			$card_downloads = array();
		}

		$data['card_downloads'] = array();

		foreach ($card_downloads as $download_id) {
			$download_info = $this->model_card_download->getDownload($download_id);

			if ($download_info) {
				$data['card_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['card_related'])) {
			$cards = $this->request->post['card_related'];
		} elseif (isset($this->request->get['card_id'])) {
			$cards = $this->model_card_card->getCardRelated($this->request->get['card_id']);
		} else {
			$cards = array();
		}

		$data['card_relateds'] = array();

		foreach ($cards as $card_id) {
			$related_info = $this->model_card_card->getCard($card_id);

			if ($related_info) {
				$data['card_relateds'][] = array(
					'card_id' => $related_info['card_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($card_info)) {
			$data['points'] = $card_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['card_reward'])) {
			$data['card_reward'] = $this->request->post['card_reward'];
		} elseif (isset($this->request->get['card_id'])) {
			$data['card_reward'] = $this->model_card_card->getCardRewards($this->request->get['card_id']);
		} else {
			$data['card_reward'] = array();
		}

		if (isset($this->request->post['card_layout'])) {
			$data['card_layout'] = $this->request->post['card_layout'];
		} elseif (isset($this->request->get['card_id'])) {
			$data['card_layout'] = $this->model_card_card->getCardLayouts($this->request->get['card_id']);
		} else {
			$data['card_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('card/card_form.tpl', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'card/card')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['card_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'card/card')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'card/card')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('card/card');
			$this->load->model('card/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_card_card->getCards($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$card_options = $this->model_card_card->getCardOptions($result['card_id']);

				foreach ($card_options as $card_option) {
					$option_info = $this->model_card_option->getOption($card_option['option_id']);

					if ($option_info) {
						$card_option_value_data = array();

						foreach ($card_option['card_option_value'] as $card_option_value) {
							$option_value_info = $this->model_card_option->getOptionValue($card_option_value['option_value_id']);

							if ($option_value_info) {
								$card_option_value_data[] = array(
									'card_option_value_id' => $card_option_value['card_option_value_id'],
									'option_value_id'         => $card_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$card_option_value['price'] ? $this->currency->format($card_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $card_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'card_option_id'    => $card_option['card_option_id'],
							'card_option_value' => $card_option_value_data,
							'option_id'            => $card_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $card_option['value'],
							'required'             => $card_option['required']
						);
					}
				}

				$json[] = array(
					'card_id' => $result['card_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}