<?php
namespace Base\Module;

use Exception;

class GuardModule extends ProxyModule {

    static public function check(array &$params=[],$name,$settings,&$error){
        if(isset($settings) and is_array($settings)){
            if(!isset($params[$name])){
                if(empty($settings['required'])){
                    if(isset($settings['default'])){
                        $params[$name]=$settings['default'];
                    }

                    return(true);
                }

                $error='TranslAide\\Module\\GuardModule::check(): Param "'.$name.'" is required';

                return(false);
            }

            if(!empty($settings['value'])){
                if(is_array($settings['value'])){
                    if(!in_array($params[$name],$settings['value'])){
                        $error='TranslAide\\Module\\GuardModule::check(): Value of param "'.$name.'" is not valid';

                        return(false);
                    }
                }
                else if(is_callable($settings['value'])){
                    if(!call_user_func($settings['value'],$params[$name])){
                        $error='TranslAide\\Module\\GuardModule::check(): Value of param "'.$name.'" is not valid';

                        return(false);
                    }
                }
            }

            return(true);
        }

        if(!isset($params[$name])){
            if($settings===false){
                return(true);
            }

            $error='TranslAide\\Module\\GuardModule::check(): Param "'.$name.'" is required';

            return(false);
        }

        if($settings===true){
            return(true);
        }

        if($params[$name]!=$settings){
            $error='TranslAide\\Module\\GuardModule::check(): Param "'.$name.'" must be "'.$settings.'"';

            return(false);
        }

        return(true);
    }

    private $__settings=[];

    public function __construct($module,array $settings=[]){
        parent::__construct($module);

        $this->__settings=$settings;
    }

    public function execute($action=null,array $params=[]){
        $a=isset($action)?$action:'default';

        if(empty($this->__settings[$a])){
            throw new Exception('TranslAide\\Module\\GuardModule: Action "'.$a.'" not allowed');
        }

        $ok=false;
        $error='';

        foreach($this->__settings[$a] as $settings){
            $ok=true;

            foreach($settings as $name=>$value){
                if(!self::check($params,$name,$value,$error)){
                    $ok=false;

                    break;
                }
            }

            if($ok){
                break;
            }
        }

        if(!$ok){
            throw new Exception($error);
        }

        return(parent::execute($action,$params));
    }

}