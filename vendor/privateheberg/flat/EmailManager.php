<?php

namespace PrivateHeberg\Flat;


use Exception;
use PHPMailer;
use PrivateHeberg\Flat\Event\Event;

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

    /**
     * Permet d'envoyé un email par template
     * Resuire l'implementation de Event onSendEmailByTemplate
     *
     * @param $name string Nom de la template
     * @param $args array Args qui remplis la template
     * @param $email_adresse array Email adresse du mec
     */
    public function sendMailByTemplate($name, $args, $email_adresse)
    {
        $html_email = Event::call('onSendEmailByTemplate', ['template_name' => $name, 'args' => $args]);
        if (isset($html_email['html']) && isset($html_email['titre']))
            $this->sendMail($html_email['html'], $email_adresse, $html_email['titre']);
    }
}

