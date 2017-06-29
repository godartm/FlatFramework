<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 27/02/2017
 * Time: 15:12
 */

namespace PrivateHeberg\Flat;


abstract class Rule
{

    public $access = ['res' => false, 'redirect' => null];

    public abstract function setAccess($args, $method, $_route, $target);

    /**
     * @param bool $result Definit si l'accées a la page est autorisé
     * @param String $redirect lien de redirection si null page blanche
     */
    public function allowAccess(bool $result, String $redirect = null)
    {
        $this->access = ['res' => $result, 'redirect' => $redirect];
    }

    public function checkAccess()
    {
        return $this->access;
    }


}