<?php
namespace Base;

use Base\IBaseProcessor;

class BaseShortcoder implements IBaseProcessor {

    private $__shortcodes=[];

    public function __construct(array $shortcodes=[]){
        foreach($shortcodes as $name=>$shortcode){
            $this->set($name,$shortcode);
        }
    }

    public function process(array $options=[],$body=null){
        $i=0;
        $items=$this->__parse($body,$i,mb_strlen($body));

        if($items===false){
            return(false);
        }

        return($this->__process($items));
    }

    public function set($name,$shortcode=null){
        if(!isset($shortcode)){
            unset($this->__shortcodes[$name]);

            return;
        }

        if(($shortcode instanceof IBaseProcessor) or is_callable($shortcode) or is_string($shortcode)){
            $this->__shortcodes[$name]=$shortcode;
        }
    }

    private function __process($items=[]){
        $s='';

        foreach($items as $item){
            if(is_string($item)){
                $s.=$item;
            }
            else if(is_array($item)){
                if(!empty($this->__shortcodes[$item['name']])){
                    if(!empty($item['content'])){
                        $content=$this->__process($item['content']);
                    }
                    else {
                        $content='';
                    }

                    if($this->__shortcodes[$item['name']] instanceof IBaseProcessor){
                        $s.=$this->__shortcodes[$item['name']]->process($items['attributes'],$content);
                    }
                    else if(is_callable($this->__shortcodes[$item['name']])){
                        $s.=call_user_func($this->__shortcodes[$item['name']],$item['attributes'],$content);
                    }
                    else if(is_string($this->__shortcodes[$item['name']])){
                        $s.=$this->__shortcodes[$item['name']];
                    }
                }
            }
        }

        return($s);
    }

    private function __parse($body,&$i,$c){
        $result=[];

        $text=$this->__parseText($body,$i,$c);

        while($text!==false){
            $result[]=$text;

            if($i<$c){
                $tag=$this->__parseTag($body,$i,$c);

                if($tag===false){
                    return(false);
                }

                $result[]=$tag;

                $text=$this->__parseTag($body,$i,$c);
            }
        }

        return($result);
    }

    private function __parseText($body,&$i,$c){
        $j=$i;
        $char=$this->__parseChar($body,$i,$c);

        if($char===false){
            return(false);
        }

        while(($char!==false) and ($char!='[')){
            $char=$this->__parseChar($body,$i,$c);

            if($char=='\\'){
                $char=$this->__parseChar($body,$i,$c);
                $char=$this->__parseChar($body,$i,$c);
            }
        }

        if($char!==false){
            --$i;
        }

        return(mb_substr($body,$j,$i-$j));
    }

    private function __parseTag($body,&$i,$c){
        $char=$this->__parseChar($body,$i,$c);

        if($char!=='['){
            return(false);
        }

        $name=$this->__parseName($body,$i,$c);

        if($name===false){
            return(false);
        }

        $this->__parseSpace($body,$i,$c);

        $attributes=$this->__parseAttributes($body,$i,$c);

        if($attributes===false){
            return(false);
        }

        $char=$this->__parseChar($body,$i,$c);

        if($char==']'){
            $content=$this->__parse($body,$i,$c);

            if($this->__parseEnd($body,$i,$c)===false){
                return(false);
            }

            return(['name'=>$name,'attributes'=>$attributes,'content'=>$content]);
        }

        if($char!='/'){
            return(false);
        }

        $char=$this->__parseChar($body,$i,$c);

        if($char!=']'){
            return(false);
        }

        return(['name'=>$name,'attributes'=>$attributes,'content'=>'']);
    }

    private function __parseEnd($body,&$i,$c){
        $char=$this->__parseChar($body,$i,$c);

        if($char!='['){
            return(false);
        }

        $char=$this->__parseChar($body,$i,$c);

        if($char!='/'){
            return(false);
        }

        $this->__parseName($body,$i,$c);

        $char=$this->__parseChar($body,$i,$c);

        if($char!=']'){
            return(false);
        }

        return(true);
    }

    private function __parseAttributes($body,&$i,$c){
        $attributes=[];
        $attribute=$this->__parseAttribute($body,$i,$c);

        while($attribute!==false){
            $attributes=array_merge($attributes,$attribute);
            $this->__parseSpace($body,$i,$c);
            $attribute=$this->__parseAttribute($body,$i,$c);
        }

        return($attributes);
    }

    private function __parseAttribute($body,&$i,$c){
        $name=$this->__parseName($body,$i,$c);

        if($name===false){
            return(false);
        }

        $char=$this->__parseChar($body,$i,$c);

        if($char!='='){
            --$i;

            return([$name=>true]);
        }

        $char=$this->__parseChar($body,$i,$c);

        if($char!='"'){
            --$i;

            $value=$this->__parseValue($body,$i,$c);

            if($value===false){
                return(false);
            }

            return([$name=>$value]);
        }

        $value=$this->__parseValue($body,$i,$c,'"');

        if($value===false){
            return(false);
        }

        return([$name=>$value]);
    }

    private function __parseName($body,&$i,$c){
        $j=$i;
        $char=$this->__parseChar($body,$i,$c);

        while(($char!==false) and (ctype_alnum($char) or ($char=='-') or ($char=='_'))){
            $char=$this->__parseChar($body,$i,$c);
        }

        if($i==$j){
            return(false);
        }

        return(mb_substr($body,$j,$i-$j));
    }

    private function __parseValue($body,&$i,$c,$separator=false){
        $j=$i;
        $char=$this->__parseChar($body,$i,$c);

        if($separator!==false){
            while(($char!==false) and ($char!=$separator)){
                $char=$this->__parseChar($body,$i,$c);

                if($char=='\\'){
                    $char=$this->__parseChar($body,$i,$c);
                    $char=$this->__parseChar($body,$i,$c);
                }
            }

            if($char===false){
                return(false);
            }

            $char=$this->__parseChar($body,$i,$c);

            return(mb_substr($body,$j,$i-$j));
        }

        while(($char!==false) and (!ctype_space($char))){
            $char=$this->__parseChar($body,$i,$c);
        }

        return(mb_substr($body,$j,$i-$j));
    }

    private function __parseSpace($body,&$i,$c){
        $char=$this->__parseChar($body,$i,$c);

        if($char===false){
            return(false);
        }
        if(!ctype_space($char)){
            return(false);
        }

        while(($char!==false) and (ctype_space($char))){
            $char=$this->__parseChar($body,$i,$c);
        }

        return(true);
    }

    private function __parseChar($body,&$i,$c){
        if($i>=$c){
            return(false);
        }

        $char=mb_substr($body,$i++,1);

        return($char);
    }



}