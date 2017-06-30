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

        $utilisateurs = new Utilisateur(0);

        $data = $utilisateurs->getAll();

       foreach ($data as $d) {
          echo $d->name;
          break;
       }

    }
}