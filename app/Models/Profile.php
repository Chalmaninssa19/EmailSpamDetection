<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Exceptions\ClientExceptionHandler;

class Profile
{
    private $id_profil;
    private $nom;
    private $prenom;
    private $mdp;
    private $mail;
    private $photo;

    public function __construct($id_profil, $nom, $prenom, $mdp, $mail, $photo)
    {
        $this->id_profil = $id_profil;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->mdp = $mdp;
        $this->mail = $mail;
        $this->photo = $photo;
    }

///Encapsulation
    public function getIdProfile()
    {
        return $this->id_profil;
    }
    public function setIdProfile($value)
    {
        $this->id_profil = $value;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }
    public function setPrenom($value)
    {
        $this->prenom = $value;
    }


    public function getNom()
    {
        return $this->nom;
    }
    public function setNom($value)
    {
        $this->nom = $value;
    }

    public function getMdp()
    {
        return $this->mdp;
    }

    public function setMdp($value)
    {
        $this->mdp = $value;
    }

    public function getMail()
    {
        return $this->mail;
    }
    public function setMail($value)
    {
        $this->mail = $value;
    }

    public function getPhoto()
    {
        return $this->photo;
    }
    public function setPhoto($value)
    {
        $this->photo = $value;
    }

    //Recuperer toutes les profils
    public static function getAll()
    {
        $results = DB::select('SELECT * FROM profil');
        $datas = array();
        $i = 0;
        foreach ($results as $row) {
            
            $datas[$i] = new Profile($row->id_profil, $row->nom, $row->prenom, $row->mdp, $row->mail, $row->photo);
            $i++;
        }

        return $datas;
    }

     //Recuperer toutes les profils qu'on peut envoyer des emails
     public static function getProfileToSend($profileConnected)
     {
         $results = DB::select('SELECT * FROM profil WHERE id_profil!='.$profileConnected->getIdProfile());
         $datas = array();
         $i = 0;
         foreach ($results as $row) {
             
             $datas[$i] = new Profile($row->id_profil, $row->nom, $row->prenom, $row->mdp, $row->mail, $row->photo);
             $i++;
         }
 
         return $datas;
     }

    public static function login($pwd, $mail)
    {
        try {
            $req = "SELECT * FROM profil WHERE mdp = '%s' AND mail = '%s'";
            $req = sprintf($req,$pwd,$mail);
            $results = DB::select($req);
            $i = 0;
            if($results) {
                foreach ($results as $row) {
                    return new Profile($row->id_profil, $row->nom, $row->prenom, $row->mdp, $row->mail, $row->photo);
                }
            }
            throw new Exception("Veuillez ressayer");

        } catch(Exception $e) {
        }
    }

    //Recuperer le profil correspondant au parametre id
    public static function findById($id)
    {
        $results = DB::table('profil')->where('id_profil', $id)->first();
    
        return new Profile($results->id_profil, $results->nom, $results->prenom, $results->mdp, $results->mail, $results->photo);
    }  
}