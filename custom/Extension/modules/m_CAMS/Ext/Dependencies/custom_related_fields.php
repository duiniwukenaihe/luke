<?php

    $dependencies['m_CAMS']['fields_from_opps'] = [
        'hooks' => ["all"], //not including save so that the value isn't stored in the DB
        'trigger' => 'not(equal($m_cams_opportunities_1opportunities_idb,""))', //Optional, the trigger for the dependency. Defaults to 'true'.
        'triggerFields' => ['m_cams_opportunities_1opportunities_idb','m_cams_opportunities_1_name'], //unneeded for this example as its not field triggered
        'onload' => true,
        'actions' => [
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'contract_price','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'sales_stage','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'closing_date','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'sale_type','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'pending_date','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'elevation','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'garage_type','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'floor_plan','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'square_footage','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'precon','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'account_name','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'account_id','value' => 'true'],
            ],
        ],
        'notActions' => [
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'contract_price','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'sales_stage','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'closing_date','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'sale_type','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'pending_date','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'elevation','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'garage_type','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'floor_plan','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'square_footage','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'precon','value' => 'false'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'account_name','value' => 'true'],
            ],
            [
                'name' => 'ReadOnly',
                'params' => ['target' => 'account_id','value' => 'true'],
            ],
        ]
    ];