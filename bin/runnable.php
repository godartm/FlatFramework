<?php

use PrivateHeberg\Flat\Threading\ThreadData;

define('SOCKET', false);
require_once(__DIR__ . '/../app/autoload.php');

/**
 * Class AsyncThread
 */
class AsyncThread
{


    public $thread_id;
    public $file_path;

    /**
     * AsyncThread constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {

        $this->thread_id = $id;
        $this->file_path = _CONFIG['dirs']['tmp'] . '/thread/' . $this->thread_id . '.pthread';
        if (file_exists($this->file_path)) {

            $fp = fopen($this->file_path, 'c+');
            $contents = fread($fp, filesize($this->file_path));
            fclose($fp);
            /** @var ThreadData $data */
            $data = unserialize($contents);


            foreach ($data->get as $key => $value) {
                $_GET[$key] = $value;
            }

            foreach ($data->post as $key => $value) {
                $_POST[$key] = $value;
            }

            foreach ($data->session as $key => $value) {
                $_SESSION[$key] = $value;
            }

            $className = $data->classname; //ont set ne nom de la class a call

            $data->run = true;

            $this->update($data);

            try {
                $content = null;

                if (class_exists($className)) {
                    $class = new $className(); //On créer l'instace de la class


                    $methodName = 'run';


                    if (method_exists($class, $methodName)) {
                        ob_start();
                        $returnable = call_user_func_array([$class, $methodName], [$data->params]); //On call la methode
                        $content = ob_get_clean();
                    }
                }

                if (!empty($returnable)) {
                    $data->return = $returnable;
                } else {
                    $data->return = $content;
                }
            } catch (Exception $e) {

                $data->error = true;
                $data->return = $e->getMessage();
            }


            $data->run = false;

            $this->update($data);


        }


    }

    /**
     * @param $data
     */
    public function update($data)
    {

        try {


            $fp = fopen($this->file_path, 'w');

            fwrite($fp, serialize($data));
            fclose($fp);
        } catch (Exception $e) {

        }

    }
}

new AsyncThread($argv['1']);


