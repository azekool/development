<?php
class ModelTransactionTransaction extends Model {
	public function addTransaction($data) {
		$this->event->trigger('pre.admin.add.transaction', $data);

		$this->db->query("INSERT INTO " . DB_PREFIX . "transaction SET sort_order = '" . (int)$data['sort_order'] . "'");

		$transaction_id = $this->db->getLastId();

		foreach ($data['transaction_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "transaction_description SET transaction_id = '" . (int)$transaction_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.admin.add.transaction', $transaction_id);

		return $transaction_id;
	}

	public function editTransaction($transaction_id, $data) {
		$this->event->trigger('pre.admin.edit.attribute.group', $data);

		$this->db->query("UPDATE " . DB_PREFIX . "transaction SET sort_order = '" . (int)$data['sort_order'] . "' WHERE transaction_id = '" . (int)$transaction_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "transaction_description WHERE transaction_id = '" . (int)$transaction_id . "'");

		foreach ($data['transaction_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "transaction_description SET transaction_id = '" . (int)$transaction_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
		}

		$this->event->trigger('post.admin.edit.attribute.group', $transaction_id);
	}

	public function deleteTransaction($transaction_id) {
		$this->event->trigger('pre.admin.delete.attribute.group', $transaction_id);

		$this->db->query("DELETE FROM " . DB_PREFIX . "transaction WHERE transaction_id = '" . (int)$transaction_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "transaction_description WHERE transaction_id = '" . (int)$transaction_id . "'");

		$this->event->trigger('post.admin.delete.attribute.group', $transaction_id);
	}

	public function getTransaction($transaction_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "transaction WHERE transaction_id = '" . (int)$transaction_id . "'");

		return $query->row;
	}

	public function getTransactions($data = array()) {
		$sql = "SELECT t.transaction_id,t.amount,t.comment,t.date_added,c.firstname,c.lastname,u.username,tt.type_name FROM " . DB_PREFIX . "transaction t LEFT JOIN " . DB_PREFIX . "customer c ON (t.customer_id = c.customer_id) LEFT JOIN " . DB_PREFIX . "user u ON (t.user_id = u.user_id) LEFT JOIN " . DB_PREFIX . "transaction_type tt ON (t.transaction_type_id = tt.transaction_type_id) WHERE t.reseller_id = '" . (int)$this->user->getId() . "'";

		$sort_data = array(
			't.amount',
			'tt.type_name',
			't.comment',
			'u.username',
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY t.date_added";
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

	public function getTransactionType() {
		$transaction_type_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "transaction_type ");

		return $transaction_data;
	}

	public function getTotalTransactions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "transaction");

		return $query->row['total'];
	}
}