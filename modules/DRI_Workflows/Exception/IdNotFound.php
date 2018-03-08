<?php

require_once 'modules/DRI_Workflows/Exception/NotFound.php';

/**
 * @author Emil Kilhage <emil.kilhage@addoptify.com>
 */
class DRI_Workflows_Exception_IdNotFound extends DRI_Workflows_Exception_NotFound
{
    /**
     * @param string $id
     */
    public function __construct($id)
    {
        parent::__construct("Could not found DRI_Workflow with id '$id'");
    }
}
