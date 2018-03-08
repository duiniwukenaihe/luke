<?php

/**
* AlterName
*/
class AlterName
{
  
  function before_save($bean, $event, $arguments)
  {
    $caseName = 'Service Request';

    //Get the parent Case
    if ($bean->load_relationship('cases_mv_srvreq_1')) {
        $case = current($bean->cases_mv_srvreq_1->getBeans());
        $caseName = $case->name;
    }

    // Translate the Category(ies)
    $categories = unencodeMultienum($bean->category);
    $translated = [];
    foreach($categories as $cat){
      $value = translate('service_category_list', '', $cat);

      // translate returns the list if it can't find the value. 
      $translated[] = is_array($value) ? $cat : $value;
    }

    if(empty($translated)){
      $bean->name = $caseName;
    }else{
      $bean->name = $caseName . ' - ' . implode(',',$translated);
    }   
  }
}
