<?php
class ModelCardCard extends Model {
	public function addCard($data) {
		$this->event->trigger('pre.admin.add.card', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "card SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");

		$card_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "card SET image = '" . $this->db->escape($data['image']) . "' WHERE card_id = '" . (int)$card_id . "'");
		}

		foreach ($data['card_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "card_description SET card_id = '" . (int)$card_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		if (isset($data['card_store'])) {
			foreach ($data['card_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_store SET card_id = '" . (int)$card_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		if (isset($data['card_attribute'])) {
			foreach ($data['card_attribute'] as $card_attribute) {
				if ($card_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "card_attribute WHERE card_id = '" . (int)$card_id . "' AND attribute_id = '" . (int)$card_attribute['attribute_id'] . "'");

					foreach ($card_attribute['card_attribute_description'] as $language_id => $card_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "card_attribute SET card_id = '" . (int)$card_id . "', attribute_id = '" . (int)$card_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($card_attribute_description['text']) . "'");
					}
				}
			}
		}

		if (isset($data['card_option'])) {
			foreach ($data['card_option'] as $card_option) {
				if ($card_option['type'] == 'select' || $card_option['type'] == 'radio' || $card_option['type'] == 'checkbox' || $card_option['type'] == 'image') {
					if (isset($card_option['card_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "card_option SET card_id = '" . (int)$card_id . "', option_id = '" . (int)$card_option['option_id'] . "', required = '" . (int)$card_option['required'] . "'");

						$card_option_id = $this->db->getLastId();

						foreach ($card_option['card_option_value'] as $card_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "card_option_value SET card_option_id = '" . (int)$card_option_id . "', card_id = '" . (int)$card_id . "', option_id = '" . (int)$card_option['option_id'] . "', option_value_id = '" . (int)$card_option_value['option_value_id'] . "', quantity = '" . (int)$card_option_value['quantity'] . "', subtract = '" . (int)$card_option_value['subtract'] . "', price = '" . (float)$card_option_value['price'] . "', price_prefix = '" . $this->db->escape($card_option_value['price_prefix']) . "', points = '" . (int)$card_option_value['points'] . "', points_prefix = '" . $this->db->escape($card_option_value['points_prefix']) . "', weight = '" . (float)$card_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($card_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "card_option SET card_id = '" . (int)$card_id . "', option_id = '" . (int)$card_option['option_id'] . "', value = '" . $this->db->escape($card_option['value']) . "', required = '" . (int)$card_option['required'] . "'");
				}
			}
		}

		if (isset($data['card_discount'])) {
			foreach ($data['card_discount'] as $card_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_discount SET card_id = '" . (int)$card_id . "', customer_group_id = '" . (int)$card_discount['customer_group_id'] . "', quantity = '" . (int)$card_discount['quantity'] . "', priority = '" . (int)$card_discount['priority'] . "', price = '" . (float)$card_discount['price'] . "', date_start = '" . $this->db->escape($card_discount['date_start']) . "', date_end = '" . $this->db->escape($card_discount['date_end']) . "'");
			}
		}

		if (isset($data['card_special'])) {
			foreach ($data['card_special'] as $card_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_special SET card_id = '" . (int)$card_id . "', customer_group_id = '" . (int)$card_special['customer_group_id'] . "', priority = '" . (int)$card_special['priority'] . "', price = '" . (float)$card_special['price'] . "', date_start = '" . $this->db->escape($card_special['date_start']) . "', date_end = '" . $this->db->escape($card_special['date_end']) . "'");
			}
		}

		if (isset($data['card_image'])) {
			foreach ($data['card_image'] as $card_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_image SET card_id = '" . (int)$card_id . "', image = '" . $this->db->escape($card_image['image']) . "', sort_order = '" . (int)$card_image['sort_order'] . "'");
			}
		}

		if (isset($data['card_download'])) {
			foreach ($data['card_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_download SET card_id = '" . (int)$card_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		if (isset($data['card_category'])) {
			foreach ($data['card_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_category SET card_id = '" . (int)$card_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		if (isset($data['card_filter'])) {
			foreach ($data['card_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_filter SET card_id = '" . (int)$card_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		if (isset($data['card_related'])) {
			foreach ($data['card_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$card_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_related SET card_id = '" . (int)$card_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$related_id . "' AND related_id = '" . (int)$card_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_related SET card_id = '" . (int)$related_id . "', related_id = '" . (int)$card_id . "'");
			}
		}

		if (isset($data['card_reward'])) {
			foreach ($data['card_reward'] as $customer_group_id => $card_reward) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_reward SET card_id = '" . (int)$card_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$card_reward['points'] . "'");
			}
		}

		if (isset($data['card_layout'])) {
			foreach ($data['card_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_layout SET card_id = '" . (int)$card_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		if (isset($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'card_id=" . (int)$card_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		if (isset($data['card_recurrings'])) {
			foreach ($data['card_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "card_recurring` SET `card_id` = " . (int)$card_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('card');

		$this->event->trigger('post.admin.add.card', $card_id);

		return $card_id;
	}

	public function editCard($card_id, $data) {
		$this->event->trigger('pre.admin.edit.card', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "card SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . $this->db->escape($data['tax_class_id']) . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "card SET image = '" . $this->db->escape($data['image']) . "' WHERE card_id = '" . (int)$card_id . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_description WHERE card_id = '" . (int)$card_id . "'");

		foreach ($data['card_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "card_description SET card_id = '" . (int)$card_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', tag = '" . $this->db->escape($value['tag']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_store WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_store'])) {
			foreach ($data['card_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_store SET card_id = '" . (int)$card_id . "', store_id = '" . (int)$store_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_attribute WHERE card_id = '" . (int)$card_id . "'");

		if (!empty($data['card_attribute'])) {
			foreach ($data['card_attribute'] as $card_attribute) {
				if ($card_attribute['attribute_id']) {
					$this->db->query("DELETE FROM " . DB_PREFIX . "card_attribute WHERE card_id = '" . (int)$card_id . "' AND attribute_id = '" . (int)$card_attribute['attribute_id'] . "'");

					foreach ($card_attribute['card_attribute_description'] as $language_id => $card_attribute_description) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "card_attribute SET card_id = '" . (int)$card_id . "', attribute_id = '" . (int)$card_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($card_attribute_description['text']) . "'");
					}
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_option WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_option_value WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_option'])) {
			foreach ($data['card_option'] as $card_option) {
				if ($card_option['type'] == 'select' || $card_option['type'] == 'radio' || $card_option['type'] == 'checkbox' || $card_option['type'] == 'image') {
					if (isset($card_option['card_option_value'])) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "card_option SET card_option_id = '" . (int)$card_option['card_option_id'] . "', card_id = '" . (int)$card_id . "', option_id = '" . (int)$card_option['option_id'] . "', required = '" . (int)$card_option['required'] . "'");

						$card_option_id = $this->db->getLastId();

						foreach ($card_option['card_option_value'] as $card_option_value) {
							$this->db->query("INSERT INTO " . DB_PREFIX . "card_option_value SET card_option_value_id = '" . (int)$card_option_value['card_option_value_id'] . "', card_option_id = '" . (int)$card_option_id . "', card_id = '" . (int)$card_id . "', option_id = '" . (int)$card_option['option_id'] . "', option_value_id = '" . (int)$card_option_value['option_value_id'] . "', quantity = '" . (int)$card_option_value['quantity'] . "', subtract = '" . (int)$card_option_value['subtract'] . "', price = '" . (float)$card_option_value['price'] . "', price_prefix = '" . $this->db->escape($card_option_value['price_prefix']) . "', points = '" . (int)$card_option_value['points'] . "', points_prefix = '" . $this->db->escape($card_option_value['points_prefix']) . "', weight = '" . (float)$card_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($card_option_value['weight_prefix']) . "'");
						}
					}
				} else {
					$this->db->query("INSERT INTO " . DB_PREFIX . "card_option SET card_option_id = '" . (int)$card_option['card_option_id'] . "', card_id = '" . (int)$card_id . "', option_id = '" . (int)$card_option['option_id'] . "', value = '" . $this->db->escape($card_option['value']) . "', required = '" . (int)$card_option['required'] . "'");
				}
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_discount WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_discount'])) {
			foreach ($data['card_discount'] as $card_discount) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_discount SET card_id = '" . (int)$card_id . "', customer_group_id = '" . (int)$card_discount['customer_group_id'] . "', quantity = '" . (int)$card_discount['quantity'] . "', priority = '" . (int)$card_discount['priority'] . "', price = '" . (float)$card_discount['price'] . "', date_start = '" . $this->db->escape($card_discount['date_start']) . "', date_end = '" . $this->db->escape($card_discount['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_special WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_special'])) {
			foreach ($data['card_special'] as $card_special) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_special SET card_id = '" . (int)$card_id . "', customer_group_id = '" . (int)$card_special['customer_group_id'] . "', priority = '" . (int)$card_special['priority'] . "', price = '" . (float)$card_special['price'] . "', date_start = '" . $this->db->escape($card_special['date_start']) . "', date_end = '" . $this->db->escape($card_special['date_end']) . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_image WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_image'])) {
			foreach ($data['card_image'] as $card_image) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_image SET card_id = '" . (int)$card_id . "', image = '" . $this->db->escape($card_image['image']) . "', sort_order = '" . (int)$card_image['sort_order'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_download WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_download'])) {
			foreach ($data['card_download'] as $download_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_download SET card_id = '" . (int)$card_id . "', download_id = '" . (int)$download_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_category WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_category'])) {
			foreach ($data['card_category'] as $category_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_category SET card_id = '" . (int)$card_id . "', category_id = '" . (int)$category_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_filter WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_filter'])) {
			foreach ($data['card_filter'] as $filter_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_filter SET card_id = '" . (int)$card_id . "', filter_id = '" . (int)$filter_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE related_id = '" . (int)$card_id . "'");

		if (isset($data['card_related'])) {
			foreach ($data['card_related'] as $related_id) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$card_id . "' AND related_id = '" . (int)$related_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_related SET card_id = '" . (int)$card_id . "', related_id = '" . (int)$related_id . "'");
				$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$related_id . "' AND related_id = '" . (int)$card_id . "'");
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_related SET card_id = '" . (int)$related_id . "', related_id = '" . (int)$card_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_reward WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_reward'])) {
			foreach ($data['card_reward'] as $customer_group_id => $value) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_reward SET card_id = '" . (int)$card_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_layout WHERE card_id = '" . (int)$card_id . "'");

		if (isset($data['card_layout'])) {
			foreach ($data['card_layout'] as $store_id => $layout_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "card_to_layout SET card_id = '" . (int)$card_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
			}
		}

		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'card_id=" . (int)$card_id . "'");

		if ($data['keyword']) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'card_id=" . (int)$card_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->db->query("DELETE FROM `" . DB_PREFIX . "card_recurring` WHERE card_id = " . (int)$card_id);

		if (isset($data['card_recurrings'])) {
			foreach ($data['card_recurrings'] as $recurring) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "card_recurring` SET `card_id` = " . (int)$card_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
			}
		}

		$this->cache->delete('card');

		$this->event->trigger('post.admin.edit.card', $card_id);
	}

	public function copyCard($card_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "card p LEFT JOIN " . DB_PREFIX . "card_description pd ON (p.card_id = pd.card_id) WHERE p.card_id = '" . (int)$card_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		if ($query->num_rows) {
			$data = array();

			$data = $query->row;

			$data['sku'] = '';
			$data['upc'] = '';
			$data['viewed'] = '0';
			$data['keyword'] = '';
			$data['status'] = '0';

			$data = array_merge($data, array('card_attribute' => $this->getCardAttributes($card_id)));
			$data = array_merge($data, array('card_description' => $this->getCardDescriptions($card_id)));
			$data = array_merge($data, array('card_discount' => $this->getCardDiscounts($card_id)));
			$data = array_merge($data, array('card_filter' => $this->getCardFilters($card_id)));
			$data = array_merge($data, array('card_image' => $this->getCardImages($card_id)));
			$data = array_merge($data, array('card_option' => $this->getCardOptions($card_id)));
			$data = array_merge($data, array('card_related' => $this->getCardRelated($card_id)));
			$data = array_merge($data, array('card_reward' => $this->getCardRewards($card_id)));
			$data = array_merge($data, array('card_special' => $this->getCardSpecials($card_id)));
			$data = array_merge($data, array('card_category' => $this->getCardCategories($card_id)));
			$data = array_merge($data, array('card_download' => $this->getCardDownloads($card_id)));
			$data = array_merge($data, array('card_layout' => $this->getCardLayouts($card_id)));
			$data = array_merge($data, array('card_store' => $this->getCardStores($card_id)));
			$data = array_merge($data, array('card_recurrings' => $this->getRecurrings($card_id)));

			$this->addCard($data);
		}
	}

	public function deleteCard($card_id) {
		$this->event->trigger('pre.admin.delete.card', $card_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "card WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_attribute WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_description WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_discount WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_filter WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_image WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_option WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_option_value WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_related WHERE related_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_reward WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_special WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_category WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_download WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_layout WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_to_store WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "review WHERE card_id = '" . (int)$card_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "card_recurring WHERE card_id = " . (int)$card_id);
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'card_id=" . (int)$card_id . "'");

		$this->cache->delete('card');

		$this->event->trigger('post.admin.delete.card', $card_id);
	}

	public function getCard($card_id) {
		$query = $this->db->query("SELECT DISTINCT *, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'card_id=" . (int)$card_id . "') AS keyword FROM " . DB_PREFIX . "card p LEFT JOIN " . DB_PREFIX . "card_description pd ON (p.card_id = pd.card_id) WHERE p.card_id = '" . (int)$card_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getCards($data = array()) {
		//$sql = "SELECT * FROM " . DB_PREFIX . "card p LEFT JOIN " . DB_PREFIX . "card_description pd ON (p.card_id = pd.card_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		  $sql = "SELECT *, 0 as quantity FROM ". DB_PREFIX . "card WHERE card_id > 0 ";

		if (!empty($data['filter_name'])) {
			$sql .= " AND card_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
			$sql .= " AND quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

// 		$sql .= " GROUP BY p.card_id";

		$sort_data = array(
			'card_name',
			'price',
			'p.status',
			'p.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY card_name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCardsByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card p LEFT JOIN " . DB_PREFIX . "card_description pd ON (p.card_id = pd.card_id) LEFT JOIN " . DB_PREFIX . "card_to_category p2c ON (p.card_id = p2c.card_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");

		return $query->rows;
	}

	public function getCardDescriptions($card_id) {
		$card_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_description WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'description'      => $result['description'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
			);
		}

		return $card_description_data;
	}

	public function getCardCategories($card_id) {
		$card_category_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_to_category WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_category_data[] = $result['category_id'];
		}

		return $card_category_data;
	}

	public function getCardFilters($card_id) {
		$card_filter_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_filter WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_filter_data[] = $result['filter_id'];
		}

		return $card_filter_data;
	}

	public function getCardAttributes($card_id) {
		$card_attribute_data = array();

		$card_attribute_query = $this->db->query("SELECT attribute_id FROM " . DB_PREFIX . "card_attribute WHERE card_id = '" . (int)$card_id . "' GROUP BY attribute_id");

		foreach ($card_attribute_query->rows as $card_attribute) {
			$card_attribute_description_data = array();

			$card_attribute_description_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_attribute WHERE card_id = '" . (int)$card_id . "' AND attribute_id = '" . (int)$card_attribute['attribute_id'] . "'");

			foreach ($card_attribute_description_query->rows as $card_attribute_description) {
				$card_attribute_description_data[$card_attribute_description['language_id']] = array('text' => $card_attribute_description['text']);
			}

			$card_attribute_data[] = array(
				'attribute_id'                  => $card_attribute['attribute_id'],
				'card_attribute_description' => $card_attribute_description_data
			);
		}

		return $card_attribute_data;
	}

	public function getCardOptions($card_id) {
		$card_option_data = array();

		$card_option_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "card_option` po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN `" . DB_PREFIX . "option_description` od ON (o.option_id = od.option_id) WHERE po.card_id = '" . (int)$card_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		foreach ($card_option_query->rows as $card_option) {
			$card_option_value_data = array();

			$card_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_option_value WHERE card_option_id = '" . (int)$card_option['card_option_id'] . "'");

			foreach ($card_option_value_query->rows as $card_option_value) {
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

			$card_option_data[] = array(
				'card_option_id'    => $card_option['card_option_id'],
				'card_option_value' => $card_option_value_data,
				'option_id'            => $card_option['option_id'],
				'name'                 => $card_option['name'],
				'type'                 => $card_option['type'],
				'value'                => $card_option['value'],
				'required'             => $card_option['required']
			);
		}

		return $card_option_data;
	}

	public function getCardImages($card_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_image WHERE card_id = '" . (int)$card_id . "' ORDER BY sort_order ASC");

		return $query->rows;
	}

	public function getCardDiscounts($card_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_discount WHERE card_id = '" . (int)$card_id . "' ORDER BY quantity, priority, price");

		return $query->rows;
	}

	public function getCardSpecials($card_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_special WHERE card_id = '" . (int)$card_id . "' ORDER BY priority, price");

		return $query->rows;
	}

	public function getCardRewards($card_id) {
		$card_reward_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_reward WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
		}

		return $card_reward_data;
	}

	public function getCardDownloads($card_id) {
		$card_download_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_to_download WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_download_data[] = $result['download_id'];
		}

		return $card_download_data;
	}

	public function getCardStores($card_id) {
		$card_store_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_to_store WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_store_data[] = $result['store_id'];
		}

		return $card_store_data;
	}

	public function getCardLayouts($card_id) {
		$card_layout_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_to_layout WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_layout_data[$result['store_id']] = $result['layout_id'];
		}

		return $card_layout_data;
	}

	public function getCardRelated($card_id) {
		$card_related_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "card_related WHERE card_id = '" . (int)$card_id . "'");

		foreach ($query->rows as $result) {
			$card_related_data[] = $result['related_id'];
		}

		return $card_related_data;
	}

	public function getRecurrings($card_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "card_recurring` WHERE card_id = '" . (int)$card_id . "'");

		return $query->rows;
	}

	public function getTotalCards($data = array()) {
// 		$sql = "SELECT COUNT(DISTINCT p.card_id) AS total FROM " . DB_PREFIX . "card p LEFT JOIN " . DB_PREFIX . "card_description pd ON (p.card_id = pd.card_id)";

// 		$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$sql = "SELECT COUNT(card_id) AS total FROM ". DB_PREFIX . "card  WHERE card_id>0";
 
		if (!empty($data['filter_name'])) {
			$sql .= " AND card_name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		if (!empty($data['filter_price'])) {
			$sql .= " AND price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
		}

		if (isset($data['filter_quantity']) && $data['filter_quantity'] !== null) {
			$sql .= " AND quantity = '" . (int)$data['filter_quantity'] . "'";
		}

		if (isset($data['filter_status']) && $data['filter_status'] !== null) {
			$sql .= " AND status = '" . (int)$data['filter_status'] . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function getTotalCardsByTaxClassId($tax_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card WHERE tax_class_id = '" . (int)$tax_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByStockStatusId($stock_status_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card WHERE stock_status_id = '" . (int)$stock_status_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByWeightClassId($weight_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card WHERE weight_class_id = '" . (int)$weight_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByLengthClassId($length_class_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card WHERE length_class_id = '" . (int)$length_class_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByDownloadId($download_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card_to_download WHERE download_id = '" . (int)$download_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByManufacturerId($manufacturer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByAttributeId($attribute_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByOptionId($option_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card_option WHERE option_id = '" . (int)$option_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByProfileId($recurring_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");

		return $query->row['total'];
	}

	public function getTotalCardsByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "card_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}
}