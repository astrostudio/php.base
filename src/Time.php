<?php
namespace Base;

use DateTime;
use DateInterval;
use DateTimeInterface;

class Time {

    const PN_THIS_YEAR='this-year';
    const PN_THIS_MONTH='this-month';
    const PN_THIS_WEEK='this-week';
    const PN_LAST_YEAR='last-year';
    const PN_LAST_MONTH='last-month';
    const PN_LAST_WEEK='last-week';

    static private $__formats= [
        'Y-m-d H:i:s',
        'd-m-Y H:i:s',
        'Y-m-d H:i',
        'd-m-Y H:i',
        'Y-m-d',
        'd-m-Y',
        'H:i:s',
        'H:i'
    ];

    static public function extract($time,$default=null,$format=null):?DateTimeInterface{
        if(!$time){
            if(isset($default)) {
                return (self::extract($default));
            }

            return($default);
        }

        if($time instanceof DateTimeInterface){
            return($time);
        }

        if(is_string($time)){
            return(self::recognize($time,$format));
        }

        if(is_int($time)){
            return((new DateTime())->setTimestamp($time));
        }

        return(null);
    }

    static public function recognize($string,$format=null){
        if(empty($string)){
            return(false);
        }

        if(!isset($format)){
            $format=self::$__formats;
        }
        else if(is_string($format)){
            return(DateTime::createFromFormat($format,$string));
        }
        else if(!is_array($format)){
            return(null);
        }

        foreach($format as $f){
            $time=DateTime::createFromFormat($f,$string);

            if($time){
                return($time);
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

    static public function yearStart(DateTimeInterface $time=null){
        $time=!empty($time)?$time:new DateTime();

        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y').'-01-01 00:00:00'));
    }

    static public function yearStop(DateTimeInterface $time=null){
        $time=!empty($time)?$time:new DateTime();

        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y').'-12-31 23:59:59'));
    }

    static public function monthStart(DateTimeInterface $time=null){
        $time=!empty($time)?$time:new DateTime();

        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y-m').'-01 00:00:00'));
    }

    static public function monthStop(DateTimeInterface $time=null){
        $time=!empty($time)?$time:new DateTime();

        return(DateTime::createFromFormat('Y-m-d H:i:s',$time->format('Y-m-t').' 23:59:59'));
    }

    static public function weekStart(DateTimeInterface $time=null){
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

    static public function weekStop(DateTimeInterface $time=null){
        $start=self::weekStart($time);
        $start->add(new DateInterval('P7D'));

        return($start);
    }

    static public function period($name,DateTimeInterface $time=null){
        $time=!empty($time)?$time:new DateTime();

        if($name==self::PN_THIS_YEAR){
            return(['start' =>self::yearStart($time), 'stop' =>self::yearStop($time), 'step' =>new DateInterval('P1M')]);
        }

        if($name==self::PN_THIS_MONTH){
            return(['start' =>self::monthStart($time), 'stop' =>self::monthStop($time), 'step' =>new DateInterval('P7D')]);
        }

        if($name==self::PN_THIS_WEEK){
            return(['start' =>self::weekStart($time), 'stop' =>self::weekStop($time), 'step' =>new DateInterval('P1D')]);
        }

        $time1=clone $time;

        if($name==self::PN_LAST_YEAR){
            $time1->sub(new DateInterval('P1Y'));

            return(['start' =>$time1, 'stop' =>$time, 'step' =>new DateInterval('P1M')]);
        }

        if($name==self::PN_LAST_MONTH){
            $time1->sub(new DateInterval('P1M'));

            return(['start' =>$time1, 'stop' =>$time, 'step' =>new DateInterval('P7D')]);
        }

        if($name==self::PN_LAST_WEEK){
            $time1->sub(new DateInterval('P7D'));

            return(['start' =>$time1, 'stop' =>$time, 'step' =>new DateInterval('P1D')]);
        }

        return(['start' =>$time1, 'stop' =>$time, 'step' =>new DateInterval('P1D')]);
    }

    static public function age(DateTimeInterface $time=null,DateTimeInterface $now=null){
        if(!empty($time)){
            $now=$now?$now:new DateTime();

            return($now->format('Y')-$time->format('Y'));
        }

        return(null);
    }

    static public function middle(DateTimeInterface $start=null,DateTimeInterface $stop=null){
        $start=!empty($start)?$start:new DateTime();
        $stop=!empty($stop)?$stop:new DateTime();
        $istart=$start->getTimestamp();
        $istop=$stop->getTimestamp();
        $itime=(int)(($istart+$istop)/2);

        $time=new DateTime();
        $time->setTimestamp($itime);

        return($time);
    }

    static public function compare(DateTimeInterface $time1,DateTimeInterface $time2,$format='Y-m-d H:i:s'){
        $time1=$time1->format($format);
        $time2=$time2->format($format);

        return(strcmp($time1,$time2));
    }

}
