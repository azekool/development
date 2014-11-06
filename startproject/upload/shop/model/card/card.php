<?php
class ModelCardCard extends Model {

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

}