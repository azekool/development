<?php
class ControllerCheckoutCart extends Controller {
	public function index() {
		$this->load->language('checkout/cart');

		$this->document->setTitle($this->language->get('heading_title'));
		/*
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('common/home'),
			'text' => $this->language->get('text_home')
		);

		$data['breadcrumbs'][] = array(
			'href' => $this->url->link('checkout/cart'),
			'text' => $this->language->get('heading_title')
		);
		*/
		if ($this->cart->hasCards() /*|| !empty($this->session->data['vouchers'])*/) {
			$data['heading_title'] = $this->language->get('heading_title');

			//$data['text_recurring'] = $this->language->get('text_recurring');
			//$data['text_length'] = $this->language->get('text_length');
			//$data['text_recurring_item'] = $this->language->get('text_recurring_item');
			$data['text_next'] = $this->language->get('text_next');
			$data['text_next_choice'] = $this->language->get('text_next_choice');

			$data['column_image'] = $this->language->get('column_image');
			$data['column_name'] = $this->language->get('column_name');
			$data['column_model'] = $this->language->get('column_model');
			$data['column_quantity'] = $this->language->get('column_quantity');
			$data['column_price'] = $this->language->get('column_price');
			$data['column_total'] = $this->language->get('column_total');

			$data['button_update'] = $this->language->get('button_update');
			$data['button_remove'] = $this->language->get('button_remove');
			$data['button_shopping'] = $this->language->get('button_shopping');
			$data['button_checkout'] = $this->language->get('button_checkout');

			if (!$this->cart->hasStock() && (!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning'))) {
				$data['error_warning'] = $this->language->get('error_stock');
			} elseif (isset($this->session->data['error'])) {
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

			if (isset($this->session->data['success'])) {
				$data['success'] = $this->session->data['success'];

				unset($this->session->data['success']);
			} else {
				$data['success'] = '';
			}

			$data['action'] = $this->url->link('checkout/cart/edit');

			//if ($this->config->get('config_cart_weight')) {
			//	$data['weight'] = $this->weight->format($this->cart->getWeight(), $this->config->get('config_weight_class_id'), $this->language->get('decimal_point'), $this->language->get('thousand_point'));
			//} else {
			//	$data['weight'] = '';
			//}

			$this->load->model('tool/image');
			//$this->load->model('tool/upload');

			$data['cards'] = array();

			$cards = $this->cart->getCards();

			foreach ($cards as $card) {
				$card_total = 0;

				foreach ($cards as $card_2) {
					if ($card_2['card_id'] == $card['card_id']) {
						$card_total += $card_2['quantity'];
					}
				}
				
				/**
				 * @TODO daily limit check
				 *       customer credit check
				 */

				//if ($card['minimum'] > $card_total) {
				//	$data['error_warning'] = sprintf($this->language->get('error_minimum'), $card['name'], $card['minimum']);
				//}

				if ($card['image']) {
					$image = $this->model_tool_image->resize("catalog/cards/".$card['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
				} else {
					$image = '';
				}
				/*				
				$option_data = array();

				foreach ($card['option'] as $option) {
					if ($option['type'] != 'file') {
						$value = $option['value'];
					} else {
						$upload_info = $this->model_tool_upload->getUploadByCode($option['value']);

						if ($upload_info) {
							$value = $upload_info['name'];
						} else {
							$value = '';
						}
					}

					$option_data[] = array(
						'name'  => $option['name'],
						'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
					);
				}
				*/
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($card['price']/*$this->tax->calculate($card['price'], $card['tax_class_id'], $this->config->get('config_tax'))*/);
				} else {
					$price = false;
				}

				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$total = $this->currency->format($card['price']* $card['quantity']/*$this->tax->calculate($card['price'], $card['tax_class_id'], $this->config->get('config_tax')) * $card['quantity']*/);
				} else {
					$total = false;
				}
				/*
				$recurring = '';

				if ($card['recurring']) {
					$frequencies = array(
						'day'        => $this->language->get('text_day'),
						'week'       => $this->language->get('text_week'),
						'semi_month' => $this->language->get('text_semi_month'),
						'month'      => $this->language->get('text_month'),
						'year'       => $this->language->get('text_year'),
					);

					if ($card['recurring']['trial']) {
						$recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($card['recurring']['trial_price'] * $card['quantity'], $card['tax_class_id'], $this->config->get('config_tax'))), $card['recurring']['trial_cycle'], $frequencies[$card['recurring']['trial_frequency']], $card['recurring']['trial_duration']) . ' ';
					}

					if ($card['recurring']['duration']) {
						$recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($card['recurring']['price'] * $card['quantity'], $card['tax_class_id'], $this->config->get('config_tax'))), $card['recurring']['cycle'], $frequencies[$card['recurring']['frequency']], $card['recurring']['duration']);
					} else {
						$recurring .= sprintf($this->language->get('text_payment_until_canceled_description'), $this->currency->format($this->tax->calculate($card['recurring']['price'] * $card['quantity'], $card['tax_class_id'], $this->config->get('config_tax'))), $card['recurring']['cycle'], $frequencies[$card['recurring']['frequency']], $card['recurring']['duration']);
					}
				}
				*/
				$data['cards'][] = array(
					'key'       => $card['key'],
					'thumb'     => $image,
					'name'      => $card['name'],
					//'model'     => $card['model'],
					//'option'    => $option_data,
					//'recurring' => $recurring,
					'quantity'  => $card['quantity'],
					'stock'     => $card['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
					//'reward'    => ($card['reward'] ? sprintf($this->language->get('text_points'), $card['reward']) : ''),
					'price'     => $price,
					'total'     => $total,
					'href'      => $this->url->link('card/card', 'card_id=' . $card['card_id'])
				);
			}

			// Gift Voucher
			/*$data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $key => $voucher) {
					$data['vouchers'][] = array(
						'key'         => $key,
						'description' => $voucher['description'],
						'amount'      => $this->currency->format($voucher['amount']),
						'remove'      => $this->url->link('checkout/cart', 'remove=' . $key)
					);
				}
			}
			*/
			
			// Totals
			//$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			$taxes = array();//$this->cart->getTaxes();

			// Display prices
			
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();
				/*
				$results = $this->model_extension_extension->getExtensions('total');

				foreach ($results as $key => $value) {
					$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
				}

				array_multisort($sort_order, SORT_ASC, $results);

				foreach ($results as $result) {
					if ($this->config->get($result['code'] . '_status')) {
						$this->load->model('total/' . $result['code']);

						$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
					}
				}
				*/
				$this->load->model('total/sub_total');
				$this->model_total_sub_total->getTotal($total_data, $total, $taxes);
					
				$this->load->model('total/provision');
				$this->model_total_provision->getTotal($total_data, $total, $taxes);
					
				$this->load->model('total/total');
				$this->model_total_total->getTotal($total_data, $total, $taxes);
				
				$sort_order = array();

				foreach ($total_data as $key => $value) {
					$sort_order[$key] = $value['sort_order'];
				}

				array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$data['totals'] = array();

			foreach ($total_data as $total) {
				$data['totals'][] = array(
					'title' => $total['title'],
					'text'  => $this->currency->format($total['value'])
				);
			}

			$data['continue'] = $this->url->link('card/card');

			$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

			//$this->load->model('extension/extension');

			$data['checkout_buttons'] = array();

			//$data['coupon'] = $this->load->controller('checkout/coupon');
			//$data['voucher'] = $this->load->controller('checkout/voucher');
			//$data['reward'] = $this->load->controller('checkout/reward');
			//$data['shipping'] = $this->load->controller('checkout/shipping');
			$data['column_left'] = $this->load->controller('account/column_left');
			//$data['column_right'] = $this->load->controller('common/column_right');
			//$data['content_top'] = $this->load->controller('common/content_top');
			//$data['content_bottom'] = $this->load-	>controller('common/content_bottom');
			//$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/cart.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/checkout/cart.tpl', $data));
			}
		} else {
			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_error'] = $this->language->get('text_empty');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('card/card');

			unset($this->session->data['success']);

			$data['column_left'] = $this->load->controller('account/column_left');
			//$data['column_right'] = $this->load->controller('common/column_right');
			//$data['content_top'] = $this->load->controller('common/content_top');
			//$data['content_bottom'] = $this->load->controller('common/content_bottom');
			//$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}
		}
	}

	public function add() {
		$this->load->language('checkout/cart');

		$json = array();

		if (isset($this->request->post['card_id'])) {
			$card_id = (int)$this->request->post['card_id'];
		} else {
			$card_id = 0;
		}

		$this->load->model('card/card');

		$card_info = $this->model_card_card->getCard($card_id);

		if ($card_info) {
			if (isset($this->request->post['quantity'])) {
				$quantity = (int)$this->request->post['quantity'];
			} else {
				$quantity = 1;
			}

			if (!$json) {
				$this->cart->add($this->request->post['card_id'], $this->request->post['quantity']);

				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('card/card', 'card_id=' . $this->request->post['card_id']), $card_info['card_name'], $this->url->link('checkout/cart'));
				/*
				unset($this->session->data['shipping_method']);
				unset($this->session->data['shipping_methods']);
				unset($this->session->data['payment_method']);
				unset($this->session->data['payment_methods']);
				
				// Totals
				$this->load->model('extension/extension');
				*/
				$total_data = array();
				$total = 0;
				
				$taxes = array();//$this->cart->getTaxes();
				
				// Display prices
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$sort_order = array();

					//$results = $this->model_extension_extension->getExtensions('total');

					//foreach ($results as $key => $value) {
						//$sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
					//}

					//array_multisort($sort_order, SORT_ASC, $results);
					/*
					foreach ($results as $result) {
						if ($this->config->get($result['code'] . '_status')) {
							$this->load->model('total/' . $result['code']);

							$this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
						}
					}
					*/
					$this->load->model('total/sub_total');
					$this->model_total_sub_total->getTotal($total_data, $total, $taxes);
					
					$this->load->model('total/provision');
					$this->model_total_provision->getTotal($total_data, $total, $taxes);
					
					$this->load->model('total/total');
					$this->model_total_total->getTotal($total_data, $total, $taxes);
					
					$sort_order = array();

					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data);
				}

				//$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countCards() , $this->currency->format($total));
				$json['redirect'] = $this->url->link('checkout/cart', '', 'SSL');
			} else {
				$json['redirect'] = str_replace('&amp;', '&', $this->url->link('checkout/cart', 'card_id=' . $this->request->post['card_id']));
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function edit() {
		$this->load->language('checkout/cart');

		$json = array();

		// Update
		if (!empty($this->request->post['quantity'])) {
			foreach ($this->request->post['quantity'] as $key => $value) {
				$this->cart->update($key, $value);
			}
/*
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
*/
			$this->response->redirect($this->url->link('checkout/cart'));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function remove() {
		$this->load->language('checkout/cart');

		$json = array();

		// Remove
		if (isset($this->request->post['key'])) {
			$this->cart->remove($this->request->post['key']);

			//unset($this->session->data['vouchers'][$this->request->post['key']]);

			$this->session->data['success'] = $this->language->get('text_remove');
			/*
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['reward']);
			*/
			// Totals
			//$this->load->model('extension/extension');

			$total_data = array();
			$total = 0;
			//$taxes = $this->cart->getTaxes();

			// Display prices
			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$sort_order = array();

				//$results = $this->model_extension_extension->getExtensions('total');

					$this->load->model('total/sub_total');
					$this->model_total_sub_total->getTotal($total_data, $total, $taxes);
					
					$this->load->model('total/provision');
					$this->model_total_provision->getTotal($total_data, $total, $taxes);
					
					$this->load->model('total/total');
					$this->model_total_total->getTotal($total_data, $total, $taxes);
					
					$sort_order = array();

					foreach ($total_data as $key => $value) {
						$sort_order[$key] = $value['sort_order'];
					}

					array_multisort($sort_order, SORT_ASC, $total_data);
			}

			$json['total'] = sprintf($this->language->get('text_items'), $this->cart->countCards() /*+ (isset($this->session->data['vouchers']) ? count($this->session->data['vouchers']) : 0)*/, $this->currency->format($total));
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}