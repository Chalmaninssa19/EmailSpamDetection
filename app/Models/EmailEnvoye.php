<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\ClientExceptionHandler;

class EmailEnvoye
{
    private $id_email_envoye;
    private $profile_destinataire;
    private $profile_source;
    private $sujet;
    private $text;

    public function __construct($id_email_envoye, $profile_destinataire, $profile_source, $sujet, $text)
    {
        $this->id_email_envoye = $id_email_envoye;
        $this->profile_destinataire = $profile_destinataire;
        $this->profile_source = $profile_source;
        $this->sujet = $sujet;
        $this->text = $text;
    }

///Encapsulation
    public function getIdEmailEnvoye()
    {
        return $this->id_email_envoye;
    }

    public function getProfileDestinataire()
    {
        return $this->profile_destinataire;
    }
    public function setProfileDestinataire($value)
    {
        $this->profile_destinataire = $value;
    }

    public function getProfileSource()
    {
        return $this->profile_source;
    }
    public function setProfileSource($value)
    {
        $this->profile_source = $value;
    }

    public function getSujet()
    {
        return $this->sujet;
    }
    public function setSujet($value)
    {
        $this->sujet = $value;
    }

    public function getText() {
        return $this->text;
    }
    public function setText($value) {
        $this->text = $value;
    }

    //Recuperer toutes les emails envoyes
    public static function getEmailEnvoye($profil)
    {
        $encryptionKey = "00112233445566778899AABBCCDDEEFF";

        $results = DB::select('SELECT * FROM email_envoye WHERE profile_source = '.$profil->getIdProfile().' ORDER BY id_email_envoye DESC');
        $datas = array();
        $i = 0;
        foreach ($results as $row) {
            $sujetDecrypted = Util::decryptAES($row->sujet, $encryptionKey);
            $textDecrypted = Util::decryptAES($row->text, $encryptionKey);    

            $datas[$i] = new EmailEnvoye($row->id_email_envoye, Profile::findById($row->profile_destinataire), Profile::findById($row->profile_source), $sujetDecrypted, $textDecrypted);
            $i++;
        }

        return $datas;
    }

    //Recuperer l'email envoye correspondant au parametre id
    public static function findById($id)
    {
        $encryptionKey = "00112233445566778899AABBCCDDEEFF";

        $results = DB::table('email_envoye')->where('id_email_envoye', $id)->first();

        $sujetDecrypted = Util::decryptAES($results->sujet, $encryptionKey);
        $textDecrypted = Util::decryptAES($results->text, $encryptionKey);

        return new EmailEnvoye($results->id_email_envoye, Profile::findById($results->profile_destinataire), Profile::findById($results->profile_source),  $sujetDecrypted, $textDecrypted);
    }  

    //Envoyer un email vers un destinataire
    public function sendingEmail($emailRecu = null)
    {
        try {
            $encryptionKey = "00112233445566778899AABBCCDDEEFF";

            $sujetCrypte = Util::encryptAES($this->sujet, $encryptionKey);
            $textCrypte = Util::encryptAES($this->text, $encryptionKey);
            $req = "INSERT INTO email_envoye VALUES (DEFAULT, %d, %d, '%s', '%s')";
            $req = sprintf($req, $this->getProfileDestinataire()->getIdProfile(), $this->getProfileSource()->getIdProfile(), $sujetCrypte, $textCrypte);
            echo $req;
            DB::insert($req);
            $emailRecu->create();
        } catch (\Exception $e) {
            echo $e->getMessage();
            throw new \Exception("Erreur lors de l'envoie de message : " . $e->getMessage());
        }
    }

    //Par intelligence artificielle est ce que l'email est spam
    public static function isEmailSpam($email) {
        $output=null;
        $retval=null;
        $command = 'python /home/chalman/Documents/cours/tsinjo/analyse\ de\ donnees/tp/email/python/predire.py "'.$email.'"';
        #echo $command;
      	exec($command, $output, $retval);
        
        return $output[0];
    }

     //Mettre a jour le modele
     public static function updateModele() {
        $output=null;
        $retval=null;
        $command = 'python /home/chalman/Documents/cours/tsinjo/analyse\ de\ donnees/tp/email/python/train.py';
      	exec($command, $output, $retval);
        
        return $output[0];
    }
}