<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 22/02/2017
 * Time: 07:17
 */

namespace PrivateHeberg\Flat;


use Exception;
use NotORM;
use PDO;
use PDOException;
use PrivateHeberg\Flat\Event\Event;
use PrivateHeberg\Flat\Event\EventWrapper\GetUserInfoEvent;
use PrivateHeberg\Flat\Exception\RouterNotFoundException;
use PrivateHeberg\Flat\Threading\Thread;
use PrivateHeberg\ORM;

class BasicWrapper
{
    private static $fileloader;
    /**
     * @var Database[]
     */
    private static $database;


    public static function getIP()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * @param $class
     * @param $params
     *
     * @return Thread
     */
    public static function async($class, $params)
    {
        return new Thread($class, $params);
    }

    public static function getUserInfo($id, $info)
    {
        $event = new GetUserInfoEvent();
        $event->setId($id);
        $event->setInfo($info);

        return Event::call('onGetUserInfo', $event);
    }

    public static function redirect($uri)
    {
        if (SOCKET) {
            echo json_encode(array(
                'action' => 'redirect',
                'uri'    => $uri
            ));
        } else {
            header('Location: ' . $uri);
            exit();
        }

    }

    public static function trans($string)
    {
        $default_lang = '';
        $explode = explode('.', $string);

        $lang = _CONFIG['lang'];
        if (isset($_SESSION['flat']['lang'])) {
            $lang = $_SESSION['flat']['lang'];
        }
        if (count($explode) > 1) {
            $trans_dir = _CONFIG['dirs']['trans'] . '/' . $lang . '/' . $default_lang . '/' . $explode[0] . '.php';
            if (file_exists($trans_dir)) {
                include($trans_dir);
                $stringacc = str_replace($explode[0] . '.', '', $string);
                if (isset($TRANS[$stringacc])) {
                    return $TRANS[$stringacc];
                }
            } else {
                throw new Exception($trans_dir);
            }
        }

        return "ERROR";
    }

    public static function getLangs()
    {
        $langs = null;
        foreach (scandir(__DIR__ . '/../../../app/trans') as $file) { // iterate files
            if ($file != '.' and $file != '..') {
                $langs[] = $file;
            }
        }

        return $langs;
    }

    public static function getUserLang()
    {
        $lang = _CONFIG['lang'];
        if (isset($_SESSION['flat']['lang'])) {
            $lang = $_SESSION['flat']['lang'];
        }

        return $lang;
    }

    public static function setUserLang($lang)
    {

        $_SESSION['flat']['lang'] = $lang;

    }

    public static function getFilter()
    {
        return new Filter();
    }

    public static function route($name)
    {
        $router = new Router();
        //Loading all route
        foreach (_CONFIG['dirs']['router'] as $rt) {
            if (file_exists($rt)) {
                include $rt;
            } else {
                throw new RouterNotFoundException("Cannot find router on " . $rt);
            }

        }

        $route_path = null;
        foreach ($router->getAllRoute() as $rt1) {
            if ($rt1['2'] == $name) {

                $route_path = $rt1['1'];
                break;
            }
        }


        if (strstr(_CONFIG['uri'] . $route_path, 'https://')) {
            return str_replace('https:/', 'https://', str_replace('//', '/', _CONFIG['uri'] . $route_path));
        }

        return str_replace('http:/', 'http://', str_replace('//', '/', _CONFIG['uri'] . $route_path));
    }

    public static function urlMapping($string)
    {

        return _CONFIG['uri'] . $string;

    }

    public static function getCryptographie()
    {
        return new Cryptographie();
    }


    public static function post($value)
    {
        if (isset($_POST[$value])) {
            return htmlspecialchars($_POST[$value], ENT_QUOTES, 'UTF-8');
        }

        return null;
    }

    public static function get($value)
    {
        if (isset($_GET[$value])) {
            return htmlspecialchars($_GET[$value], ENT_QUOTES, 'UTF-8');
        }

        return null;
    }

    public static function render($view_name, $model, $update = false)
    {

        global $_GLOBAL;


        $ri = new RenderInstance();
        $ri->setViewName($view_name);
        if (!$update) {
            $ri->setViewPath(_CONFIG['dirs']['template'] . '/');
        } else {
            $ri->setViewPath(_CONFIG['dirs']['template'] . '/updateable/');
        }
        $ri->setViewPathCached(_CONFIG['dirs']['tmp'] . '/view/');
        $ri->setModel(array_merge($model, array('global' => $_GLOBAL)));
        $data = new Templating($ri);

        return $data->get();


    }

    /**
     * @param int $id
     *
     * @return NotORM
     */
    public static function getDatabase($id = 0)
    {

        if (isset(BasicWrapper::$database[$id])) {
            if (BasicWrapper::$database[$id]->expire + 1800 < time()) {
                self::makeDatabase($id);
            }

        } else {
            if (!empty(_CONFIG['database'][$id])) {
                self::makeDatabase($id);
            }
        }

        return BasicWrapper::$database[$id]->db;


    }

    /**
     * Make database with cache system
     * @param $id
     */
    private static function makeDatabase($id)
    {
        try {
            $PDO = new PDO('mysql:host=' . _CONFIG['database'][$id]['host'] . ';dbname=' . _CONFIG['database'][$id]['database'] . ';charset=utf8', _CONFIG['database'][$id]['username'], _CONFIG['database'][$id]['password'],
                array(
                    PDO::ATTR_TIMEOUT => 1,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );

            $db = new Database();
            $db->db = new \NotORM($PDO, null, new \NotORM_Cache_Session());
            $db->expire = time();
            BasicWrapper::$database[$id] = $db;


        } catch (PDOException $e) {

            throw $e;

        }

    }

    public static function getEmailer(int $sid = 0)
    {
        return new EmailManager($sid);
    }

}