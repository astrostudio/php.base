<?php
class BaseTime {

    const TF_DATABASE='Y-m-d H:i:s';
    const TF_DATE_DATABASE='Y-m-d';

    const PN_THIS_YEAR='this-year';
    const PN_THIS_MONTH='this-month';
    const PN_THIS_WEEK='this-week';
    const PN_LAST_YEAR='last-year';
    const PN_LAST_MONTH='last-month';
    const PN_LAST_WEEK='last-week';

    const TP_THIS_YEAR='this-year';
    const TP_THIS_MONTH='this-month';
    const TP_THIS_WEEK='this-week';
    const TP_LAST_YEAR='last-year';
    const TP_LAST_MONTH='last-month';
    const TP_LAST_WEEK='last-week';
    const TP_ALL_THE_TIME='all-the-time';

    const TR_SECOND='second';
    const TR_MINUTE='minute';
    const TR_HOUR='hour';
    const TR_DAY='day';
    const TR_WEEK='week';
    const TR_MONTH='month';
    const TR_YEAR='year';

    static private $__recognizes=array(
        'Y-m-d H:i:s',
        'd-m-Y H:i:s',
        'Y-m-d H:i',
        'd-m-Y H:i',
        'Y-m-d',
        'd-m-Y',
        'H:i:s',
        'H:i',
        'Y-m',
        'Y'
    );

    static private $__ranges=[
        self::TR_SECOND=>['datetime'=>'Y-m-d H:i:s','database'=>'%Y-%m-%d %H:%i:%s','interval'=>'PT1S','dbfunc'=>'SECOND'],
        self::TR_MINUTE=>['datetime'=>'Y-m-d H:i','database'=>'%Y-%m-%d %H:%i','interval'=>'PT1M','dbfunc'=>'MINUTE'],
        self::TR_HOUR=>['datetime'=>'Y-m-d H','database'=>'%Y-%m-%d %H','interval'=>'PT1H','dbfunc'=>'HOUR'],
        self::TR_DAY=>['datetime'=>'Y-m-d','database'=>'%Y-%m-%d','interval'=>'P1D','dbfunc'=>'DAY'],
        self::TR_WEEK=>['datetime'=>'Y-W','database'=>'%Y-%u','interval'=>'P7D','dbfunc'=>'WEEK'],
        self::TR_MONTH=>['datetime'=>'Y-m','database'=>'%Y-%m','interval'=>'P1M','dbfunc'=>'MONTH'],
        self::TR_YEAR=>['datetime'=>'Y','database'=>'%Y','interval'=>'P1Y','dbfunc'=>'YEAR']
    ];

    static private $__periods=[
        self::TP_THIS_YEAR=>['range'=>self::TR_MONTH],
        self::TP_THIS_MONTH=>['range'=>self::TR_WEEK],
        self::TP_THIS_WEEK=>['range'=>self::TR_DAY],
        self::TP_LAST_YEAR=>['range'=>self::TR_MONTH],
        self::TP_LAST_MONTH=>['range'=>self::TR_WEEK],
        self::TP_LAST_WEEK=>['range'=>self::TR_DAY],
        self::TP_ALL_THE_TIME=>['range'=>self::TR_YEAR]
    ];

    static public function recognize($string,$formats=null){
        $formats=is_array($formats)?$formats:self::$__recognizes;
        
        if(!empty($string)){
            foreach($formats as $format){
                $time=DateTime::createFromFormat($format,$string);
                
                if($time){
                    return($time);
                }
            }
        }
        
        return(null);
    }
    
    static public function convert($string,$source,$target,$default=''){
        $time=DateTime::createFromFormat($source,$string);
        
        if(!empty($time)){
            return($time->format($target));
        }
        
        if($default===true){
            return($string);
        }
        
        return($default);        
    }
    
    static public function yearStart(DateTime $time=null){
        $time=!empty($time)?$time:new DateTime();
        
        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y').'-01-01 00:00:00'));
    }
    
    static public function yearStop(DateTime $time=null){
        $time=!empty($time)?$time:new DateTime();
        
        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y').'-12-31 23:59:59'));
    }

    static public function monthStart(DateTime $time=null){
        $time=!empty($time)?$time:new DateTime();
        
        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y-m').'-01 00:00:00'));        
    }

    static public function monthStop(DateTime $time=null){
        $time=!empty($time)?$time:new DateTime();
        
        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y-m-t').' 23:59:59'));
    }

    static public function weekStart(DateTime $time=null){
        $time=!empty($time)?$time:new DateTime();
        $wdate=clone $time;
        $wdate=DateTime::createFromFormat('Y-m-d',$wdate->format('Y-m-d'));
        $day=$wdate->format('N');
        
        while($day>1){
            $wdate->sub(new DateInterval('P1D'));
            $day=$wdate->format('N');
        }
        
        return($wdate);
    }
    
    static public function weekStop(DateTime $time=null){
        $start=self::weekStart($time);
        $start->add(new DateInterval('P7D'));
        
        return($start);
    }

    static public function period($name,DateTime $time=null){
        $time=!empty($time)?$time:new DateTime();

        switch($name){
            case self::PN_THIS_YEAR:
                return(array('start'=>self::yearStart($time),'stop'=>self::yearStop($time),'step'=>new DateInterval('P1M')));
            case self::PN_THIS_MONTH:
                return(array('start'=>self::monthStart($time),'stop'=>self::monthStop($time),'step'=>new DateInterval('P7D')));
            case self::PN_THIS_WEEK:
                return(array('start'=>self::weekStart($time),'stop'=>self::weekStop($time),'step'=>new DateInterval('P1D')));
            case self::PN_LAST_YEAR:
                $time1=clone $time;
                $time1->sub(new DateInterval('P1Y'));
            
                return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P1M')));
            case self::PN_LAST_MONTH:
                $time1=clone $time;
                $time1->sub(new DateInterval('P1M'));
            
                return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P7D')));
            case self::PN_LAST_WEEK:
                $time1=clone $time;
                $time1->sub(new DateInterval('P7D'));
            
                return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P1D')));
            case self::TP_ALL_THE_TIME:
                $time1=clone $time;
                $time1->sub(new DateInterval('P10Y'));

                return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P1Y')));
        }

        $time1=clone $time;

        return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P1D')));
    }
    
    static public function age(DateTime $time=null){
        if(!empty($time)){
            $now=new DateTime();
        
            return($now->format('Y')-$time->format('Y'));
        }
        
        return(null);
    }
    
    static public function middle(DateTime $start=null,DateTime $stop=null){
        $start=!empty($start)?$start:new DateTime();
        $stop=!empty($stop)?$stop:new DateTime();
        $istart=$start->getTimestamp();
        $istop=$stop->getTimestamp();
        $itime=(int)(($istart+$istop)/2);
        
        $time=new DateTime();
        $time->setTimestamp($itime);
        
        return($time);
    }

    static public function seconds(DateInterval $interval){
        return($interval->d * 3600 * 24 + $interval->h * 3600 + $interval->i * 60 + $interval->s);
    }

    static public function range($range,$name){
        if(empty(self::$__ranges[$range])){
            return(false);
        }

        if(empty(self::$__ranges[$range][$name])){
            return(false);
        }

        return(self::$__ranges[$range][$name]);
    }

    static public function periodRange($period){
        return(self::$__periods[$period]['range']);
    }
}
