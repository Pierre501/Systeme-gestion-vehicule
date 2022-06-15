<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ViewsEcheance extends CI_Model
{
    private $idEcheance;
    private $typeEcheance;
    private $idDetailsEcheance;
    private $idVehicule;
    private $numeroVehicule;
    private $dateEcheance;
    private $joursRestantEcheance;
    private $couleur;

    public function setIdEcheance($idEcheance)
    {
        $this->idEcheance = $idEcheance;
    }

    public function getIdEcheance()
    {
        return $this->idEcheance;
    }

    public function setTypeEcheance($typeEcheance)
    {
        $this->typeEcheance = $typeEcheance;
    }

    public function getTypeEcheance()
    {
        return $this->typeEcheance;
    }

    public function setIdDetaisEcheance($idDetailsEcheance)
    {
        $this->idDetailsEcheance = $idDetailsEcheance;
    }

    public function getIdDetailsEcheance()
    {
        return $this->idDetailsEcheance;
    }

    public function setIdVehicule($idVehicule)
    {
        $this->idVehicule = $idVehicule;
    }

    public function getIdVehicule()
    {
        return $this->idVehicule;
    }

    public function setNumeroVehicule($idVehicule)
    {
        $this->numeroVehicule = $idVehicule;
    }

    public function getNumeroVehicule()
    {
        return $this->numeroVehicule;
    }

    public function setDateEcheance($dateEcheance)
    {
        $this->dateEcheance = $dateEcheance;
    }

    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }

    public function setJourRestantEcheance($joursRestantEcheance)
    {
        $this->joursRestantEcheance = $joursRestantEcheance;
    }

    public function getJoursRestantEcheance()
    {
        return $this->joursRestantEcheance;
    }

    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    public function getCouleur()
    {
        return $this->couleur;
    }

    public function getAllEcheance()
    {
        $tabEcheance = array();
        $query = $this->db->get('echeance');
        foreach($query->result_array() as $rows)
        {
            $view = new ViewsEcheance();
            $view->setIdEcheance($rows['id_echeance']);
            $view->setTypeEcheance($rows['type_echeance']);
            $tabEcheance[] = $view;
        }
        return $tabEcheance;
    }

    public function getAllViewEcheanceSansFiltre()
    {
        $tabViewEcheance = array();
        $this->db->select('*');
        $this->db->from('echeance');
        $this->db->join('details_echeance', 'echeance.id_echeance = details_echeance.id_echeance');
        $this->db->join('vehicule', 'details_echeance.id_vehicule = vehicule.id_vehicule');
        $query = $this->db->get();
        foreach($query->result_array() as $rows)
        {
            $view = new ViewsEcheance();
            $view->setIdEcheance($rows['id_echeance']);
            $view->setTypeEcheance($rows['type_echeance']);
            $view->setIdDetaisEcheance($rows['id_details_echeance']);
            $view->setIdVehicule($rows['id_vehicule']);
            $view->setNumeroVehicule($rows['numero']);
            $view->setDateEcheance($rows['date_fin']);
            $tabViewEcheance[] = $view;
        }
        return $tabViewEcheance;
    }

    public function getAllViewEcheanceAvecFiltre($numero)
    {
        $tabViewEcheance = array();
        $this->db->select('*');
        $this->db->from('echeance');
        $this->db->join('details_echeance', 'echeance.id_echeance = details_echeance.id_echeance');
        $this->db->join('vehicule', 'details_echeance.id_vehicule = vehicule.id_vehicule');
        $this->db->where('vehicule.numero', $numero);
        $query = $this->db->get();
        foreach($query->result_array() as $rows)
        {
            $view = new ViewsEcheance();
            $view->setIdEcheance($rows['id_echeance']);
            $view->setTypeEcheance($rows['type_echeance']);
            $view->setIdDetaisEcheance($rows['id_details_echeance']);
            $view->setIdVehicule($rows['id_vehicule']);
            $view->setNumeroVehicule($rows['numero']);
            $view->setDateEcheance($rows['date_fin']);
            $view->setJourRestantEcheance(intval($this->calculJourRestantEcheance($rows['date_fin'])));
            $tabViewEcheance[] = $view;
        }
        return $tabViewEcheance;
    }

    public function getAllVehiculePapierNormal()
    {
        $data = array();
        $this->load->model('ViewsVehicule');
        $tabVehicule = $this->ViewsVehicule->getAllVehicule();
        foreach($tabVehicule as $vehicule)
        {
            $tabEcheance = $this->getAllViewEcheanceAvecFiltre($vehicule->getNumero());
            $compteur = 0;
            foreach($tabEcheance as $echeance)
            {
                if($echeance->getJoursRestantEcheance() >= 1)
                {
                    $compteur++;
                }
            }
            if($compteur == 2)
            {
                $voiture = $tabEcheance[0];
                $data[] = $this->ViewsVehicule->getSimpleVehicule($voiture->getNumeroVehicule());
            }
        }
        return $data;
    }

    public function getAllVehiculePapierClean()
    {
        $data = array();
        $this->load->model('ViewsVehicule');
        $tabVehicule = $this->ViewsVehicule->getAllVehiculeNotInTrajet();
        foreach($tabVehicule as $vehicule)
        {
            $tabEcheance = $this->getAllViewEcheanceAvecFiltre($vehicule->getNumero());
            $compteur = 0;
            foreach($tabEcheance as $echeance)
            {
                if($echeance->getJoursRestantEcheance() >= 1)
                {
                    $compteur++;
                }
            }
            if($compteur == 2)
            {
                $voiture = $tabEcheance[0];
                $data[] = $this->ViewsVehicule->getSimpleVehicule($voiture->getNumeroVehicule());
            }
        }
        return $data;
    }

    public function getDateMaxTrajet($idVehicule)
    {
        $sql = "select max(date_trajet) as date_trajet from trajet where vehicule=%d and type_trajet = 'Arrivé' or type_trajet='ArrivÚ'";
        $sql = sprintf($sql, $idVehicule);
        $query = $this->db->query($sql);
        $rows = $query->row_array();
        $date = $rows['date_trajet'];
        return $date;
    }

    public function getHeureMaxTrajet($idVehicule)
    {
        $sql = "select max(heure_trajet) as heure_trajet from trajet where vehicule=%d and type_trajet = 'Arrivé' or type_trajet='ArrivÚ'";
        $sql = sprintf($sql, $idVehicule);
        $query = $this->db->query($sql);
        $rows = $query->row_array();
        $date = $rows['heure_trajet'];
        return $date;
    }

    public function verificationdateEtHeure($dateArrive, $heureArrive, $numero)
    {
        $this->load->model("ViewsVehicule");
        $condition = false;
        $vehicule = $this->ViewsVehicule->getSimpleVehicule($numero);
        $dateDepart = $this->getDateMaxTrajet($vehicule->getIdVehicule());
        $heureDepart = $this->getHeureMaxTrajet($vehicule->getIdVehicule());
        if($dateDepart <= $dateArrive && $heureDepart < $heureArrive)
        {
            $condition = true;
        }
        return $condition;
    }

    public function getAllTrajet($idVehicule)
    {
        $this->load->model("Trajet");
        $tabTrajet = array();
        $date = $this->getDateMaxTrajet($idVehicule);
        $heure = $this->getHeureMaxTrajet($idVehicule);
        $sql = "select * from trajet where vehicule=%d and heure_trajet >= %s and date_trajet between %s and current_date";
        $sql = sprintf($sql, $idVehicule, $this->db->escape($heure), $this->db->escape($date));
        $query = $this->db->query($sql);
        foreach($query->result_array() as $rows)
        {
            $trajet = new trajet();
            $trajet->setidTrajet($rows['id_trajet']);
            $trajet->setTypeTrajet($rows['type_trajet']);
            $trajet->setLieu($rows['lieu']);
            $trajet->setKilometrage($rows['date_trajet']);
            $trajet->setHeureTrajet($rows['heure_trajet']);
            $trajet->setVehicule($rows['vehicule']);
            $trajet->setChauffeur($rows['chauffeur']);
            $trajet->setMotif($rows['motif']);
            $tabTrajet[] = $trajet;
        }
        return $tabTrajet;
    }

    public function compterTypeTrajetArrive($idVehicule)
    {
        $compteur = 0;
        $tabTrajet = $this->getAllTrajet($idVehicule);
        foreach($tabTrajet as $trajet)
        {
            if($trajet->getTypeTrajet() == "Arrivé" || $trajet->getTypeTrajet() == "ArrivÚ")
            {
                $compteur++;
            }
        }
        return $compteur;
    }

    public function getAllVehiculeDisponible()
    {
        $data = array();
        $this->load->model("ViewsVehicule");
        $tabVehicule = $this->ViewsVehicule->getAllVehicule();
        foreach($tabVehicule as $vehicule)
        {
            $compteurArrive = $this->compterTypeTrajetArrive($vehicule->getIdVehicule());
            if($compteurArrive >= 1)
            {
                $data[] = $vehicule;
            }
        }
        return $data;
    }

    public function getAllVehiculeDisponibleFinal()
    {
        $data = array();
        $tabVehicule = $this->getAllVehiculeDisponible();
        $tabVehicule2 = $this->getAllVehiculePapierClean();
        $data = array_merge($tabVehicule, $tabVehicule2);
        return $data;
    }

    public function verificationDisponibiteVehicule($numero)
    {
        $condition = false;
        $tabVehicule = $this->getAllVehiculeDisponible();
        foreach($tabVehicule as $vehicule)
        {
            if($vehicule->getNumero() == $numero)
            {
                $condition = true;
            }
        }
        return $condition;
    }

    public function getAllViewEcheanceAvecFiltreFinal($numero)
    {
        $tabViewEcheance = $this->getAllViewEcheanceAvecFiltre($numero);
        foreach($tabViewEcheance as $viewEcheance)
        {
            if($viewEcheance->getJoursRestantEcheance() > 15 && $viewEcheance->getJoursRestantEcheance() <= 30)
            {
                $viewEcheance->setCouleur("Yellow");
            }
            else if($viewEcheance->getJoursRestantEcheance() >= 0 && $viewEcheance->getJoursRestantEcheance() <= 15)
            {
                $viewEcheance->setCouleur("red");
            }
        }
        return $tabViewEcheance;
    }

    public function getSimpleViewEcheanceAvecFiltre($idDetailsEcheance)
    {
        $this->db->select('*');
        $this->db->from('echeance');
        $this->db->join('details_echeance', 'echeance.id_echeance = details_echeance.id_echeance');
        $this->db->join('vehicule', 'details_echeance.id_vehicule = vehicule.id_vehicule');
        $this->db->where('details_echeance.id_details_echeance', $idDetailsEcheance);
        $query = $this->db->get();
        $rows = $query->row_array();
        $view = new ViewsEcheance();
        $view->setIdEcheance($rows['id_echeance']);
        $view->setTypeEcheance($rows['type_echeance']);
        $view->setIdDetaisEcheance($rows['id_details_echeance']);
        $view->setIdVehicule($rows['id_vehicule']);
        $view->setNumeroVehicule($rows['numero']);
        $view->setDateEcheance($rows['date_fin']);
        $view->setJourRestantEcheance($this->calculJourRestantEcheance($rows['date_fin']));
        return $view;
    }

    public function eliminerEcheance($typeEcheance)
    {
        $data = array();
        $tabEcheance = $this->getAllEcheance();
        foreach($tabEcheance as $echeance)
        {
            if($echeance->getTypeEcheance() == $typeEcheance)
            {
                continue;
            }
            $view = new ViewsEcheance();
            $view->setIdEcheance($echeance->getIdEcheance());
            $view->setTypeEcheance($echeance->getTypeEcheance());
            $data[] = $view;
        }
        return $data;
    }

    public function calculJourRestantEcheance($date)
    {
        date_default_timezone_set('Africa/Nairobi');
        $annee_encours = date('Y');
        $mois_encours = date('m');
        $jours_encours = date('d');
        $date_encours = $annee_encours."-".$mois_encours."-".$jours_encours;
        $dateDebut = date_create($date_encours);
        $dateFin = date_create($date);
        $joursRestant = date_diff($dateDebut, $dateFin);
        return $joursRestant->format("%R%a");
    }

    public function insertionEcheance($echeance)
    {
        $this->db->set('id_echeance', $echeance->getIdEcheance());
        $this->db->set('id_vehicule', $echeance->getIdVehicule());
        $this->db->set('date_fin', $echeance->getDateEcheance());
        $this->db->insert('details_echeance');
    }

    public function modificationDetailsEcheance($echeance)
    {
        $this->db->set('id_echeance', $echeance->getIdEcheance());
        $this->db->set('id_vehicule', $echeance->getIdVehicule());
        $this->db->set('date_fin', $echeance->getDateEcheance());
        $this->db->where('id_details_echeance', $echeance->getIdDetailsEcheance());
        $this->db->update('details_echeance');
    }
}
?>