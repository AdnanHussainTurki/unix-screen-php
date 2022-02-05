<?php

namespace myPHPnotes\Models;

use Illuminate\Database\Eloquent\Model;

class DataStore {
    protected  $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
    public function clear()
    {
        $this->model->truncate();
    }
    public function add($id,$timeout, $temp_shell_path, $arguments, $log_file_path)
    {
        $this->model->create(['slug'=>$id, "timeout" => $timeout, "exitcode" => null, 'data'=> json_encode([
            "temp_shell_file_path" => $temp_shell_path,
            "temp_log_path" => $log_file_path,
            "arguments" => $arguments
        ]), "closed" => false, "success" => null, "started_at" => date("d-m-Y h:i:s"), "started_at_unix" => time(), "remark" => "Started"]);
    }
    public function setExitCode(Model $process, int $exitcode)
    {
        $process->exitcode = $exitcode;
        $process->save();
    }
    public function markUnsuccessful(Model $process)
    {
        $process->success = false;
        $process->save();
    }
    public function close(Model $process)
    {
        $process->closed = true;
        $process->save();
    }
    public function open()
    {
        return $this->model->where("closed", false)->get();
    }
}
