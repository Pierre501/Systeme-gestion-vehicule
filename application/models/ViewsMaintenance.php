<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ViewsMaintenance extends CI_Model
{

    private $idElement;
    private $element;
    private $contrainte;
    private $idMaintenace;
    private $idVehicule;
    private $dateMaintenance;
    private $kilometrageEffectue;
    private $kilometrageRestant;
    private $couleur;

    public function setIdElement($idElement)
    {
        $this->idElement = $idElement;
    }

    public function getIdElement()
    {
        return $this->idElement;
    }

    public function setElement($element)
    {
        $this->element = $element;
    }

    public function getElement()
    {
        return $this->element;
    }

    public function setContrainte($contrainte)
    {
        $this->contrainte = $contrainte;
    }

    public function getContraite()
    {
        return $this->contrainte;
    }

    public function setIdMaintenance($idMaintenace)
    {
        $this->idMaintenace = $idMaintenace;
    }

    public function getIdMaintenance()
    {
        return $this->idMaintenace;
    }

    public function setIdVehicule($idVehicule)
    {
        $this->idVehicule = $idVehicule;
    }

    public function getIdVehicule()
    {
        return $this->idVehicule;
    }

    public function setDateMaintenance($dateMaintenance)
    {
        $this->dateMaintenance = $dateMaintenance;
    }

    public function getDateMaintenance()
    {
        return $this->dateMaintenance;
    }

    public function setKilometrageEffectue($kilometrageEffectue)
    {
        $this->kilometrageEffectue = $kilometrageEffectue;
    }

    public function getKilometrageEffectue()
    {
        return $this->kilometrageEffectue;
    }

    public function setKilometrageRestant($kilometrageRestant)
    {
        $this->kilometrageRestant = $kilometrageRestant;
    }

    public function getKilometrageRestant()
    {
        return $this->kilometrageRestant;
    }

    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;
    }

    public function getCouleur()
    {
        return $this->couleur;
    }


    public function getAllElements()
    {
        $tabElement = array();
        $query = $this->db->get('elements');
        foreach($query->result_array() as $rows)
        {
            $element = new ViewsMaintenance();
            $element->setIdElement($rows['id_elements']);
            $element->setElement($rows['elements']);
            $element->setContrainte($rows['contrainte']);
            $tabElement[] = $element;
        }
        return $tabElement;
    }

    public function getSimpleElements($element)
    {
        $this->db->select('*');
        $this->db->from('elementes');
        $this->db->where('elements', $element);
        $query = $this->db->get();
        $rows = $query->row_array();
        $element = new ViewsMaintenance();
        $element->setIdElement($rows['id_elements']);
        $element->setElement($rows['elements']);
        $element->setContrainte($rows['contrainte']);
        return $element;
    }

    public function getAllMaintenanceParVehicule($numero)
    {
        $tabMaintenance = array();
        $tabElement = $this->getAllElements();
        foreach($tabElement as $element)
        {
            $maintenance = $this->getSimpleViewsMaintenance($numero, $element->getElement());
            if(!empty($maintenance))
            {
                $tabMaintenance[] = $maintenance;
            }
        }
        return $tabElement;
    }

    public function getDateEncours()
    {
        date_default_timezone_set('Africa/Nairobi');
        $annee_encours = date('Y');
        $mois_encours = date('m');
        $jours_encours = date('d');
        $date_encours = $annee_encours."-".$mois_encours."-".$jours_encours;
        return $date_encours;
    }

    public function getSimpleViewsMaintenance($numero, $typeElement)
    {
        $this->load->model('ViewsVehicule');
        $vehicule = $this->ViewsVehicule->getSimpleVehicule($numero);
        $sql = "select * from views_maintenance where id_vehicule = %d and elements = %s limit 1";
        $sql = sprintf($sql, $vehicule->getIdVehicule(), $this->db->escape($typeElement));
        $query = $this->db->query($sql);
        $rows = $query->row_array();
        $maintenance = new ViewsMaintenance();
        $maintenance->setIdElement($rows['id_elements']);
        $maintenance->setElement($rows['elements']);
        $maintenance->setContrainte($rows['contrainte']);
        $maintenance->setIdMaintenance($rows['id_maintenance']);
        $maintenance->setIdVehicule($rows['id_vehicule']);
        $maintenance->setDateMaintenance($rows['date_maintenace']);
        return $maintenance;
    }

    public function getAllMaintenanceParVoiture($numero)
    {
        $this->load->model('Trajet');
        $tabData = array();
        $tabMaintenance = $this->getAllMaintenanceParVehicule($numero);
        $date_encours = $this->getDateEncours();
        foreach($tabMaintenance as $maintenance)
        {
            $kilometrage = $this->Trajet->getKilometrageEffectue('2022-05-18', $date_encours, $numero);
            $restantKilometrage = $maintenance->getContraite() - $kilometrage;
            $couleur = "";
            if($restantKilometrage > 300 && $restantKilometrage <= 500)
            {
                $couleur = "yellow";
            }
            else if($restantKilometrage > 0 && $restantKilometrage <= 300)
            {
                $couleur = "red";
            }
            $view = new ViewsMaintenance();
            $view->setIdElement($maintenance->getIdElement());
            $view->setElement($maintenance->getElement());
            $view->setContrainte($maintenance->getIdMaintenance());
            $view->setIdVehicule($maintenance->getIdVehicule());
            $view->setDateMaintenance($maintenance->getDateMaintenance());
            $view->setKilometrageEffectue($kilometrage);
            $view->setKilometrageRestant($restantKilometrage);
            $view->setCouleur($couleur);
            $tabData[] = $view;
        }
        return $tabData;
    }

    public function insertionElements($element)
    {
        $this->db->set('id_elements', $element->getIdElement());
        $this->db->set('id_vehicule', $element->getIdVehicule());
        $this->db->set('date_maintenace', $element->getDateMaintenance());
        $this->db->insert('maintenance');
    }
}
?>





