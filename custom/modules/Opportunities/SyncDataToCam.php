<?php

class DataSync {

    //Opp => CAM
    protected static $watchedFields = [
        'amount' => 'contract_price',
        'sales_stage' => 'sales_stage',
        'date_closed' => 'closing_date',
        'opportunity_type' => 'sale_type',
        'warranty_exp' => 'warranty_exp',
        'pending_date' => 'pending_date',
        'elevation' => 'elevation',
        'garage_type' => 'garage_type',
        'floor_plan' => 'floor_plan',
        'square_ft' => 'square_footage',
        'precon' => 'precon',
        'account_id' => 'account_id',
    ];

    function after_relationship_add_method($opportunity, $event, $args) {
        if (!self::isCAMRelationship($args))
            return false;


        $cam = self::fetchCam($args);


        $cam->contract_price = $opportunity->amount;
        $cam->sales_stage = $opportunity->sales_stage;
        $cam->closing_date = $opportunity->date_closed;
        $cam->sale_type = $opportunity->opportunity_type;
        $cam->warranty_exp = $opportunity->warranty_exp;
        $cam->pending_date = $opportunity->pending_date;
        $cam->elevation = $opportunity->elevation;
        $cam->garage_type = $opportunity->garage_type;
        $cam->floor_plan = $opportunity->floor_plan;
        $cam->square_footage = $opportunity->square_ft;
        $cam->precon = $opportunity->precon;
        $cam->account_id = $opportunity->account_id;
        $cam->save();

        return;
    }

    protected static function isCAMRelationship($args) {
        return $args['related_module'] === 'm_CAMS';
    }

    protected static function fetchCam($args) {
        $cam = BeanFactory::retrieveBean('m_CAMS', $args['related_id']);
        if (!$cam) {
            _ppl($args);
            throw new Exception("Unable to find related CAM");
        }

        return $cam;
    }

    public function after_save_method($opp, $event, $args) {
        if (self::isNew($args)) {
            return false;
        }

        if (!self::hasRelevantFieldChanges($args) OR ! self::hasCAM($opp)) {
            return false;
        }

        $CAM = self::fetchCam(['related_id' => $opp->m_cams_opportunities_1m_cams_ida]);
        $needsSave = false;

        foreach (self::$watchedFields as $oppField => $camField) {
            if ($opp->$oppField !== $CAM->$camField) {
                $needsSave = true;
                $CAM->$camField = $opp->$oppField;
            }
        }

        if ($needsSave) {
            $CAM->save();
        }

        return true;
    }

    protected static function isNew($args) {
        return !$args['isUpdate'];
    }

    protected static function hasRelevantFieldChanges($args) {
        return !empty(array_intersect(array_keys($args['dataChanges']), array_keys(self::$watchedFields)));
    }

    protected static function hasCAM($opp) {
        return !empty($opp->m_cams_opportunities_1m_cams_ida);
    }

}
