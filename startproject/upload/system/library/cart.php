<?php
class Cart {
	private $config;
	private $db;
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');

		if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
			$this->session->data['cart'] = array();
		}
	}

	public function getCards() {
		if (!$this->data) {
			foreach ($this->session->data['cart'] as $key => $quantity) {
				$card = unserialize(base64_decode($key));

				$card_id = $card['card_id'];

				$stock = true;

				$card_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card WHERE card_id = '" . (int)$card_id . "'  AND status = '1'");

				if ($card_query->num_rows) {
					$option_price = 0;
					$option_points = 0;
					$option_weight = 0;

					$option_data = array();

					$price = $card_query->row['price'];

					// Card Discounts
					$discount_quantity = 0;

					foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
						$card_2 = (array)unserialize(base64_decode($key_2));

						if ($card_2['card_id'] == $card_id) {
							$discount_quantity += $quantity_2;
						}
					}

					$card_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "card_discount WHERE card_id = '" . (int)$card_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

					if ($card_discount_query->num_rows) {
						$price = $card_discount_query->row['price'];
					}

					// Stock
					if (!$card_query->row['quantity'] || ($card_query->row['quantity'] < $quantity)) {
						$stock = false;
					}

					$this->data[$key] = array(
						'key'             => $key,
						'card_id'      => $card_query->row['card_id'],
						'name'            => $card_query->row['name'],
						'image'           => $card_query->row['image'],
						'quantity'        => $quantity,
						'stock'           => $stock,
						'price'           => $price,
						'total'           => ($price) * $quantity,
						/*'tax_class_id'    => $card_query->row['tax_class_id'],*/
					);
				} else {
					$this->remove($key);
				}
			}
		}

		return $this->data;
	}

	public function add($card_id, $qty = 1) {
		$this->data = array();

		$card['card_id'] = (int)$card_id;

		$key = base64_encode(serialize($card));

		if ((int)$qty && ((int)$qty > 0)) {
			if (!isset($this->session->data['cart'][$key])) {
				$this->session->data['cart'][$key] = (int)$qty;
			} else {
				$this->session->data['cart'][$key] += (int)$qty;
			}
		}
	}

	public function update($key, $qty) {
		$this->data = array();

		if ((int)$qty && ((int)$qty > 0) && isset($this->session->data['cart'][$key])) {
			$this->session->data['cart'][$key] = (int)$qty;
		} else {
			$this->remove($key);
		}
	}

	public function remove($key) {
		$this->data = array();

		unset($this->session->data['cart'][$key]);
	}

	public function clear() {
		$this->data = array();

		$this->session->data['cart'] = array();
	}


	public function getSubTotal() {
		$total = 0;

		foreach ($this->getCards() as $card) {
			$total += $card['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getCards() as $card) {
			if ($card['tax_class_id']) {
				$tax_rates = $this->tax->getRates($card['price'], $card['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $card['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $card['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getCards() as $card) {
			$total += $this->tax->calculate($card['price'], $card['tax_class_id'], $this->config->get('config_tax')) * $card['quantity'];
		}

		return $total;
	}

	public function countCards() {
		$card_total = 0;

		$cards = $this->getCards();

		foreach ($cards as $card) {
			$card_total += $card['quantity'];
		}

		return $card_total;
	}

	public function hasCards() {
		return count($this->session->data['cart']);
	}

	public function hasStock() {
		$stock = true;

		foreach ($this->getCards() as $card) {
			if (!$card['stock']) {
				$stock = false;
			}
		}

		return $stock;
	}
}