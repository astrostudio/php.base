<?php
namespace Base\Log;

class TimeLog extends ProxyLog
{
    public function write(string $message){
        parent::write(date('Y-m-d H:i:s').': '.$message);
    }
}
