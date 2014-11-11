<?php
class ModelTotalProvision extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if ($this->config->get('provision_status')) {
			$this->load->language('total/provision');


			$provision_sum = 0;

			foreach ($this->cart->getProducts() as $product) {
				
				$percentage = $this->customer->getProvision($product['product_id'],$this->customer->getId());

				if($percentage > 0) {
					$provision =($product['price'] * $percentage / 100)* $product['quantity'] ;
					$provision_sum+=$provision;
					$total_data[] = array(
					'code'       => 'provision',
					'title'      => $this->language->get('text_provision') ." ( ".$product['name']." x ".$product['quantity']. " )", 
					'text'       => $this->currency->format(-$provision),
					'value'      => 0,
					'sort_order' => 2//$this->config->get('provision_sort_order')
					);
						
				}

			}
			if($provision_sum>0){
				$total_data[] = array(
					'code'       => 'provision',
					'title'      => $this->language->get('text_provision_total'), 
					'text'       => $this->currency->format(-$provision_sum),
					'value'      => -$provision_sum,
					'sort_order' => 2//$this->config->get('provision_sort_order')
				);
					
				$total -= $provision_sum;
			}

		}
	}

	public function confirm($order_info, $order_total) {
		$this->load->language('total/credit');
		//
		//		if ($order_info['customer_id']) {
		//			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_transaction SET customer_id = '" . (int)$order_info['customer_id'] . "', order_id = '" . (int)$order_info['order_id'] . "', description = '" . $this->db->escape(sprintf($this->language->get('text_order_id'), (int)$order_info['order_id'])) . "', amount = '" . (float)$order_total['value'] . "', date_added = NOW()");
		//		}
	}
}
?>