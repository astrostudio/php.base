<?php
namespace Base;

class BaseTime {

    const TF_DATABASE='Y-m-d H:i:s';
    const TF_DATE_DATABASE='Y-m-d';

    const PN_THIS_YEAR='this-year';
    const PN_THIS_MONTH='this-month';
    const PN_THIS_WEEK='this-week';
    const PN_LAST_YEAR='last-year';
    const PN_LAST_MONTH='last-month';
    const PN_LAST_WEEK='last-week';

    static private $__recognizes=array(
        'Y-m-d H:i:s',
        'd-m-Y H:i:s',
        'Y-m-d H:i',
        'd-m-Y H:i',
        'Y-m-d',
        'd-m-Y',
        'H:i:s',
        'H:i'
    );
    
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

        if($name==self::PN_THIS_YEAR){
            return(array('start'=>self::yearStart($time),'stop'=>self::yearStop($time),'step'=>new DateInterval('P1M')));
        }

        if($name==self::PN_THIS_MONTH){
            return(array('start'=>self::monthStart($time),'stop'=>self::monthStop($time),'step'=>new DateInterval('P7D')));
        }

        if($name==self::PN_THIS_WEEK){
            return(array('start'=>self::weekStart($time),'stop'=>self::weekStop($time),'step'=>new DateInterval('P1D')));
        }

        $time1=clone $time;
        
        if($name==self::PN_LAST_YEAR){
            $time1->sub(new DateInterval('P1Y'));
            
            return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P1M')));
        }

        if($name==self::PN_LAST_MONTH){
            $time1->sub(new DateInterval('P1M'));
            
            return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P7D')));
        }

        if($name==self::PN_LAST_WEEK){
            $time1->sub(new DateInterval('P7D'));
            
            return(array('start'=>$time1,'stop'=>$time,'step'=>new DateInterval('P1D')));
        }
        
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
    
    
    
}
