<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CtrlAccueil extends CI_Controller 
{

    public function index()
    {
        $this->load->helper('assets_helper');
        $this->load->view('index');
    }

    public function connexion()
    {
        $this->load->helper('assets_helper');
        $this->load->model('Administrateur');
        $username = $this->input->post('username');
        $mdp = $this->input->post('mdp');
        $role = $this->input->post('role');
        if(!empty($username) && !empty($mdp) && !empty($role))
        {
            if($role == "Administrateur")
            {
                $condition = $this->Administrateur->verifierAdministrateur($username, $mdp);
                if($condition == true)
                {
                    $this->load->model('ViewsVehicule');
                    $this->session->set_userdata('username_admin', $username);
                    $this->session->set_userdata('mdp_admin', $mdp);
                    $this->session->set_userdata('role', $role);
                    $data['tabViewVehicule'] = $this->ViewsVehicule->getAllTypeVehicule();
                    $this->load->view('accueil', $data);
                }
                else
                {
                    $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
                    $this->load->view('index', $data);
                }
            }
            else
            {
                $this->load->model('Chauffeur');
                $condition = $this->Chauffeur->verifierLogin($username, $mdp);
                if($condition == true)
                {
                    $this->load->model('ViewsVehicule');
                    $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
                    $this->session->set_userdata('username_chauffeur', $username);
                    $this->session->set_userdata('mdp_chauffeur', $mdp);
                    $this->session->set_userdata('role', $role);
                    $this->load->view('chauffeur', $data);
                }
                else
                {
                    $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
                    $this->load->view('index', $data);
                }
            }
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $this->load->view('index', $data);
        }
    }
}

?>
