<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once("BaseController.php");

class CtrlChauffeur extends BaseController 
{

    public function __construct()
    {
		parent::__construct();

	}

    public function deconnexion()
    {
        $this->load->helper('assets_helper');
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function listeTrajet()
    {
        $this->load->helper('assets_helper');
        $this->load->view('listeTrajet');
    }

    public function pageCarburant()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $this->load->model('ViewsCarburant');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $data['tabCarburant'] = $this->ViewsCarburant->getAllTypeCarburant();
        $this->load->view('carburant', $data);
    }

    public function ajouterCarburant()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $this->load->model('ViewsCarburant');
        $idVehicule = $this->input->post('numero');
        $typeCarburant = $this->input->post('carburant');
        $montant = $this->input->post('montant');
        $litre = $this->input->post('litre');
        $date = $this->input->post('date');
        $quantite = $this->input->post('quantite');
        if((!empty($idVehicule)&&!empty($typeCarburant)&&!empty($montant)&&!empty($date)) || (!empty($idVehicule)&&!empty($typeCarburant)&&!empty($litre)&&!empty($date)))
        {
            $carburant = $this->ViewsCarburant->getSimpleViewCarburant($typeCarburant);
            if($montant == "montant")
            {
                $litreCarburant = $this->ViewsCarburant->calculeLitre($quantite, $carburant->getPrixParLitre());
                $carburants = new ViewsCarburant();
                $carburants->setIdTypeCarburant($carburant->getIdTypecarburant());
                $carburants->setQuantite($litreCarburant);
                $carburants->setMontant($quantite);
                $carburants->setIdVehicule($idVehicule);
                $carburants->setDateCarburant($date);
                $this->ViewsCarburant->insertionCarburant($carburants);
            }
            else if($litre == "litre")
            {
                $montantCarburant = $this->ViewsCarburant->calculeMontant($quantite, $carburant->getPrixParLitre());
                $carburants = new ViewsCarburant();
                $carburants->setIdTypeCarburant($carburant->getIdTypecarburant());
                $carburants->setQuantite($quantite);
                $carburants->setMontant($montantCarburant);
                $carburants->setIdVehicule($idVehicule);
                $carburants->setDateCarburant($date);
                $this->ViewsCarburant->insertionCarburant($carburants);
            }
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabCarburant'] = $this->ViewsCarburant->getAllTypeCarburant();
            $this->load->view('carburant', $data);
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabCarburant'] = $this->ViewsCarburant->getAllTypeCarburant();
            $this->load->view('carburant', $data);
        }
    }

    public function insertionTrajet()
    {
        $this->load->helper('assets_helper');
        $numero = $this->input->post('numero');
        $typeTrajet = $this->input->post('typeTrajet');
        $lieu = $this->input->post('lieu');
        $kilometrage = $this->input->post('kilometrage');
        $date = $this->input->post('date');
        $heure = $this->input->post('heure');
        $motif = $this->input->post('motif');
        if(!empty($numero) && !empty($typeTrajet) && !empty($lieu) && !empty($kilometrage) && !empty($date) && !empty($heure) && !empty($motif))
        {
            $this->load->model('ViewsEcheance');
            $this->load->model('Trajet');
            $condition = $this->ViewsEcheance->verificationDisponibiteVehicule($numero);
            $condition2 = $this->Trajet->verifierVehicule($numero);
            if($condition == true || $condition2 == false || $typeTrajet == "Arrivé")
            {
                $trajetVehicule = $this->Trajet->getSimpleTrajet($numero);
                if(!empty($trajetVehicule))
                {
                    $verifierDateHeure = $this->ViewsEcheance->verificationdateEtHeure($date, $heure, $numero);
                    if($kilometrage >= 0 && $kilometrage >= $trajetVehicule->getKilometrage() && $verifierDateHeure == true)
                    {
                        $this->load->model('Chauffeur');
                        $this->load->model('ViewsVehicule');
                        $chauffeur = $this->Chauffeur->getSimpleChauffeur($this->session->userdata('username_chauffeur'), $this->session->userdata('mdp_chauffeur'));
                        $vehicule = $this->ViewsVehicule->getSimpleViewvehicule($numero);
                        $trajet = new Trajet();
                        $trajet->setTypeTrajet($typeTrajet);
                        $trajet->setLieu($lieu);
                        $trajet->setKilometrage($kilometrage);
                        $trajet->setDateTrajet($date);
                        $trajet->setHeureTrajet($heure);
                        $trajet->setVehicule($vehicule->getIdVehicule());
                        $trajet->setChauffeur($chauffeur->getIdChauffeur());
                        $trajet->setMotif($motif);
                        $this->Trajet->insertionTrajet($trajet);
                        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
                        $this->load->view('chauffeur', $data);
                    }
                    else
                    {
                        $this->load->model('ViewsVehicule');
                        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
                        $data['erreur'] = "Oups! Le kilomètrage doit être nombre positif et n'est pas infierieur au précedent. Le kilomètrage précedent est ".$trajetVehicule->getKilometrage();
                        $this->load->view('chauffeur', $data);
                    }
                }
                else
                {
                    if($kilometrage >= 0)
                    {
                        $this->load->model('Chauffeur');
                        $this->load->model('ViewsVehicule');
                        $chauffeur = $this->Chauffeur->getSimpleChauffeur($this->session->userdata('username_chauffeur'), $this->session->userdata('mdp_chauffeur'));
                        $vehicule = $this->ViewsVehicule->getSimpleViewvehicule($numero);
                        $trajet = new Trajet();
                        $trajet->setTypeTrajet($typeTrajet);
                        $trajet->setLieu($lieu);
                        $trajet->setKilometrage($kilometrage);
                        $trajet->setDateTrajet($date);
                        $trajet->setHeureTrajet($heure);
                        $trajet->setVehicule($vehicule->getIdVehicule());
                        $trajet->setChauffeur($chauffeur->getIdChauffeur());
                        $trajet->setMotif($motif);
                        $this->Trajet->insertionTrajet($trajet);
                        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
                        $this->load->view('chauffeur', $data);
                    }
                    else
                    {
                        $this->load->model('ViewsVehicule');
                        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
                        $data['erreur'] = "Oups! Le kilomètrage doit être nombre positif et n'est pas infierieur au précedent. Le kilomètrage précedent est ".$trajetVehicule->getKilometrage();;
                        $this->load->view('chauffeur', $data);
                    }
                }
            }
            else
            {
                $data['erreur'] = "Oups! Cet véhicule démande n'est pas encors disponible!";
                $this->load->model('ViewsVehicule');
                $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
                $this->load->view('chauffeur', $data);
            }
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $this->load->model('ViewsVehicule');
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('chauffeur', $data);
        }
    }

    public function pageAccueil()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $this->load->view('chauffeur', $data);
    }

    public function pageEcheance()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $this->load->view('echeance', $data);
    }

    public function pageAjouterEcheance()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $this->load->model('ViewsEcheance');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $data['tabEcheance'] = $this->ViewsEcheance->getAllEcheance();
        $this->load->view('ajouterEcheance', $data);
    }

    public function ajouterEcheance()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $this->load->model('ViewsEcheance');
        $numero = $this->input->post('numero');
        $echeance = $this->input->post('echeance');
        $date = $this->input->post('date');
        if(!empty($numero) && !empty($echeance) && !empty($date))
        {
            $echeances = new ViewsEcheance();
            $echeances->setIdEcheance($echeance);
            $echeances->setIdVehicule($numero);
            $echeances->setDateEcheance($date);
            $this->ViewsEcheance->insertionEcheance($echeances);
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabEcheance'] = $this->ViewsEcheance->getAllEcheance();
            $this->load->view('ajouterEcheance', $data);
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabEcheance'] = $this->ViewsEcheance->getAllEcheance();
            $this->load->view('ajouterEcheance', $data);
        }
    }

    public function modifier()
    {
        $this->load->helper('assets_helper');
        $idDetailsEcheance = $this->input->post('id');
        $this->load->model('ViewsEcheance');
        $this->load->model('ViewsVehicule');
        $echeance = $this->ViewsEcheance->getSimpleViewEcheanceAvecFiltre($idDetailsEcheance);
        $data['echeances'] = $echeance;
        $data['tabEcheance'] = $this->ViewsEcheance->getAllViewEcheanceAvecFiltreFinal($echeance->getNumeroVehicule());
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $data['tabEcheanceFiltre'] = $this->ViewsEcheance->eliminerEcheance($echeance->getTypeEcheance());
        $data['tabVehiculeFiltre'] = $this->ViewsVehicule->elimierUnNumero($echeance->getNumeroVehicule());
        $data['condition'] = true;
        $this->load->view('echeance', $data);
    }

    public function modificationEcheance()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsEcheance');
        $this->load->model('ViewsVehicule');
        $idVehicule = $this->input->post('numero');
        $idEcheance = $this->input->post('echeance');
        $idDetailsEcheance = $this->input->post('id');
        $date = $this->input->post('date');
        if(!empty($idVehicule) && !empty($idEcheance) && !empty($idDetailsEcheance) && !empty($date))
        {
            $detailsEcheance = new ViewsEcheance();
            $detailsEcheance->setIdDetaisEcheance($idDetailsEcheance);
            $detailsEcheance->setIdVehicule($idVehicule);
            $detailsEcheance->setIdEcheance($idEcheance);
            $detailsEcheance->setDateEcheance($date);
            $this->ViewsEcheance->modificationDetailsEcheance($detailsEcheance);
            $echeance = $this->ViewsEcheance->getSimpleViewEcheanceAvecFiltre($idDetailsEcheance);
            $data['echeances'] = $echeance;
            $data['tabEcheance'] = $this->ViewsEcheance->getAllViewEcheanceAvecFiltreFinal($echeance->getNumeroVehicule());
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('echeance', $data);
        }
        else
        {
            $echeance = $this->ViewsEcheance->getSimpleViewEcheanceAvecFiltre($idDetailsEcheance);
            $data['echeances'] = $echeance;
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $data['tabEcheance'] = $this->ViewsEcheance->getAllViewEcheanceAvecFiltreFinal($echeance->getNumeroVehicule());
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('echeance', $data);
        }
    }

    public function listeEcheance()
    {
        $this->load->helper('assets_helper');
        $numero = $this->input->post('numero');
        if(!empty($numero))
        {
            $this->load->model('ViewsEcheance');
            $this->load->model('ViewsVehicule');
            $data['tabEcheance'] = $this->ViewsEcheance->getAllViewEcheanceAvecFiltreFinal($numero);
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('echeance', $data);
        }
        else
        {
            $this->load->helper('assets_helper');
            $this->load->model('ViewsVehicule');
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('echeance', $data);
        }
    }

    public function vehiculeDisponible()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsEcheance');
        $this->load->model('ViewsVehicule');
        $data['tabVehicule'] = $this->ViewsEcheance->getAllVehiculeDisponibleFinal();
        $this->load->view('disponibilite', $data);
    }
}














