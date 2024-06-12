<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\ClientExceptionHandler;

class EmailRecu
{
    private $id_email_recu;
    private $profile_destinataire;
    private $profile_source;
    private $sujet;
    private $text;
    private $etat;
    private $isSpam;

    public function __construct($id_email_recu, $profile_destinataire, $profile_source, $sujet, $text, $etat, $isSpam)
    {
        $this->id_email_recu = $id_email_recu;
        $this->profile_destinataire = $profile_destinataire;
        $this->profile_source = $profile_source;
        $this->sujet = $sujet;
        $this->text = $text;
        $this->etat = $etat;
        $this->isSpam = $isSpam; 
    }

///Encapsulation
    public function getIdEmailRecu()
    {
        return $this->id_email_recu;
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

    public function getText()
    {
        return $this->text;
    }
    public function setText($value)
    {
        $this->text = $value;
    }

    public function getEtat()
    {
        return $this->etat;
    }
    public function setEtat($value)
    {
        $this->etat = $value;
    }

    public function getIsSpam()
    {
        return $this->isSpam;
    }
    public function setIsSpam($value)
    {
        $this->isSpam = $value;
    }

    //Recuperer toutes les emails recus
    public static function getBoiteReception($profil)
    {
        $encryptionKey = "00112233445566778899AABBCCDDEEFF";
        $results = DB::select('SELECT * FROM email_recu WHERE profile_destinataire = '.$profil->getIdProfile().' AND isSpam = 0 ORDER BY id_email_recu DESC');
        $datas = array();
        $i = 0;
        foreach ($results as $row) {
            $sujetDecrypted = Util::decryptAES($row->sujet, $encryptionKey);
            $textDecrypted = Util::decryptAES($row->text, $encryptionKey);    

            $datas[$i] = new EmailRecu($row->id_email_recu, Profile::findById($row->profile_destinataire), Profile::findById($row->profile_source), $sujetDecrypted, $textDecrypted, $row->etat, $row->isspam);
            $i++;
        }

        return $datas;
    }

    //Recuperer toutes les emails recus spam
    public static function getEmailSpam($profil)
    {
        $encryptionKey = "00112233445566778899AABBCCDDEEFF";

        $results = DB::select('SELECT * FROM email_recu WHERE profile_destinataire = '.$profil->getIdProfile().' AND isspam = 1 ORDER BY id_email_recu DESC');
        $datas = array();
        $i = 0;
        foreach ($results as $row) {
            $sujetDecrypted = Util::decryptAES($row->sujet, $encryptionKey);
            $textDecrypted = Util::decryptAES($row->text, $encryptionKey);    

            $datas[$i] = new EmailRecu($row->id_email_recu, Profile::findById($row->profile_destinataire), Profile::findById($row->profile_source), $sujetDecrypted, $textDecrypted, $row->etat, $row->isspam);
            $i++;
        }
 
        return $datas;
    }

    //Recuperer l'email recu correspondant au parametre id
    public static function findById($id)
    {
        $encryptionKey = "00112233445566778899AABBCCDDEEFF";

        $results = DB::table('email_recu')->where('id_email_recu', $id)->first();

        $sujetDecrypted = Util::decryptAES($results->sujet, $encryptionKey);
        $textDecrypted = Util::decryptAES($results->text, $encryptionKey);
    
        return new EmailRecu($results->id_email_recu, Profile::findById($results->profile_destinataire), Profile::findById($results->profile_source),  $sujetDecrypted, $textDecrypted, $results->etat, $results->isspam);
    }  

    //Avoir l'etat de l'email recu
    public function getEtatLettre() {
        if($this->etat == 1) {
            return "Non lu";
        }

        return "lu";
    }


    //Lire un email recu
    public function lireEmail()
    {
        DB::table('email_recu')
        ->where('id_email_recu', $this->id_email_recu)
        ->update([
            'etat' => 2
        ]);
    }

    //Signaler q'un email est spam
    public function setEmailSpam()
    {
        /*DB::table('email_recu')
        ->where('id_email_recu', $this->id_email_recu)
        ->update([
              'isspam' => 1
        ]);*/
        $req = "INSERT INTO new_donnee VALUES (DEFAULT, '%s', 1)";
        $req = sprintf($req, $this->sujet);
        DB::insert($req);
    }

    //Signaler q'un email n'est pas spam
    public function setEmailNoSpam()
    {
        /*DB::table('email_recu')
        ->where('id_email_recu', $this->id_email_recu)
        ->update([
            'isspam' => 0
        ]);*/
        $req = "INSERT INTO new_donnee VALUES (DEFAULT, '%s', 0)";
        $req = sprintf($req, $this->sujet);
        DB::insert($req);
    }
 
     //Supprimer un email recu par son id
     public function delete()
     {
        DB::table('email_recu')
        ->where('id__email_recu', $this->id_email_recu)
        ->delete();
     }

     //Sauvegarder un email recu dans la base
    public function create()
    {
        try {
            $encryptionKey = "00112233445566778899AABBCCDDEEFF";

            $sujetCrypte = Util::encryptAES($this->sujet, $encryptionKey);
            $textCrypte = Util::encryptAES($this->text, $encryptionKey);

            $req = "INSERT INTO email_recu VALUES (DEFAULT, %d, %d, '%s', '%s', 1, %d)";
            $req = sprintf($req, $this->getProfileDestinataire()->getIdProfile(), $this->getProfileSource()->getIdProfile(),  $sujetCrypte, $textCrypte, $this->isSpam);
            DB::insert($req);
        } catch (\Exception $e) {
            echo $e->getMessage();
            throw new \Exception("Erreur lors d'insertion d'un email recu : " . $e->getMessage());
        }
    }

    //Compter les nouveaux donnees a mettre jour
    public static function getNbNewDatas()
    {
        $results = DB::select('SELECT * FROM new_donnee');
        $datas = array();
        $i = 0;
        foreach ($results as $row) {
            $datas[$i] = $row->id_new_donnee;
            $i++;
        }
 
        return count($datas);
    }

}