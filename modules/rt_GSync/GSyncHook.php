<?php
/**
* Hooks for RTGSync
*
*
*/
class GSyncHook
{
    /**
    * GSyncEditPrefs 
    *
    * Sets assigned_user_id and modified_user_id to current_user's id
    * (Not being called anywhere)
    *
    */
    function GSyncEditPrefs($bean, $event, $arguments)
    {
        $bean->name = 'Prefrences';
        if (isset($bean->id) && $bean->id != $GLOBALS['current_user']->id) {
            $bean->id = $GLOBALS['current_user']->id;
            $newBean = BeanFactory::getBean('rt_GSync');
            $newBean->retrieve($GLOBALS['current_user']->id);
            if (empty($newBean->id)) {
                $bean->new_with_id = true;
            }
        }
        $bean->assigned_user_id = $GLOBALS['current_user']->id ? $GLOBALS['current_user']->id : '1';
        $bean->modified_user_id = $GLOBALS['current_user']->id ? $GLOBALS['current_user']->id : '1';
    }
    /*
    * Activate/DeActivate Schedulers RT GSync
    *
    * Module: RT GSync
    * <br>Hook: after_save
    * <br> rt_GSyncApiCalls::setPreferences() saves user preferences 
    * regarding which types of syncing is enabled in database and this hook is called 
    * afterwards. It checks for preferences in db and enables schedulars accordingly.
    */
    function GSyncActivateSchedulers($bean, $event, $arguments)
    {
        if (is_admin($GLOBALS['current_user'])) {
            if (isset($bean->activate_calendar)) {
                $GLOBALS['log']->debug('activate_calendar');
                $scheduler = BeanFactory::getBean('Schedulers');
                $scheduler->retrieve_by_string_fields(array('job' => 'function::googleCalenderSync', 'deleted' => '0'));
                if (!empty($scheduler->id)) {
                    $status = $scheduler->status;
                    $scheduler->status = $bean->activate_calendar == true ? 'Active' : 'Inactive';
                    if ($status != $scheduler->status)
                        if ($scheduler->save(false)) {
                            $GLOBALS['log']->debug('activated calendar scheduler');
                        } else {
                            $GLOBALS['log']->debug('unable to activate calendar scheduler');
                        }
                }
            }
            if (isset($bean->activate_contacts)) {
                $GLOBALS['log']->debug('activate_contacts');
                $scheduler = BeanFactory::getBean('Schedulers');
                $scheduler->retrieve_by_string_fields(array('job' => 'function::googleContactsSync', 'deleted' => '0'));
                if (!empty($scheduler->id)) {
                    $status = $scheduler->status;
                    $scheduler->status = $bean->activate_contacts == true ? 'Active' : 'Inactive';
                    if ($status != $scheduler->status)
                        if ($scheduler->save(false)) {
                            $GLOBALS['log']->debug('activated contacts scheduler');
                        } else {
                            $GLOBALS['log']->debug('unable to activate contacts scheduler');
                        }
                }
            }
            if (isset($bean->activate_documents)) {
                $GLOBALS['log']->debug('activate_documents');
                $scheduler = BeanFactory::getBean('Schedulers');
                $scheduler->retrieve_by_string_fields(array('job' => 'function::googleDriveSync', 'deleted' => '0'));
                if (!empty($scheduler->id)) {
                    $status = $scheduler->status;
                    $scheduler->status = $bean->activate_documents == true ? 'Active' : 'Inactive';
                    if ($status != $scheduler->status)
                        if ($scheduler->save(false)) {
                            $GLOBALS['log']->debug('activated documents scheduler');
                        } else {
                            $GLOBALS['log']->debug('unable to activate documents scheduler');
                        }
                }
            }
            if (isset($bean->activate_archive_emails)) {
                $GLOBALS['log']->debug('activate_archive_emails');
                $scheduler = BeanFactory::getBean('Schedulers');
                $scheduler->retrieve_by_string_fields(array('job' => 'function::importCacheEmails', 'deleted' => '0'));
                if (!empty($scheduler->id)) {
                    $status = $scheduler->status;
                    $scheduler->status = $bean->activate_archive_emails == true ? 'Active' : 'Inactive';
                    if ($status != $scheduler->status)
                        if ($scheduler->save(false)) {
                            $GLOBALS['log']->debug('activated archive emails scheduler');
                        } else {
                            $GLOBALS['log']->debug('unable to activate archive emails scheduler');
                        }
                }
            }
        }
    }
    /**
    * this was used to fetch schedular's status, but now they are all returned true (not sure why)
    */
    function GSyncFetchSchedulersStatus($bean, $event, $arguments)
    {
        // $GLOBALS['log']->fatal('in retrieve logic hook');

        $scheduler = BeanFactory::getBean('Schedulers');
        if (isset($bean->activate_calendar)) {
            $scheduler->retrieve_by_string_fields(array('job' => 'function::googleCalenderSync', 'deleted' => '0'));
            if (!empty($scheduler->id)) {
                $bean->activate_calendar = $scheduler->status == 'Inactive' ? false : true;
            }
        }
        if (isset($bean->activate_contacts)) {
            $scheduler->retrieve_by_string_fields(array('job' => 'function::googleContactsSync', 'deleted' => '0'));
            if (!empty($scheduler->id)) {
                $bean->activate_calendar = $scheduler->status == 'Inactive' ? false : true;
            }
        }
        if (isset($bean->activate_documents)) {
            $scheduler->retrieve_by_string_fields(array('job' => 'function::googleDriveSync', 'deleted' => '0'));
            if (!empty($scheduler->id)) {
                $bean->activate_calendar = $scheduler->status == 'Inactive' ? false : true;
            }
        }
        if (isset($bean->activate_archive_emails)) {
            $scheduler->retrieve_by_string_fields(array('job' => 'function::importCacheEmails', 'deleted' => '0'));
            if (!empty($scheduler->id)) {
                $bean->activate_calendar = $scheduler->status == 'Inactive' ? false : true;
            }
        }

    }
}



