<?php
/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 08/12/2016
 * Time: 23:26
 */

namespace PrivateHeberg\Flat;


class Cryptographie
{
    /**
     * Permet de rendre le mot de passe illisible
     *
     * @param string $password Mot de passe crypté
     *
     * @return string $password Retourne le mot de passe crypté
     */
    public function hashPasswordSalt($password)
    {
        $salt = BasicWrapper::getCryptographie()->stringGenerator('9');

        return sha1($password . $salt) . ':' . $salt;
    }

    /**
     * Permet de créer une chaine de caractères aléatoire pour le token
     *
     * @param int $size Taille de la chaine de caractères
     *
     * @return string Retourne une chaine de caractères aléatoire
     */
    public function stringGenerator($size = 64)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $size);
    }

    /**
     * Permet de vérifier le mot de passe salé
     *
     * @param string $token Mot de passe salé
     * @param string $password Mot de passe
     *
     * @return boolean True ou False en fonction de la validité du mot de passe
     */
    public function checkPasswordSalt($token, $password)
    {
        $separe = explode(':', $token);
        $passwd = 123;
        if ((isset($separe[0])) and (isset($separe[1]))) {
            $passwd = sha1($password . $separe[1]);
        }
        if ($passwd == $separe[0]) {
            return true;
        }

        return false;
    }

    /**
     * Créer un GetCSRF Token
     * @return string
     */
    public function csrfGet()
    {
        $token = self::stringGenerator(16);
        $_SESSION['csrf'][] = $token;

        return $token;
    }

    /**
     * Check if CSRF is valid
     * @param $string
     * @return bool
     */
    public function csrfCheck($string)
    {
        if (isset($_SESSION['csrf'])) {
            if (is_array($_SESSION['csrf'])) {


                foreach ($_SESSION['csrf'] as $token) {
                    if ($token == $string) {
                        return true;
                    }
                }
            }
        }

        return false;
    }
}