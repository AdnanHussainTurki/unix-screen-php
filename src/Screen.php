<?php 

namespace myPHPnotes;

use Exception;
use myPHPnotes\Helpers\Heartbeat;
use myPHPnotes\Models\DataStore;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Illuminate\Database\Eloquent\Model;
class Screen {
    protected $datastore;
    public $logs_path;
    public $shells_path;
    public function __construct($screen_path, Model $model)
    {
        #TODO: Permission to be set
        #TODO: Make sure the Screen native is installed
        if (!file_exists($screen_path)) {
            mkdir($screen_path);
        }
        $this->logs_path = $screen_path.DIRECTORY_SEPARATOR."logs";
        $this->shells_path = $screen_path.DIRECTORY_SEPARATOR."shells";
        if (!file_exists($this->logs_path)) {
            mkdir($this->logs_path);
        }
        if (!file_exists($this->shells_path)) {
            mkdir($this->shells_path);
        }
        // JSON based data
        $this->datastore = new DataStore($model);
    }

    public function executeCommand($command,$arguments = [], $identifier = null, $timeout=30)
    {
        if (is_null($identifier)) {
            $identifier = time()."_".md5(random_bytes(1));
        }
        $file_path = $this->createShell("single", $identifier, $command);
        $this->execute($file_path, $arguments,  $identifier, $timeout);
    }
    public function executeFile($user_shell_path, $arguments = [], $identifier = null,$timeout = 30) {
        if (is_null($identifier)) {
            $identifier = time()."_".md5(random_bytes(1));
        }
        $file_path = $this->createShell("multiple", $identifier, file_get_contents($user_shell_path));
        $this->execute($file_path, $arguments,  $identifier, $timeout);
    }
    public function execute($temp_shell_path, $arguments = [], $uniqueId = null,$timeout = 30) {
        if (is_null($uniqueId)) {
            $uniqueId = md5(random_bytes(15));
        }
        $this->datastore->add($uniqueId, $timeout, $temp_shell_path, $arguments, $this->logs_path .DIRECTORY_SEPARATOR.$uniqueId. ".log", );
        $process = new Process(array_merge(['sudo','screen', 
                                    '-dmS', $uniqueId ,
                                    "-L","-Logfile", $this->logs_path .DIRECTORY_SEPARATOR.$uniqueId. ".log",
                                    "bash", $temp_shell_path 
            ], $arguments));
        $process->setTimeout($timeout);
        // echo $process->getCommandLine();
        // die();
        $process->run(null, ['TMOUT' => $timeout]);


        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();

    }
    protected function createShell($type,$identifier, $command, $shell = "bash") {
        $filename = $this->shells_path . DIRECTORY_SEPARATOR . $identifier  . ".sh";
        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR . $type. ".".$shell . ".template");
        $actual = str_replace("__COMMAND__", $command,$template);
        #TODO: Fix permissions
        try {
            file_put_contents($filename,$actual);
        } catch(\Exception $e) {
            throw new \Exception("Cannot create the shell file out of the command!");
            return false;
        }
        return $filename;
    } 
    public static function close($screen_name)
    {
        # code...
    }
    public function datastore()
    {
        return $this->datastore;
    }
    public function heartbeat() {
        Heartbeat::run($this->datastore());
    }
}