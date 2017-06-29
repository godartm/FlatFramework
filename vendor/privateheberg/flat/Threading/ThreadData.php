<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 27/02/2017
 * Time: 18:41
 */

namespace PrivateHeberg\Flat\Threading;


class ThreadData
{

    public $classname;
    public $thread_id;
    public $params;
    public $get;
    public $post;
    public $session;
    public $error;
    public $return;
    public $run;


    /**
     * @return mixed
     */
    public function getClassname()
    {
        $this->update();

        return $this->classname;
    }

    private function update()
    {
        $file_path = _CONFIG['dirs']['tmp'] . '/thread/' . $this->thread_id . '.pthread';
        $fp = fopen($file_path, 'r');
        $contents = fread($fp, filesize($file_path));

        fclose($fp);


        /** @var ThreadData $data */

        $data = unserialize($contents);
        $this->classname = $data->classname;
        $this->thread_id = $data->thread_id;
        $this->params = $data->params;
        $this->get = $data->get;
        $this->post = $data->post;
        $this->session = $data->session;
        $this->error = $data->error;
        $this->return = $data->return;
        $this->run = $data->run;

    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        $this->update();

        return $this->params;
    }

    /**
     * @return mixed
     */
    public function getGet()
    {
        $this->update();

        return $this->get;
    }

    /**
     * @return mixed
     */
    public function getPost()
    {
        $this->update();

        return $this->post;
    }

    /**
     * @return mixed
     */
    public function getSession()
    {
        $this->update();

        return $this->session;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        $this->update();

        return $this->error;
    }

    /**
     * @return mixed
     */
    public function getReturn()
    {
        $this->update();

        return $this->return;
    }

    /**
     * @return mixed
     */
    public function getRun()
    {
        $this->update();

        return $this->run;
    }


}