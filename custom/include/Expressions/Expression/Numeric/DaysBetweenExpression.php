<?php

require_once('include/Expressions/Expression/Numeric/NumericExpression.php');

/**
 * <b>daysBetweeen(Date s, Date e)</b><br>
 * Returns number of days between date s and date e.
 */
class DaysBetweenExpression extends NumericExpression
{
    public function evaluate()
    {
        $params = $this->getParameters();
        if(!$params)
            return false;

        $startVal = $params[0]->evaluate();
        $endVal = $params[1]->evaluate();

        if(empty($startVal) OR empty($endVal)){
            return '';
        }

        // Looks like DateExpression::parse throws an exception if it can't parse
        try {
            $start = DateExpression::parse($startVal);
            $end = DateExpression::parse($endVal);

            if(( ! $start instanceof DateTime) OR ( ! $end instanceof DateTime)){
                throw new Exception("DaysBetweenExpression unable to parse DateTime from values");
            }

            $start->setTime(0, 0, 0);
            $end->setTime(0, 0, 0);
                
        } catch (Exception $e) {
            $GLOBALS['log']->error($e->getMessage());
            return '';
        }

        
        $tsdiff = $start->ts - $end->ts;
        $diff = (int)ceil($tsdiff/86400);
        return $diff;
    }

    static function getJSEvaluate()
    {
        //TODO: Add error handling here
        return <<<EOQ
            var params = this.getParameters();
            var start = SUGAR.util.DateUtils.parse(params[0].evaluate(), 'user');
            start.setHours(0);
            start.setMinutes(0);
            start.setSeconds(0);

            var end = SUGAR.util.DateUtils.parse(params[1].evaluate(), 'user');
            end.setHours(0);
            end.setMinutes(0);
            end.setSeconds(0);

            var diff = start - end;
            var days = Math.ceil(diff / 86400000);

            return days;
EOQ;
    }

    static function getOperationName() {
        return "daysBetween";
    }

    static function getParameterTypes()
    {
        return array(AbstractExpression::$DATE_TYPE, AbstractExpression::$DATE_TYPE);
    }

    static function getParamCount()
    {
        return 2;
    }
}

?>
