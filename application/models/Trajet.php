<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Trajet extends CI_Model
{
    private $idTrajet;
    private $typeTrajet;
    private $lieu;
    private $kilometrage;
    private $dateTrajet;
    private $heureTrajet;
    private $vehicule;
    private $chauffeur;
    private $motif;
    private $idVehicule;
    private $numero;
    private $marque;
    private $modele;
    private $idType;
    private $type;

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

    public function setVehicule($vehicule)
    {
        $this->vehicule = $vehicule;
    }

    public function getVehicule()
    {
        return $this->vehicule;
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

    public function insertionTrajet($trajet)
    {
        $this->db->set('type_trajet', $trajet->getTypeTrajet());
        $this->db->set('lieu', $trajet->getLieu());
        $this->db->set('kilometrage', $trajet->getKilometrage());
        $this->db->set('date_trajet', $trajet->getDateTrajet());
        $this->db->set('heure_trajet', $trajet->getHeureTrajet());
        $this->db->set('vehicule', $trajet->getVehicule());
        $this->db->set('chauffeur', $trajet->getChauffeur());
        $this->db->set('motif', $trajet->getMotif());
        $this->db->insert('trajet');
    }

    public function getSimpleTrajet($numero)
    {
        $this->load->model('ViewsVehicule');
        $vehicule = $this->ViewsVehicule->getSimpleVehicule($numero);
        $sql = "select * from trajet where id_trajet = (select max(id_trajet) from trajet where vehicule=%d)";
        $sql = sprintf($sql, $vehicule->getIdVehicule());
        $query = $this->db->query($sql);
        $rows = $query->row_array();
        $trajet = new Trajet();
        $trajet->setIdTrajet($rows['id_trajet']);
        $trajet->setTypeTrajet($rows['type_trajet']);
        $trajet->setLieu($rows['lieu']);
        $trajet->setKilometrage($rows['kilometrage']);
        $trajet->setDateTrajet($rows['date_trajet']);
        $trajet->setHeureTrajet($rows['heure_trajet']);
        $trajet->setVehicule($rows['vehicule']);
        $trajet->setChauffeur($rows['chauffeur']);
        $trajet->setMotif($rows['motif']);
        return $trajet;
    }

    public function getAllTrajet()
    {
        $tabTrajet = array();
        $query = $this->db->get('trajet');
        foreach($query->result_array() as $rows)
        {
            $trajet = new Trajet();
            $trajet->setIdTrajet($rows['id_trajet']);
            $trajet->setTypeTrajet($rows['type_trajet']);
            $trajet->setLieu($rows['lieu']);
            $trajet->setKilometrage($rows['kilometrage']);
            $trajet->setDateTrajet($rows['date_trajet']);
            $trajet->setHeureTrajet($rows['heure_trajet']);
            $trajet->setVehicule($rows['vehicule']);
            $trajet->setChauffeur($rows['chauffeur']);
            $trajet->setMotif($rows['motif']);
            $tabTrajet[] = $trajet;
        }
        return $tabTrajet;
    }

    public function verifierVehicule($numero)
    {
        $condition = false;
        $this->load->model('ViewsVehicule');
        $vehicule = $this->ViewsVehicule->getSimpleVehicule($numero);
        $tabTrajet = $this->getAllTrajet();
        foreach($tabTrajet as $trajet)
        {
            if($trajet->getVehicule() == $vehicule->getIdVehicule())
            {
                $condition = true;
            }
        }
        return $condition;
    }

    public function getAllTrajetEntreDeuxDate($dateDebut, $dateFin, $numero)
    {
        $tabTrajet = array();
        $this->load->model('ViewsVehicule');
        $vehicule = $this->ViewsVehicule->getSimpleVehicule($numero);
        $sql = "select * from trajet where vehicule = %d and date_trajet between %s and %s";
        $sql = sprintf($sql, $vehicule->getIdVehicule(), $this->db->escape($dateDebut), $this->db->escape($dateFin));
        $query = $this->db->query($sql);
        foreach($query->result_array() as $rows)
        {
            $trajet = new Trajet();
            $trajet->setIdTrajet($rows['id_trajet']);
            $trajet->setTypeTrajet($rows['type_trajet']);
            $trajet->setLieu($rows['lieu']);
            $trajet->setKilometrage($rows['kilometrage']);
            $trajet->setDateTrajet($rows['date_trajet']);
            $trajet->setHeureTrajet($rows['heure_trajet']);
            $trajet->setVehicule($rows['vehicule']);
            $trajet->setChauffeur($rows['chauffeur']);
            $trajet->setMotif($rows['motif']);
            $tabTrajet[] = $trajet;
        }
        return $tabTrajet;
    }

    public function getKilometrageEffectue($dateDebut, $dateFin, $numero)
    {
        $tabTrajet = $this->getAllTrajetEntreDeuxDate($dateDebut, $dateFin, $numero);
        $trajetEnd = end($tabTrajet);
        $kilometrage = $trajetEnd->getKilometrage() - $tabTrajet[0]->getKilometrage();
        return $kilometrage;
    }
}
?>








