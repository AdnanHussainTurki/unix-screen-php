<?php

namespace myPHPnotes\Helpers;

use myPHPnotes\Models\DataStore;
use myPHPnotes\Screen;

class Heartbeat {
    public static function run(DataStore $datastore, $process_id=null) {
        // Get the processes which are not closed
        foreach($datastore->open($process_id) as $process) {
            // dump ($process->slug);
            // If the process is successful or failed
            if (!is_null($process->success)) {
                // dump("Process is either failed or passed, hence closing it");
                // Close the process and its screen and do nothing further
                $datastore->close($process);
                Screen::close($process->slug);
            }


            // Checking the exit code of from log file
            if (file_exists(json_decode($process->data)->temp_log_path)) {
                // If the exit code is there
                $log_content = file_get_contents(json_decode($process->data)->temp_log_path);
                $subject = str_replace("\r", "", $log_content);
                $matches = preg_grep("/(^__EXIT)(.*?)(__END$)/",explode("\n", $subject));
                // dump("Got data from log file");
                if (count($matches) == 1) {
                    // If some exit code is present
                    $matches = implode(",",$matches);
                    $exitcode = (int) (str_replace("__END","",str_replace("__EXITCODE:","",$matches)));
                    // dump("Setting exit code to " .  $exitcode);
                    $datastore->setExitCode($process, $exitcode);
                    if ($exitcode == 0) {
                        // dump("Setting process as successful");
                        $datastore->markSuccessful($process);
                        $datastore->close($process);
                        Screen::close($process->slug);
                    } else {
                        // dump("Setting process as unsuccessful");
                        $datastore->markUnsuccessful($process);
                        $datastore->close($process);
                        Screen::close($process->slug);
                    }

                // If the exit code is not there
                } else {
                    // Check the timeout
                    // If the timeout is done
                    if (($process->timeout+$process->started_at_unix) < time()) {
                        // dump("TIME OUT");
                        // Mark the process as closed and unsuccessful
                        $datastore->markUnsuccessful($process);
                        $datastore->close($process);
                        // Force close the screen
                        Screen::close($process->slug);
                    }
                    // If the timeout is not done, leave it as is
                }
            } else {
                    // dump("Log file does not exist");
                $datastore->close($process);
                Screen::close($process->slug);
            }
        }
    }
}
