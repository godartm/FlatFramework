<?php

namespace PrivateHeberg\Flat;


use Exception;
use PHPMailer;

class EmailManager
{

    public $server_id;

    public function __construct(int $sid = 0)
    {
        $this->server_id = $sid;
    }

    public function sendMail($string, $destinataire, $subject)
    {

        $local_config = _CONFIG['module']['PHPMailer'][$this->server_id];

        try {
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'starttls';

            $mail->Host = $local_config['smtp_server'];
            $mail->Port = $local_config['smtp_port'];
            $mail->Username = $local_config['smtp_username'];

            $mail->Password = $local_config['smtp_password'];
            $mail->From = $local_config['smtp_username']; //adresse d’envoi correspondant au login entrée précédement
            $mail->FromName = $local_config['smtp_name']; // nom qui sera affiché
            $mail->Subject = $subject; // sujet
            $mail->AltBody = ""; //Body au format texte
            $mail->CharSet = 'UTF-8';
            $mail->WordWrap = 50; // nombre de caractere pour le retour a la ligne automatique
            $template_mail = $string;


            $mail->MsgHTML($template_mail);
            $mail->AddReplyTo($local_config['smtp_username'], $local_config['smtp_name']);
            $mail->AddAddress($destinataire);
            $mail->smtpConnect(array(
                "ssl" => array(
                    "verify_peer"       => false,
                    "verify_peer_name"  => false,
                    "allow_self_signed" => true
                )
            ));
            $mail->IsHTML(true); // envoyer au format html, passer a false si en mode texte

            $mail->Send();


        } catch (Exception $ex) {
            throw $ex;

        }
    }
}

