<?php


class ImageField
{
  protected static $mimes = [
    'image/jpeg',
    'image/gif',
    'image/png',
  ];
  function before_save($bean, $event, $arguments)
  {
    if(in_array($bean->file_mime_type, self::$mimes) AND !empty($bean->id)){
      $bean->image = $bean->id;
    }else{
      $bean->image = '';
    }
  }
}
