<?php
namespace Base\Executor;

class LinuxExecutor extends BaseExecutor
{
    public function execute(string $cmd)
    {
        return(exec($cmd,$output));
    }

    public function launch(string $cmd):?int
    {
        $cmd.=' > /dev/null 2>&1 & echo $!';

        exec($cmd,$output);

        if(!empty($output[0])){
            return($output[0]);
        }

        return(null);
    }

    public function kill(int $pid)
    {
        return(exec('kill -9 '.$pid));
    }

}
