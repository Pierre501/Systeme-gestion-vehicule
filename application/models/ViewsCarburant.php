<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class ViewsCarburant extends CI_Model
{
    private $idTypeCarburant;
    private $typeCarburant;
    private $idIdDetailTypeCarburant;
    private $prixParLitre;
    private $dateDetaisCarburant;
    private $idCarburant;
    private $montant;
    private $quantite;
    private $idVehicule;
    private $dateCarburant;

    public function setIdTypeCarburant($idTypeCarburant)
    {
        $this->idTypeCarburant = $idTypeCarburant;
    }

    public function getIdTypeCarburant()
    {
        return $this->idTypeCarburant;
    }

    public function setTypeCarburant($typeCarburant)
    {
        $this->typeCarburant = $typeCarburant;
    }

    public function getTypeCarburant()
    {
        return $this->typeCarburant;
    }

    public function setIdDetailsTypeCarburant($idIdDetailTypeCarburant)
    {
        $this->idIdDetailTypeCarburant = $idIdDetailTypeCarburant;
    }

    public function getIdDetailsTypeCarburant()
    {
        return $this->idIdDetailTypeCarburant;
    }

    public function setPrixParLitre($prixParLitre)
    {
        $this->prixParLitre = $prixParLitre;
    }

    public function getPrixParLitre()
    {
        return $this->prixParLitre;
    }

    public function setDateDetaisCarburant($dateDetaisCarburant)
    {
        $this->dateDetaisCarburant = $dateDetaisCarburant;
    }

    public function getDateDetailsCarburant()
    {
        return $this->dateDetaisCarburant;
    }

    public function setDateCarburant($dateCarburant)
    {
        $this->dateCarburant = $dateCarburant;
    }

    public function getDateCarburant()
    {
        return $this->dateCarburant;
    }

    public function setIdCarburant($idCarburant)
    {
        $this->idCarburant = $idCarburant;
    }

    public function getIdCarburant()
    {
        return $this->idCarburant;
    }

    public function setMontant($montant)
    {
        $this->montant =$montant;
    }

    public function getMontant()
    {
        return $this->montant;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setIdVehicule($idVehicule)
    {
        $this->idVehicule = $idVehicule;
    }

    public function getIdVehicule()
    {
        return $this->idVehicule;
    }

    public function insertionCarburant($carburant)
    {
        $this->db->set('id_type_carburant', $carburant->getIdTypeCarburant());
        $this->db->set('quantite', $carburant->getQuantite());
        $this->db->set('montant', $carburant->getMontant());
        $this->db->set('vehicule', $carburant->getIdVehicule());
        $this->db->set('date_carburant', $carburant->getDateCarburant());
        $this->db->insert('carburant');
    }

    public function getSimpleViewCarburant($typeCarburant)
    {
        $this->db->select('*');
        $this->db->from('type_carburant');
        $this->db->join('deatls_type_carburant', 'type_carburant.id_type_carburant = deatls_type_carburant.id_type_carburant');
        $this->db->where('type_carburant.type_carburant', $typeCarburant);
        $query = $this->db->get();
        $rows = $query->row_array();
        $view = new ViewsCarburant();
        $view->setIdTypeCarburant($rows['id_type_carburant']);
        $view->setTypeCarburant($rows['type_carburant']);
        $view->setIdDetailsTypeCarburant($rows['id_details_type_carburant']);
        $view->setPrixParLitre($rows['prix_par_litre']);
        $view->setDateDetaisCarburant($rows['date_details_carburant']);
        return $view;
    }

    public function getAllTypeCarburant()
    {
        $tabTypeCarburant = array();
        $query = $this->db->get('type_carburant');
        foreach($query->result_array() as $rows)
        {
            $view = new ViewsCarburant();
            $view->setIdTypeCarburant($rows['id_type_carburant']);
            $view->setTypeCarburant($rows['type_carburant']);
            $tabTypeCarburant[] = $view;
        }
        return $tabTypeCarburant;
    }

    public function calculeLitre($montant, $prixParLitre)
    {
        $litre = $montant / $prixParLitre;
        return $litre;
    }

    public function calculeMontant($litre, $prixParLitre)
    {
        $montant = $litre * $prixParLitre;
        return $montant;
    }
}
?>