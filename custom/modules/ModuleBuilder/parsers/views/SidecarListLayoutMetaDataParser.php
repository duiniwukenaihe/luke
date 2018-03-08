<?php

/**
* Extends the _populateFromRequest method in order to sort the 'Available' fields alphabetically
*/
class CustomSidecarListLayoutMetaDataParser extends SidecarListLayoutMetaDataParser
{
	
	/**
	 * Populates the panel defs, and the view defs, from the request
	 *
	 * @return void
	 */
	protected function _populateFromRequest()
	{
		parent::_populateFromRequest();

		$fields = $this->_viewdefs[$this->client]['view'][$this->view]['panels']['0']['fields'];
		if(empty($fields)) return;

		$sorted = [];
		$availableFields = [];
		foreach ($fields as $field) {

			if($field['default']){

				$defaultFields[] = $field;

			}else{

				$label = $this->getLabel($field);

				$labelValue = translate($label, $this->_moduleName);

				$availableFields[$labelValue] = $field;
			}
		}

		if($availableFields){
			ksort($availableFields);
		}
		
		$final = array_merge($defaultFields,array_values($availableFields));

		$this->_viewdefs[$this->client]['view'][$this->view]['panels']['0']['fields'] = $final;
	}

	protected function getLabel($field)
	{
		if(isset($field['label'])){
			return $field['label'];
		}

		if(isset($this->_fielddefs[$field['name']]) AND isset($this->_fielddefs[$field['name']]['vname'])){
			return $this->_fielddefs[$field['name']]['vname'];
		}

		return $field['name'];
	}
}