<?php

class Update_Stage {

    function update_customer_stage($bean, $event, $arguments) {
        
        if ($bean->status == 'Completed' && ( isset($bean->dataChanges['status']) && $bean->dataChanges['status']['before'] != 'Completed' )) {
            if ((strtolower($bean->name) == 'mark ups and colors created') || (strtolower($bean->name) == 'building permits submitted')) {
                if ($bean->parent_type = 'm_CAMS') {
                    $query = new SugarQuery();
                    $query->from(BeanFactory::getBean('Tasks'));
                    $dri_sub = $query->join('dri_subworkflow_link')->joinName();
                    $query->joinTable('dri_workflows', array('alias' => 'dri'))->on()->equalsField("$dri_sub.dri_workflow_id", "dri.id");
                    $query->select(array("dri.id"));
                    $query->where()->contains('dri.name', 'Pre-Start Journey');
                    $query->where()->equals('id', $bean->id);
                    $results = $query->execute();
                    if (!empty($results)) {
                        foreach ($results as $result) {
                            $sort_order = '';
                            if ((strtolower($bean->name) == 'mark ups and colors created')) {
                                $sort_order = '2';
                            }
                            if ((strtolower($bean->name) == 'building permits submitted')) {
                                $sort_order = '3';
                            }
                            $query1 = new SugarQuery();
                            $dri_subworkflow = BeanFactory::getBean('DRI_SubWorkflows');
                            $query1->from(BeanFactory::getBean('DRI_SubWorkflows'));
                            $dri = $query1->join('dri_workflow_link')->joinName();
                            $query1->select(array("id"));
                            $query1->where()->equals("$dri.id", $result['id']);
                            $query1->where()->equals("sort_order", $sort_order);
                            $results1 = $query1->execute();
                            foreach ($results1 as $result) {
                                $id = $result['id'];
                                if (!empty($id)) {
                                    $dri_subworkflow_bean = BeanFactory::getBean('DRI_SubWorkflows', $id);
                                    if ($dri_subworkflow_bean->load_relationship('tasks')) {
                                        $relatedBeans = $dri_subworkflow_bean->tasks->getBeans();
                                        if (!empty($relatedBeans)) {
                                            foreach ($relatedBeans as $bean) {
                                                if($bean->status != 'Completed')
                                                {
                                                    $bean->status = 'In Progress';
                                                    $bean->save();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

}
