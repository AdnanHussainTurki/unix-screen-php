<?php

namespace myPHPnotes\Helpers;

use myPHPnotes\Models\DataStore;
use myPHPnotes\Screen;

class Heartbeat {
    public static function run(DataStore $datastore) {
        // Get the processes which are not closed 
        foreach($datastore->open() as $process)
            // If the process is successful or failed
            if (!is_null($process->success)) {
                // Close the process and its screen and do nothing further
                $datastore->close($process);
                Screen::close($process->id);
            }
            

        // Checking the exit code of from log file 
        if (file_exists(json_decode($process->data)->temp_log_path)) {
            // If the exit code is there
            $log_content = file_get_contents(json_decode($process->data)->log_file_path);
            $subject = str_replace("\r", "", $log_content);
            $matches = preg_grep("/(^__EXIT)(.*?)(__END$)/",explode("\n", $subject));
            if (count($matches) == 1) {
                // If some exit code is present
                $matches = implode(",",$matches);
                $exitcode = (int) (str_replace("__END","",str_replace("__EXITCODE:","",$matches)));
                $datastore->setExitCode($process, $exitcode);
            
            // If the exit code is not there
            } else {
                // Check the timeout
                // If the timeout is done
                if (($process->timeout+$process->started_at_unix) < time()) {
                    // Mark the process as closed and unsuccessful 
                    $datastore->markUnsuccessful($process);
                    $datastore->close($process);
                    // Force close the screen
                    Screen::close($process->id);
                } 
                // If the timeout is not done, leave it as is
            }


        }
    }
}