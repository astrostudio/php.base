<?php
namespace Base\Locale\Server;

class FileLocaleServer extends BaseLocaleServer
{
    const EXTENTIONS=[
        'txt',
        'html'
    ];

    private $folder;
    private $extensions=[];

    public function __construct(string $folder='.',array $extensions=self::EXTENTIONS){
        $this->folder=$folder;
        $this->extensions=$extensions;
    }

    public function get(string $locale,string $alias):?string
    {
        $path=$this->folder.DIRECTORY_SEPARATOR.$locale.DIRECTORY_SEPARATOR.$alias.'.';

        foreach($this->extensions as $extension){
            if(file_exists($path.$extension)){
                return(file_get_contents($path.$extension));
            }
        }

        return(null);
    }
}
