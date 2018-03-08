<?php

/**
* Datasync PDF Manager
*/
class DatasyncPDFManager extends SugarpdfPdfmanager
{
	public $pdfID = null;
	public $hasCustomConfig = false;
	public $customConfig;

	public function preDisplay() {
		if (!empty($_REQUEST['pdf_template_id'])) {
			$this->pdfID = $_REQUEST['pdf_template_id'];
			$this->loadConfig();
		}

		//_ppl('DatasyncPDFManager preDisplay running');

		if($this->hasCustomConfig){
			if(isset($this->customConfig['orientation'])){
				$this->setPageOrientation($this->customConfig['orientation']);
			}
		}

		parent::preDisplay();

		if($this->hasCustomConfig){
			if(isset($this->customConfig['disableFooter'])){
				$this->setPrintFooter(! $this->customConfig['disableFooter']);
			}
		}

	}

	protected function loadConfig()
	{
		$administrationObj = new Administration();
		$pdfConfigs =  $administrationObj->getConfigForModule('PdfManager');
		if(isset($pdfConfigs['customPDFSettings'])){
			$pdfSettings = $pdfConfigs['customPDFSettings'];

			if(array_key_exists($this->pdfID, $pdfSettings)){
				$this->customConfig = $pdfSettings[$this->pdfID];
				$this->hasCustomConfig = true;
				return $this->customConfig;
			}
		}
		return false;
	}

	public function Output($name = "doc.pdf", $output = 'I') {
		if (!empty($this->pdfFilename)) {
			$name = $this->pdfFilename;
		}

		if (isset($_REQUEST['to_browser']) && $_REQUEST['to_browser'] == "1") {
			SugarpdfSmarty::Output($name, 'I');
		}else{
			Parent::Output($name, $output);
		}		
	}
}