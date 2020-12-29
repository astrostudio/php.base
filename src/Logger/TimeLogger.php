<?php
namespace Base\Logger;

class TimeLogger extends ProxyLogger
{
    const DELIMITER="\t";
    const FORMAT='Y-m-d H:i:s';

    protected $_format;
    protected $_delimiter;

    public function __construct(LoggerInterface $logger=null,string $format=self::FORMAT,string $delimiter=self::DELIMITER){
        parent::__construct($logger);

        $this->_format=$format;
        $this->_delimiter=$delimiter;
    }

    public function write(string $message,array $options=[]){
        parent::write(date($this->_format).$this->_delimiter.$message,$options);
    }

}
