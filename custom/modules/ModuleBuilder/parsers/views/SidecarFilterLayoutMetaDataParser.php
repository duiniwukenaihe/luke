<?php

/**
* Extends the _populateFromRequest method in order to sort the 'Available' fields alphabetically
*/
class CustomSidecarFilterLayoutMetaDataParser extends SidecarFilterLayoutMetaDataParser
{
	
	/**
	 * Populates the panel defs, and the view defs, from the request
	 *
	 * @return void
	 */
	protected function _populateFromRequest()
	{
		parent::_populateFromRequest();

		$fields = $this->_viewdefs['fields'];

		$availableFields = [];
		foreach ($fields as $name => $details) {

			$label = $this->getLabel($name, $details);

			$labelValue = translate($label, $this->_moduleName);

			$orderedLabels[$name] = $labelValue;
			
		}

		asort($orderedLabels);

		$final = array_replace($orderedLabels, $fields);

		$this->_viewdefs['fields'] = $final;
	}

	protected function getLabel($name, $field)
	{
		if(isset($field['label'])){
			return $field['label'];
		}

		if(isset($field['vname'])){
			return $field['vname'];
		}

		if(isset($this->_fielddefs[$name]) AND isset($this->_fielddefs[$name]['vname'])){
			return $this->_fielddefs[$name]['vname'];
		}

		return $field['name'];
	}
}