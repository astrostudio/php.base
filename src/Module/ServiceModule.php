<?php
namespace Base\Module;

use Exception;

class ServiceModule implements IModule {

    private $__url='';
    private $__options=null;
    private $__curl=null;

    private function __request($url,array $params=[],$type='post'){
        if($type=='get'){
            curl_setopt($this->__curl,CURLOPT_POST,0);

            if(!empty($params)){
                $url.='?'.http_build_query($params);
            }
        }
        else {
            curl_setopt($this->__curl,CURLOPT_POST,1);
            curl_setopt($this->__curl,CURLOPT_POSTFIELDS, $params);
        }

        curl_setopt($this->__curl,CURLOPT_URL,$this->__url.$url);

        $response=curl_exec($this->__curl);

        $error=curl_error($this->__curl);

        if ($error) {
            throw new Exception('TranslAide\\Module\\ServiceModule::execute():: '.$error);
        }

        $status=curl_getinfo($this->__curl, CURLINFO_HTTP_CODE);

        $ok=preg_match("/2../", $status);

        $json=json_decode($response,true);

        return($json);
    }

    public function __construct($url='',array $options=[],array $curlOptions=[]){
        $this->__url=$url;
        $this->__options=$options;

        $defaultOptions=[
            CURLOPT_SSL_VERIFYHOST=>0,
            CURLOPT_SSL_VERIFYPEER=>0,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_AUTOREFERER=>true,
            CURLOPT_HTTPHEADER=>[],
            CURLOPT_CONNECTTIMEOUT=>5
        ];

        $this->__url=$url;
        $this->__curl=curl_init();

        curl_setopt_array($this->__curl,array_replace_recursive($defaultOptions,$curlOptions));
    }

    public function __destruct(){
        curl_close($this->__curl);
    }

    public function execute($action=null,array $params=[]){
        $a=isset($action)?$action:'';
        $url='/';
        $type='post';

        if(!empty($this->__options[$a])){
            if(!empty($this->__options[$a]['url'])){
                $url.=$this->__options[$a]['url'];
            }
            else {
                $url.=$action;
            }

            if(!empty($this->__options[$a]['type'])){
                $type=$this->__options[$a]['type'];
            }
        }
        else {
            $url.=$a;
        }

        return($this->__request($url,$params,$type));
    }


}