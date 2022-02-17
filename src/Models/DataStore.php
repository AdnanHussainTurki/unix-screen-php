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
        return $this->model->create(['slug'=>$id, "timeout" => $timeout, "exitcode" => null, 'data'=> json_encode([
            "temp_shell_file_path" => $temp_shell_path,
            "temp_log_path" => $log_file_path,
            "arguments" => $arguments
        ]), "closed" => false, "success" => null, "started_at" => date("Y-m-d h:i:s"), "started_at_unix" => time(), "remark" => "Started"]);
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
    public function markSuccessful(Model $process)
    {
        $process->success = true;
        $process->save();
    }
    public function close(Model $process)
    {
        $process->closed = true;
        $process->save();
    }
    public function open($process_id = null)
    {
        if (!is_null($process_id)) {
            return $this->model->where("closed", false)->where("slug", $process_id)->get();
        }
        return $this->model->where("closed", false)->get();
    }
}
