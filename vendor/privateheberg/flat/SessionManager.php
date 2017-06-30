<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 12/04/2017
 * Time: 15:12
 */

namespace PrivateHeberg\Flat;


use PDO;

/**
 * Wrapper entre les session natives et les sessions mamnagé par le framework
 * Class SessionManager
 * @package vendor\privateheberg\flat
 */
class SessionManager
{
    public  $session_id;
    private $sqllite;

    /**
     * Créer une instance de session Managezr
     * SessionManager constructor.
     *
     * @param string $session_id ID de session
     */
    public function __construct($session_id)
    {
        $this->session_id = $session_id;
        if ($this->session_id != null) {


            try {


                $this->sqllite = new PDO('sqlite:' . __DIR__ . '/../../../app/tmp/session.sqllite.db');
                $this->sqllite->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $this->sqllite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
                $notORM = new \NotORM($this->sqllite);

                $time_to_valid = time() - 172800;
                $notORM->sessions()->where('time <= ?', $time_to_valid)->delete();
            } catch (\Exception $e) {
                print $e;
                $_SESSION = [];
            }
        } else {
            $_SESSION = [];
        }
    }


    /**
     * Restaure une session depuis le systéme de database du FW
     *
     */
    public function restore()
    {
        if ($this->session_id != null) {
            $_SESSION = [];
            try {


                $notORM = new \NotORM($this->sqllite);
                $id = $notORM->sessions()->where('session_id = ?', $this->session_id)->count('id');

                if ($id == 1) {
                    $sessions = $notORM->sessions()->where('session_id = ?', $this->session_id)->fetch();
                    $notORM->sessions()->where('session_id = ?', $this->session_id)->update(
                        [
                            'time' => time()
                        ]
                    );

                    $_SESSION = unserialize($sessions['data']);
                } else {
                    $_SESSION = [];
                }
            } catch (\Exception $e) {
                print $e;
                $_SESSION = [];
            }
        } else {
            $_SESSION = [];
        }

    }

    /**
     * Save et clear la session de l'utilisateur
     */
    public function flush()
    {
        if ($this->session_id != null) {
            try {
                $notORM = new \NotORM($this->sqllite);
                $id = $notORM->sessions()->where('session_id = ?', $this->session_id)->count('id');
                if ($id == 1) {
                    $notORM->sessions()->where('session_id = ?', $this->session_id)->update(
                        [
                            'data' => serialize($_SESSION),
                            'time' => time()
                        ]
                    );
                } elseif ($id == 0) {
                    $notORM->sessions()->insert(
                        [
                            'session_id' => $this->session_id,
                            'data'       => serialize($_SESSION),
                            'time'       => time()
                        ]
                    );
                }
            } catch (\Exception $e) {
                print $e;
                $_SESSION = [];
            }
        }
        $_SESSION = [];
    }

}