<?php
namespace Base;

use Exception;

class Curl
{
    const OPTIONS=[
        CURLOPT_SSL_VERIFYHOST=>0,
        CURLOPT_SSL_VERIFYPEER=>0,
        CURLOPT_POST=>false,
        CURLOPT_RETURNTRANSFER=>true,
        CURLOPT_AUTOREFERER=>true,
        CURLOPT_HTTPHEADER=>[],
        CURLOPT_CONNECTTIMEOUT=>5
    ];

    /** @var string  */
    protected $_url;
    protected $_curl;

    static protected function _insert( $arrays, &$new = [], $prefix = null ) {

        if ( is_object( $arrays ) ) {
            $arrays = get_object_vars( $arrays );
        }

        foreach ( $arrays AS $key => $value ) {
            $k = isset( $prefix ) ? $prefix . '[' . $key . ']' : $key;
            if ( is_array( $value ) OR is_object( $value )  ) {
                self::_insert( $value, $new, $k );
            } else {
                $new[$k] = $value;
            }
        }
    }

    static protected function _build(array $data=[],$prefix=null){
        $post=[];

        foreach($data as $key=>$value) {
            $k=isset($prefix)?($prefix.'['.$key.']'):$key;

            if(is_array($value)){
                $post[$k]=self::_build($value,$k);
            }
            else {
                $post[$k]=$value;
            }
        }

        return($post);
   }

    public function __construct(
        string $url,
        array $options=[]
    ){
        $this->_url=$url;
        $this->_curl=curl_init();

        curl_setopt_array($this->_curl,Base::extend(self::OPTIONS,$options));
    }

    public function request(string $url,array $query=[],array $options=[]){
        $query=http_build_query($query);

        $url=$this->_url.$url;

        if(!empty($query)){
            $url.='?'.$query;
        }

        curl_setopt($this->_curl,CURLOPT_URL,$url);

        foreach($options as $key=>$value){
            curl_setopt($this->_curl,$key,$value);
        }

        $response=curl_exec($this->_curl);

        $status=curl_getinfo($this->_curl, CURLINFO_HTTP_CODE);

        $ok=preg_match("/2../", $status);

        if(!$ok){
            throw new Exception(curl_error($this->_curl),$status);
        }

        $json=json_decode($response,true);

        return($json);
    }

    public function get(string $url,array $query=[]){
        return($this->request($url,$query,[
            CURLOPT_POST=>false
        ]));
    }

    public function json(string $url,array $data=[],array $options=[]){
        return($this->request($url,[],Base::extend([
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>json_encode($data),
            CURLOPT_HTTPHEADER=>['Content-Type:application/json']
        ],$options)));
    }

    public function post(string $url,array $data=[],array $options=[]){
        return($this->request($url,[],Base::extend([
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>http_build_query($data)
        ],$options)));
    }



}
