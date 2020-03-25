<?php
namespace Base;

class SVG extends XML {

    static public function option(array &$options,string $name,string $value=null,bool $set=false):string{
        if(isset($options[$name])){
            return($options[$name]);
        }

        if(isset($value)){
            if($set){
                $options[$name]=$value;
            }
        }

        return($value);
    }

    public function svg(array $options= []):string
    {
        return($this->start('svg',$options));
    }

    public function begin(int $width,int $height,array $options= []):string
    {
        self::option($options,'xmlns','http://www.w3.org/2000/svg',true);
        self::option($options,'version','1.1',true);
        $options['width']=$width;
        $options['height']=$height;

        return($this->svg($options));
    }

    public function view(int $width,int $height,float $ratio=null,int $sleft=0,int $stop=0,int $swidth=null,int $sheight=null,array $options= []):string{
        if(!isset($swidth)){
            $swidth=$width;
        }

        if(!isset($sheight)){
            $sheight=$height;
        }

        self::option($options,'preserveAspectRatio',$ratio,true);
        self::option($options,'width',$width,true);
        self::option($options,'height',$width,true);
        self::option($options,'viewbox',$sleft.' '.$stop.' '.$swidth.' '.$sheight,true);

        return($this->svg($options));
    }

    public function group(array $options= [],string $content=null):string
    {
        return($this->element('g',$options,$content));
    }

    public function translate(int $x=0,int $y=0,array $options= [],string $content=null):string
    {
        $options['transform']='translate('.$x.','.$y.')';

        return($this->group($options,$content));
    }

    public function scale(float $s=1.0,array $options= [],string $content=null):string
    {
        $options['transform']='scale('.$s.')';

        return($this->group($options,$content));
    }

    public function rotate(int $cx,int $cy,float $delta=0.0,array $options= [],string $content=null):string
    {
        $options['transform']='rotate('.$delta.','.$cx.','.$cy.')';

        return($this->group($options,$content));
    }

    public function opacity(float $opacity=1.0,array $options= [],string $content=null):string
    {
        $options['style']=CSS::style(['opacity' =>$opacity]);

        return($this->group($options,$content));
    }

    public function link(string $url=null,array $options= [],string $content=null):string
    {
        $options['xlink:href']=$url;

        return($this->element('a',$options,$content));
    }

    static public function rgb(int $r,int $g,int $b)
    {
        return('rgb('.$r.','.$g.','.$b.')');
    }

    static public function card(int $x,int $y,int $radius,float $angle):array
    {
        $r=deg2rad($angle);

        return([
            'x'=>$x+round($radius*cos($r)),
            'y'=>$y-round($radius*sin($r))
        ]);
    }

    static public function rectangle(int $x,int $y,int $width,int $height,array $options= []):string {
        $options['x']=$x;
        $options['y']=$y;
        $options['width']=$width;
        $options['height']=$height;

        return(self::simple('rect',$options));
    }

    static public function circle(int $x,int $y,int $radius,array $options= []):string
    {
        $options['cx']=$x;
        $options['cy']=$y;
        $options['r']=$radius;

        return(self::simple('circle',$options));
    }

    static public function ellipse(int $x,int $y,int $rx,int $ry,array $options= []):string
    {
        $options['cx']=$x;
        $options['cy']=$y;
        $options['rx']=$rx;
        $options['ry']=$ry;

        return(self::simple('ellipse',$options));
    }

    static public function line(int $x1,int $y1,int $x2,int $y2,array $options= []):string
    {
        $options['x1']=$x1;
        $options['y1']=$y1;
        $options['x2']=$x2;
        $options['y2']=$y2;

        return(self::simple('line',$options));
    }

    static public function polygon(array $points,array $options= []):string
    {
        $options['points']=self::points($points);

        return(self::simple('polygon',$options));
    }

    static public function polyline(array $points,array $options= []):string
    {
        $options['points']=self::points($points);

        return(self::simple('polyline',$options));
    }

    public function text(int $x,int $y,string $text,array $options= []):string
    {
        $options['x']=$x;
        $options['y']=$y;

        return($this->element('text',$options,$text));
    }

    public function tspan(string $text,array $options= []):string
    {
        return($this->element('tspan',$options,$text));
    }

    public function label(int $x,int $y,string $text,array $options= []):string
    {
        $style=!empty($options['style'])?$options['style']:'';
        $style=CSS::merge($style,
            [
            'text-anchor'=>'middle',
            'dominant-baseline'=>'central'
            ]
        );
        $options['style']=$style;

        return($this->text($x,$y,$text,$options));
    }

    static public function image(int $x,int $y,int $width,int $height,array $options= []):string
    {
        $options['x']=$x;
        $options['y']=$y;
        $options['width']=$width;
        $options['height']=$height;

        return(self::simple('image',$options));
    }

    static public function arc(int $x,int $y,int $r,float $start,float $stop,array $options= []):string
    {
        $s=self::card($x,$y,$r,$start);
        $e=self::card($x,$y,$r,$stop);

        if(abs($stop-$start)>=180.0) {
            $v=1;
        }
        else {
            $v=0;
        }

        $d='M'.$s['x'].','.$s['y'].' A'.$r.','.$r.' 0 '.$v.',0 '.$e['x'].','.$e['y'].' z';

        $options['d']=$d;

        return(self::simple('path',$options));
    }

    static public function sector(int $x,int $y,int $r1,int $r2,float $start,float $stop,array $options= []):string
    {
        if($r1<$r2) {
            $r=$r1;
            $r1=$r2;
            $r2=$r;
        }

        $s1=self::card($x,$y,$r1,$start);
        $e1=self::card($x,$y,$r1,$stop);
        $s2=self::card($x,$y,$r2,$start);
        $e2=self::card($x,$y,$r2,$stop);

        if(abs($stop-$start)>=180.0) {
            $v=1;
        }
        else {
            $v=0;
        }

        $d='M'.$s2['x'].','.$s2['y'].' L'.$s1['x'].','.$s1['y'].' A'.$r1.','.$r1.' 0 '.$v.',0 '.$e1['x'].','.$e1['y'].' L'.$e2['x'].','.$e2['y'].' A'.$r2.','.$r2.' 0 '.$v.',1 '.$s2['x'].','.$s2['y'].' z';

        $options['d']=$d;

        return(self::simple('path',$options));
    }

    static public function points(array $points):string {
        $i=0;
        $s='';
        foreach($points as $point) {
            if (($i % 2) == 1) {
                $s = $s . ',';
            } else {
                $s = $s . ' ';
            }
            $s = $s . $point;
            ++$i;
        }

        return($s);
    }
}
