<?php
    /**
     * All the functions releated to the core of a server
     * 
     * This file will include stuff like, restart, start, stop, sending commands and so on
     * 
     * @category Server
     * @package ControlPanel
     * @author Dennis &lt;dennistryy3@gmail.com>
     * @copyright 2014 Dennis Planting
     */

    include_once("Core/Class/status.php");

    $memory;
    $check = false;

    class Start
    {

        /**
         * Starts a server.
         *
         * @param string $name The name of the server.
         * 
         * @return boolean If the server started successfully or not.
         */

        public function start_server($name)
        {
            $path = "/home/tryy3/Control_Panel/Servers/" . $name;
            if(!file_exists($path))
            {
                mkdir($path);
                exec("screen -dmS " . $name);
            }

            if(!file_exists($path . "/craftbukkit.jar"))
            {
                try
                {
                    $config = new Config_Lite("/home/tryy3/Control_Panel/Config/config.ini");
                    $jar = $config->get("Download", "Bukkit_Dev");
                }
                catch (Config_Lite_Exception $e)
                {
                    echo "\n" . "Exception: " . $e->getMessage();
                    return;
                }

                $fh = fopen($path . "/craftbukkit.jar", 'w');

                echo $jar;

                $curl_Options = array(
                    CURLOPT_FILE            => $fh,
                    CURLOPT_TIMEOUT         => 28800,
                    CURLOPT_URL             => $jar,
                    CURLOPT_FOLLOWLOCATION  => true,
                );

                $ch = curl_init();
                curl_setopt_array($ch, $curl_Options);
                curl_exec($ch);

                curl_close($ch);
                fclose($fh);
            }

            exec("screen -S " . $name . " -X stuff \"cd " . $path . "\"'\n'");
            exec("screen -S " . $name . " -X stuff \"java -Xms1G -Xmx1G -XX:MaxPermSize=128M -jar craftbukkit.jar \"'\n'");
            
            $this->check = true;
            checkStatus($name);

            return true;
        }


        /**
         * Stops a server.
         * 
         * @param string $name The name of the server.
         * 
         * @return boolean If the server stopped successfully or not.
         */

        public function stop($name)
        {
            exec("screen -S " . $name . " -X stuff \"stop \"'\n'");
            return true;
        }


        /**
         * Restarts a server.
         * 
         * @param string $name The name of the server.
         * 
         * @return boolean If the server restarted successfully or not.
         */

        public function restart($name)
        {
            $this->stop($name);
            sleep(10);
            $this->server_start($name);
        }


        /**
         * Sends a command to the server.
         * 
         * @param string $name The name of the server.
         * @param string $command The command that should be sent to the server.
         * 
         * @return boolean If the command was sent successfully or not.
         */

        public function command($name, $command)
        {
            echo $command;
            if (is_array($command))
            {
                foreach ($command as $key => $value) {
                    exec("screen -S " . $name . " -X stuff \"" . $value . "\"'\n'");
                }

                return true;
            }

            exec("screen -S " . $name . " -X stuff \"" . $command . "\"'\n'");
            return true;
        }

        private function checkStatus($name)
        {
            $status = new MinecraftStatusCheck();
            $yaml = yaml_parse("/home/tryy3/Control_Panel/Servers/" . $name . "/server.properties");
            $port = $yaml["server-port"];
            $ip = $yaml ["server-ip"];

            if($ip == null || $ip == "0.0.0.0")
            {
                $ip = $_SERVER['SERVER_ADDR'];
            }

            while($this->check)
            {
                $response = $status->getStatus($ip, "1.7.*", $port);

                if (!response)
                {
                    break;
                }
                sleep(5);
            }

            $this->check = false;
            return false;
        }
    }
?>