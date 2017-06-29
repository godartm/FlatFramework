<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 08/04/2017
 * Time: 17:35
 */

namespace Privateheberg\Flat\Socket;


use PrivateHeberg\Flat\Mime\MimeTypes;
use PrivateHeberg\Flat\SessionManager;

class Environement
{

    private $session_id;
    private $sqllite;

    public function __construct(WebSocketUser $user, BasePacket $packet)
    {
        $this->rewriteSERVER($packet, $user);
        $this->rewriteGET($packet, $user);
        $this->rewritePOST($packet, $user);

        $this->rewriteFILES($packet, $user);
        $this->rewriteCOOKIE($packet, $user);
        $this->rewirteSESSION($packet, $user);


        $_REQUEST = [];
        $_ENV = [];


    }

    private function rewriteSERVER(BasePacket $packet, WebSocketUser $user)
    {
        $NEW_SERVER['USER'] = $_SERVER['HOME'];
        $NEW_SERVER['HOME'] = $_SERVER['HOME'];

        $NEW_SERVER['REDIRECT_STATUS'] = "200";
        $NEW_SERVER['SERVER_NAME'] = parse_url($user->headers['origin'])['host'];
        $NEW_SERVER['SERVER_PORT'] = "";
        $NEW_SERVER['SERVER_ADDR'] = '0.0.0.0';
        $NEW_SERVER['REMOTE_PORT'] = "";

        if (!empty($user->headers['cf-connecting-ip'])) {
            $NEW_SERVER['REMOTE_ADDR'] = $user->headers['cf-connecting-ip'];
        } elseif (!empty($user->headers['x-forwarded-for'])) {
            $NEW_SERVER['REMOTE_ADDR'] = $user->headers['x-forwarded-for'];
        } else {
            $NEW_SERVER['REMOTE_ADDR'] = null;
        }


        $NEW_SERVER['SERVER_SOFTWARE'] = "flat WS";
        $NEW_SERVER['GATEWAY_INTERFACE'] = "Socket";
        $ip = null;
        if (!empty($user->headers['cf-visitor'])) {
            $ip = json_decode($user->headers['cf-visitor'], true);
        }
        if (!empty($ip['scheme'])) {
            $NEW_SERVER['HTTPS'] = $ip['scheme'];
        } elseif (!empty($user->headers['x-forwarded-proto'])) {
            $NEW_SERVER['HTTPS'] = $user->headers['x-forwarded-proto'];
        } else {
            $NEW_SERVER['HTTPS'] = "http";

        }

        if ($NEW_SERVER['HTTPS'] == 'https') {
            $NEW_SERVER['HTTPS'] = 'on';
            $NEW_SERVER['SERVER_PORT'] = 443;
        } else {
            $NEW_SERVER['HTTPS'] = 'off';
            $NEW_SERVER['SERVER_PORT'] = 80;
        }


        $NEW_SERVER['SERVER_PROTOCOL'] = "HTTP/1.1";
        $NEW_SERVER['DOCUMENT_ROOT'] = __DIR__ . "/../../../../public";
        $NEW_SERVER['DOCUMENT_URI'] = "/index.php";
        $NEW_SERVER['REQUEST_URI'] = $packet->path;
        $NEW_SERVER['SCRIPT_NAME'] = "/index.php";
        $NEW_SERVER['CONTENT_LENGTH'] = "";
        $NEW_SERVER['CONTENT_TYPE'] = "";
        $NEW_SERVER['QUERY_STRING'] = "";
        $NEW_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/../../../../public/index.php';
        $NEW_SERVER['PATH_INFO'] = "";
        $NEW_SERVER['FCGI_ROLE'] = "RESPONDER";
        $NEW_SERVER['PHP_SELF'] = "/index.php";
        $NEW_SERVER['REQUEST_TIME_FLOAT'] = floatval(time() . '.0000');
        $NEW_SERVER['REQUEST_TIME'] = time();


        foreach ($user->headers as $headerName => $header) {
            $name = 'HTTP_' . strtoupper($headerName);
            $NEW_SERVER[$name] = $header;
        }
        $_SERVER = null;
        $_SERVER = $NEW_SERVER;
    }

    private function rewriteGET(BasePacket $packet, WebSocketUser $user)
    {
        foreach ($packet->get as $value) {
            $_GET[$value['name']] = $value['value'];
        }
    }

    private function rewritePOST(BasePacket $packet, WebSocketUser $user)
    {
        foreach ($packet->post as $key => $value) {

            $name = $value['name'];
            if (!isset($_POST[$name])) {
                $_POST[$name] = $value['value'];
            } else {
                if (!is_array($_POST[$value['name']])) {
                    $first_data = $_POST[$value['name']];
                    $_POST[$name] = [];
                    $_POST[$name][] = $first_data;
                    $_POST[$name][] = $value['value'];
                } else {
                    $_POST[$name][] = $value['value'];
                }


            }

        }
    }

    private function rewriteFILES(BasePacket $packet, WebSocketUser $user)
    {
        foreach ($packet->file as $value) {

            try {


                $img = $value['data'];
                $pre_mime = str_replace(';', '', $img);
                if (!empty($pre_mime[0])) {


                    $mime = str_replace('data:', '', $pre_mime[0]);
                    if (!empty($mime[1])) {
                        $mime = $mime[1];
                        $img_data = str_replace(',', '', $img)[1];


                        $mimes = new MimeTypes();
                        $ext = $mimes->getExtension($mime);
                        $img_data = str_replace(' ', '+', $img_data);
                        $data = base64_decode($img_data);
                        $file = __DIR__ . '/../../../../app/tmp/upload/' . uniqid() . '.' . $ext;
                        $success = file_put_contents($file, $data);
                        print $success ? $file : 'Unable to save the file.';


                        $_FILES[$value['name']] = $file;
                    }
                }
            } catch (\Exception $e) {

            }
        }
    }

    private function rewriteCOOKIE(BasePacket $packet, WebSocketUser $user)
    {
        $cook = explode(';', $user->headers['cookie']);

        $_COOKIE = null;
        foreach ($cook as $cc) {
            $oncook = explode('=', $cc);
            $name = trim($oncook[0]);
            $value = trim($oncook[1]);
            $_COOKIE[$name] = $value;
            if ($name == 'PHPSESSID') {
                $this->session_id = $value;
            }
        }
    }

    public function rewirteSESSION(BasePacket $packet, WebSocketUser $user)
    {

        $this->session_id = $packet->sessionID;
        $sess = new SessionManager($packet->sessionID);
        $sess->restore();


    }

    public function unset()
    {
        $sess = new SessionManager($this->session_id);
        $sess->flush();

        $_SERVER = null;
        $_GET = null;
        $_POST = null;
        $_FILES = null;
        $_COOKIE = null;
        $_REQUEST = null;
        $_ENV = null;
    }

}