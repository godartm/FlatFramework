<?php
use DBModel\Utilisateur;
use PrivateHeberg\Flat\Controller;
use PrivateHeberg\Flat\ORM\ORM;


/**
 * Created by PhpStorm.
 * User: Marc Moreau
 * Date: 28/06/2017
 * Time: 17:46
 */
class HomeController extends Controller
{
    public function defaultAction()
    {


        $this->render('home');

    }

    public function defaultUpdate()
    {

        $this->update('#updateArea', rand(1,999999));
        $this->result();

    }
}