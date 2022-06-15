<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Administrateur extends CI_Model
{
    private $id_administrateur;
    private $username;
    private $mdp;

    public function setIdAdministrateur($id)
    {
        $this->id_administrateur = $id;
    }

    public function getIdAdministrateur()
    {
        return $this->id_administrateur;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    public function getMdp()
    {
        return $this->mdp;
    }

    public function verifierAdministrateur($username, $mdp)
    {
        $condition = false;
        $sql = "select count(*) as lignee from administrateur where username_admin = %s and mdp_admin = %s";
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
    
}
?>