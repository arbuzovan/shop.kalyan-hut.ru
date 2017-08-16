<?php
	class __emarket_admin_reviews extends baseModuleAdmin {

		public function reviews() {
			$this->setDataType("list");
			$this->setActionType("view");
			if($this->ifNotXmlMode()) return $this->doData();

			$limit = getRequest('per_page_limit');
			$curr_page = (int) getRequest('p');
			$offset = $limit * $curr_page;

			$sel = new selector('objects');
			$sel->types('object-type')->name('emarket', 'reviews');
			$sel->limit($offset, $limit);
			selectorHelper::detectFilters($sel);

			$this->setDataRange($limit, $offset);
			$data = $this->prepareData($sel->result, "objects");
			$this->setData($data, $sel->length);
			return $this->doData();
		}
	};
?>