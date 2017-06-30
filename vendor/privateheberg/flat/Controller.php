<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 03/11/2016
 * Time: 06:16
 */

namespace PrivateHeberg\Flat;


use PrivateHeberg\Flat\Event\Event;
use PrivateHeberg\Flat\Event\EventWrapper\GetGlobalUpdaterEvent;

class Controller
{
    public $model = array();
    /** @var  Bootstrap */
    public  $process;
    public  $view_path;
    public  $view_path_cached;
    public  $view_name;
    public  $action;
    private $router;


    /**
     * Retourne une instance de ORM pour l'accées a la database
     *
     * @param int $id
     * @deprecated
     * @return \NotORM
     */
    public function getDatabase($id = 0)
    {
        return BasicWrapper::getDatabase($id);
    }

    public function getEmailer($sid = 0)
    {
        return BasicWrapper::getEmailer($sid);
    }

    public function getIP()
    {
        return BasicWrapper::getIP();
    }

    /**
     * @param $id int user id
     * @param $info string column name
     *
     * @return string|null info (null if info doesn't exist
     */
    public function getUserInfo($id, $info)
    {
        return BasicWrapper::getUserInfo($id, $info);

    }

    public function updateProgress()
    {

    }

    public function trans($string)
    {

        return BasicWrapper::trans($string);

    }

    public function getFilter()
    {
        return BasicWrapper::getFilter();
    }

    /**
     * @param String $view_name
     *
     * @return void
     */
    public function render($view_name)
    {

        echo BasicWrapper::render($view_name, $this->model);

    }

    public function getRender($view_name, $args, $render = true)
    {
        return BasicWrapper::render($view_name, $args, $render);
    }

    public function post($value)
    {
        return BasicWrapper::post($value);
    }

    public function get($value)
    {
        return BasicWrapper::get($value);
    }

    public function getUserLang()
    {
        return BasicWrapper::getUserLang();
    }

    public function setUserLang($lang)
    {
        BasicWrapper::setUserLang($lang);

    }

    public function getLangs()
    {
        return BasicWrapper::getLangs();
    }


    public function update($identifier, $text)
    {
        $this->action[] = array(
            'action' => 'update',
            'id'     => $identifier,
            'text'   => $text
        );
    }

    public function apprend($identifier, $text)
    {
        $this->action[] = array(
            'action' => 'apprend',
            'id'     => $identifier,
            'text'   => $text
        );
    }

    public function bgcolor($identifier, $hexacolor)
    {
        $this->action[] = array(
            'action' => 'bgcolor',
            'id'     => $identifier,
            'color'  => $hexacolor
        );
    }

    public function txcolor($identifier, $hexacolor)
    {
        $this->action[] = array(
            'action' => 'bgcolor',
            'id'     => $identifier,
            'color'  => $hexacolor
        );
    }

    public function process($name)
    {
        $this->action[] = array(
            'action' => 'process',
            'name'   => $name
        );
    }

    public function notify($msg, $isSuccess = true, $title = null)
    {
        if (is_bool($isSuccess)) {
            if ($isSuccess == true) {
                $notify = 'success';
            } else {
                $notify = 'error';
            }
        } else {
            $notify = $isSuccess;
        }

        $this->action[] = array(
            'action'  => 'notify',
            'type'    => $notify,
            'message' => $msg,
            'title'   => $title
        );
    }

    public function clearForm($identifier)
    {
        /*        $this->action[] = [
                    'action' => 'clearForm',
                    'id' => $identifier

                ];*/
    }

    public function redirect($uri, $strict = false)
    {
        if (SOCKET) {
            $this->action[] = array(
                'action' => 'redirect',
                'uri'    => $uri,
                'strict' => $strict
            );
        } else {
            header('Location: ' . $uri);
            exit();
        }

    }

    public function result()
    {
        $event = new GetGlobalUpdaterEvent();
        $event->setController($this);
        if ($this->process->isUpdate) {
            Event::call('onGetGlobalUpdater', $event);
        }


        echo json_encode($this->action);
    }

    public function route($name)
    {

        return BasicWrapper::route($name);
    }

    public function getCryptographie()
    {
        return BasicWrapper::getCryptographie();
    }

    public function setProcess(Bootstrap $process)
    {
        $this->process = $process;
    }

    public function urlMapping($string)
    {

        return BasicWrapper::urlMapping($string);

    }

    public function setData($string, $data)
    {
        $this->set($string, $data);
    }

    /**
     * @param mixed $key
     * @param mixed $data
     */
    public function set($key, $data)
    {
        $this->model[$key] = $data;
    }

}

