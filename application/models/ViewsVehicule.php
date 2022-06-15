<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ViewsVehicule extends CI_Model
{
    private $idVehicule;
    private $numero;
    private $marque;
    private $modele;
    private $idType;
    private $type;

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

    public function setIdType($idType)
    {
        $this->idType = $idType;
    }

    public function getIdType()
    {
        return $this->idType;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getAllTypeVehicule()
    {
        $tabVehicule = array();
        $query = $this->db->get('type_vehicule');
        foreach($query->result_array()  as $rows)
        {
            $view = new ViewsVehicule();
            $view->setIdType($rows['id_type_vehicule']);
            $view->setType($rows['type_vehicule']);
            $tabVehicule[] = $view;
        }
        return $tabVehicule;
    }

    public function getAllVehicule()
    {
        $tabVehicule = array();
        $query = $this->db->get('vehicule');
        foreach($query->result_array()  as $rows)
        {
            $view = new ViewsVehicule();
            $view->setIdVehicule($rows['id_vehicule']);
            $view->setNumero($rows['numero']);
            $view->setMarque($rows['marque']);
            $view->setModele($rows['model']);
            $tabVehicule[] = $view;
        }
        return $tabVehicule;
    }

    public function getAllVehiculeNotInTrajet()
    {
        $tabData = $this->getAllVehicule();
        $tabVehicule = array();
        $this->load->model('Trajet');
        foreach($tabData as $data)
        {
            $condition = $this->Trajet->verifierVehicule($data->getNumero());
            if($condition == false)
            {
                $tabVehicule[] = $data;
            }
        }
        return $tabVehicule;
    }

    public function getSimpleVehicule($numero)
    {
        $this->db->select('*');
        $this->db->from('vehicule');
        $this->db->where('numero', $numero);
        $query = $this->db->get();
        $rows = $query->row_array();
        $view = new ViewsVehicule();
        $view->setIdVehicule($rows['id_vehicule']);
        $view->setNumero($rows['numero']);
        $view->setMarque($rows['marque']);
        $view->setModele($rows['model']);
        return $view;
    }

    public function getSimpleViewvehicule($numero)
    {
        $this->db->select('*');
        $this->db->from('type_vehicule');
        $this->db->join('vehicule', 'type_vehicule.id_type_vehicule = vehicule.type');
        $this->db->where('numero', $numero);
        $query = $this->db->get();
        $rows = $query->row_array();
        $view = new ViewsVehicule();
        $view->setIdVehicule($rows['id_vehicule']);
        $view->setNumero($rows['numero']);
        $view->setMarque($rows['marque']);
        $view->setModele($rows['model']);
        $view->setIdType($rows['id_type_vehicule']);
        $view->setType($rows['type_vehicule']);
        return $view;
    }

    public function getAllViewVehicule()
    {
        $tabVehicule = array();
        $this->db->select('*');
        $this->db->from('type_vehicule');
        $this->db->join('vehicule', 'type_vehicule.id_type_vehicule = vehicule.type');
        $query = $this->db->get();
        foreach($query->result_array()  as $rows)
        {
            $view = new ViewsVehicule();
            $view->setIdVehicule($rows['id_vehicule']);
            $view->setNumero($rows['numero']);
            $view->setMarque($rows['marque']);
            $view->setModele($rows['model']);
            $view->setIdType($rows['id_type_vehicule']);
            $view->setType($rows['type_vehicule']);
            $tabVehicule[] = $view;
        }
        return $tabVehicule;
    }

    public function elimierUnNumero($numero)
    {
        $data = array();
        $tabVehicule = $this->getAllVehicule();
        foreach($tabVehicule as $vehicule)
        {
            if($vehicule->getNumero() == $numero)
            {
                continue;
            }
            $view = new ViewsVehicule();
            $view->setIdVehicule($vehicule->getIdVehicule());
            $view->setNumero($vehicule->getNumero());
            $view->setMarque($vehicule->getMarque());
            $view->setModele($vehicule->getModele());
            $data[] = $view;
        }
        return $data;
    }

    public function insertionVehicule($vehicule)
    {
        $this->db->set('numero', $vehicule->getNumero());
        $this->db->set('marque', $vehicule->getMarque());
        $this->db->set('model', $vehicule->getModele());
        $this->db->set('type', $vehicule->getIdType());
        $this->db->insert('vehicule');
    }
}
?>