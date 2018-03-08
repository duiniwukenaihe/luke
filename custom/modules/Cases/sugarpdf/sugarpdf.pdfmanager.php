<?php

require('custom/include/Datasync/datasyncPDFManager.php');

// Change this to the relevant Module Name
// <MODULE>SugarpdfPdfmanager
class CasesSugarpdfPdfmanager extends DatasyncPDFManager {
	public function preDisplay() {
		//Call this to allow custom options to be applied
		parent::preDisplay();		

		$related = $this->fetchRelatedRecords('cases_mv_srvreq_1');
		$serviceRequestItems = $this->formatRelatedBeans($related);
		$this->ss->assign('mv_SrvReq', $serviceRequestItems);
	}


	protected function fetchRelatedRecords($link)
	{
		if ($this->bean->load_relationship($link)) {
		    //Fetch related beans
		   return $this->bean->$link->getBeans();
		}
	}

	protected function formatRelatedBeans($beans)
	{
		if(empty($beans))
			return;

		$formatted = [];
		foreach($beans as $bean){
			$formatted[] = PdfManagerHelper::parseBeanFields($bean, false);
		}

		return $formatted;
	}
}