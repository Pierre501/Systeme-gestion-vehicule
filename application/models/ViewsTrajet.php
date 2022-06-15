<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ViewsTrajet extends CI_Model
{
    private $idTrajet;
    private $typeTrajet;
    private $lieu;
    private $kilometrage;
    private $dateTrajet;
    private $heureTrajet;
    private $chauffeur;
    private $motif;
    private $idVehicule;
    private $numero;
    private $marque;
    private $modele;

    public function setIdTrajet($idTrajet)
    {
        $this->idTrajet = $idTrajet;
    }

    public function getIdTrajet()
    {
        return $this->idTrajet;
    }

    public function setTypeTrajet($typeTrajet)
    {
        $this->typeTrajet = $typeTrajet;
    }

    public function getTypeTrajet()
    {
        return $this->typeTrajet;
    }

    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function setKilometrage($kilometrage)
    {
        $this->kilometrage = $kilometrage;
    }

    public function getKilometrage()
    {
        return $this->kilometrage;
    }

    public function setDateTrajet($date)
    {
        $this->dateTrajet = $date;
    }

    public function getDateTrajet()
    {
        return $this->dateTrajet;
    }

    public function setHeureTrajet($heure)
    {
        $this->heureTrajet = $heure;
    }

    public function getHeureTrajet()
    {
        return $this->heureTrajet;
    }

    public function setChauffeur($chauffeur)
    {
        $this->chauffeur = $chauffeur;
    }

    public function getChauffeur()
    {
        return $this->chauffeur;
    }

    public function setMotif($motif)
    {
        $this->motif = $motif;
    }

    public function getMotif()
    {
        return $this->motif;
    }

    public function setIdVehicule($idVehicule)
    {
        $this->idVehicule = $idVehicule;
    }

    public function getIdVehicule()
    {
        return $this->idVehicule;
    }

    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    public function getNumero()
    {
        return $this->numero;
    }

    public function setMarque($marque)
    {
        $this->marque = $marque;
    }

    public function getMarque()
    {
        return $this->marque;
    }

    public function setModele($modele)
    {
        $this->modele = $modele;
    }

    public function getModele()
    {
        return $this->modele;
    }

    public function getAllViewsTrajet($numero)
    {
        $tabViewTrajet = array();
        $this->db->select('*');
        $this->db->from('vehicule');
        $this->db->join('trajet', 'vehicule.id_vehicule = trajet.vehicule');
        $this->db->where('vehicule.numero', $numero);
        $query = $this->db->get();
        foreach($query->result_array() as $rows)
        {
            $trajet = new ViewsTrajet();
            $trajet->setIdVehicule($rows['id_vehicule']);
            $trajet->setNumero($rows['numero']);
            $trajet->setMarque($rows['marque']);
            $trajet->setModele($rows['model']);
            $trajet->setIdTrajet($rows['id_trajet']);
            $trajet->setTypeTrajet($rows['type_trajet']);
            $trajet->setLieu($rows['lieu']);
            $trajet->setKilometrage($rows['kilometrage']);
            $trajet->setDateTrajet($rows['date_trajet']);
            $trajet->setHeureTrajet($rows['heure_trajet']);
            $trajet->setChauffeur($rows['chauffeur']);
            $trajet->setMotif($rows['motif']);
            $tabViewTrajet[] = $trajet;
        }
        return $tabViewTrajet;
    }
}
?>












