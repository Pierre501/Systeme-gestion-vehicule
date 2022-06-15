<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Chauffeur extends CI_Model
{

    private $idChauffeur;
    private $nomChauffeur;
    private $username;
    private $mdp;

    public function setIdChauffeur($idChauffeur)
    {
        $this->idChauffeur = $idChauffeur;
    }

    public function getIdChauffeur()
    {
        return $this->idChauffeur;
    }

    public function setNomChauffeur($nomChauffeur)
    {
        $this->nomChauffeur = $nomChauffeur;
    }

    public function getNomChauffeur()
    {
        return $this->nomChauffeur;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setMotDePasse($mdp)
    {
        $this->mdp = $mdp;
    }

    public function getMotDePasse()
    {
        return $this->mdp;
    }

    public function verifierLogin($username, $mdp)
    {
        $condition = false;
        $sql = "select count(*) as lignee from chauffeur where username = %s and mot_de_passe = %s";
        $sql = sprintf($sql, $this->db->escape($username), $this->db->escape(sha1($mdp)));
        $query = $this->db->query($sql);
        $rows = $query->row_array();
        $ligne = $rows['lignee'];
        if($ligne == 1)
        {
            $condition = true;
        }
        return $condition;
    }

    public function getSimpleChauffeur($username, $mdp)
    {
        $this->db->select('*');
        $this->db->from('chauffeur');
        $this->db->where('username', $username);
        $this->db->where('mot_de_passe', sha1($mdp));
        $query = $this->db->get();
        $rows = $query->row_array();
        $chauffeur = new Chauffeur();
        $chauffeur->setIdChauffeur($rows['id_chauffeur']);
        $chauffeur->setNomChauffeur($rows['nom_chauffeur']);
        $chauffeur->setUsername($rows['username']);
        $chauffeur->setMotDePasse($rows['mot_de_passe']);
        return $chauffeur;
    }
}
?>