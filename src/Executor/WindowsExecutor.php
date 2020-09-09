<?php
namespace Base\Executor;

class WindowsExecutor extends BaseExecutor
{
    public function execute(string $cmd)
    {
        return(exec($cmd,$output));
    }

    public function launch(string $cmd):?int{
        $output= [];
        $ps=LOGS.uniqid('ps');
        $exec="PsExec.exe -d $cmd 2>$ps";

        exec($exec,$output);
        $output=file($ps);

        if(!empty($output[5])){
            preg_match('/ID (\d+)/',$output[5],$matches);
            $pid=$matches[1];
        }
        else {
            $pid=null;
        }

        return($pid);
    }

    public function kill($pid)
    {
        exec('pskill '.$pid);

        return(true);
    }

}
