<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 27/02/2017
 * Time: 18:26
 */

namespace PrivateHeberg\Flat\Threading;


use PrivateHeberg\Flat\BasicWrapper;
use PrivateHeberg\Flat\Threading\Exception\NotTransferableArgs;

class Thread
{

    private $thread_id = null;
    private $class;
    private $params;
    private $thread;

    /**
     * Thread constructor.
     *
     * @param $class string Classname
     * @param $params array Params
     *
     * @throws NotTransferableArgs
     */
    public function __construct($class, $params)
    {

        $this->class = $class;
        $this->params = $params;

        $this->thread = new ThreadData();
        $this->thread->classname = $this->class;
        $this->thread->params = $this->params;
        $this->thread->get = $_GET;
        $this->thread->post = $_POST;
        $this->thread->session = $_SESSION;
        $this->thread->run = false;


        $this->thread_id = BasicWrapper::getCryptographie()->stringGenerator(128);
        $this->thread->thread_id = $this->thread_id;
        $file_path = _CONFIG['dirs']['tmp'] . '/thread/' . $this->thread_id . '.pthread';

        $fp = fopen($file_path, 'w');

        fwrite($fp, serialize($this->thread));
        fclose($fp);

    }

    /**
     * @return ThreadData
     */
    public function run()
    {
        shell_exec('nohup php ' . __DIR__ . '/../../../../console/runnable.php ' . $this->thread_id . ' > /dev/null 2>&1 &');

        return $this->thread;
    }
}