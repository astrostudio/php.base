<?php
namespace Base;

class CSS
{
    static public function style($style):string{
        if(is_string($style)){
            return($style);
        }

        if(is_array($style)){
            $sstyle='';

            foreach($style as $name=>$value){
                $sstyle.=$name.':'.$value.';';
            }

            return($sstyle);
        }

        return('');
    }

    static public function parse($style):array{
        if(is_array($style)){
            return($style);
        }

        if(is_string($style)){
            $options= [];
            $items=explode(';',$style);

            foreach($items as $item){
                $attrs=explode(':',$item);

                if(count($attrs)>=2){
                    $options[$attrs[0]]=$attrs[1];
                }
            }

            return($options);
        }

        return([]);
    }

    static public function merge($style1,$style2):string{
        return(self::style(array_merge(self::parse($style1),self::parse($style2))));
    }

}
