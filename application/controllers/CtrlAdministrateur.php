<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once("BaseController.php");

class CtrlAdministrateur extends BaseController 
{

    public function __construct()
    {
		parent::__construct();

	}

    public function pageAccueil()
    {
        $this->load->helper('assets_helper');
        $this->load->view('accueil');
    }

    public function pageAjouterElement()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $this->load->model('ViewsMaintenance');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $data['tabElement'] = $this->ViewsMaintenance->getAllElements();
        $this->load->view('maintenances', $data);
    }

    public function pageMaintenance()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $this->load->view('detailsMaintenance', $data);
    }

    public function maintenanceParVehicule()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $numero = $this->input->post('numero');
        if(!empty($numero))
        {
            $this->load->model('ViewsMaintenance');
            $data['tabMaintenance'] = $this->ViewsMaintenance->getAllMaintenanceParVoiture($numero);
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('detailsMaintenance', $data);
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $this->load->view('detailsMaintenance', $data);
        }
    }

    public function insertionElements()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $this->load->model('ViewsMaintenance');
        $idVehicule = $this->input->post('numero');
        $idElements = $this->input->post('elements');
        $date = $this->input->post('date');
        if(!empty($idElements) && !empty($idVehicule) && !empty($date))
        {
            $maintenance = new ViewsMaintenance();
            $maintenance->setIdVehicule($idVehicule);
            $maintenance->setIdElement($idElements);
            $maintenance->setDateMaintenance($date);
            $this->ViewsMaintenance->insertionElements($maintenance);
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabElement'] = $this->ViewsMaintenance->getAllElements();
            $this->load->view('maintenances', $data);
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabElement'] = $this->ViewsMaintenance->getAllElements();
            $this->load->view('maintenances', $data);
        }
    }

    public function listeTrajet()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
        $this->load->view('listeTrajetParVehicule', $data);
    }

    public function exportPdf()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ExportPdf');
        $numero = $this->input->post('numero');
        if(!empty($numero))
        {
            $this->ExportPdf->AliasNbPages();
            $this->ExportPdf->AddPage();
            $this->ExportPdf->Theader();
            $this->ExportPdf->Tbody($numero);
            $this->ExportPdf->BeforeFooter();
            $this->ExportPdf->Output();
        }
        else
        {
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $this->load->view('listeTrajetParVehicule', $data);
        }
    }

    public function listeTrajetParVehicule()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsTrajet');
        $this->load->model('ViewsVehicule');
        $numero = $this->input->post('numero');
        if(!empty($numero))
        {
            $data['numero'] = $numero;
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['tabViewsTrajet'] = $this->ViewsTrajet->getAllViewsTrajet($numero);
            $this->load->view('listeTrajetParVehicule', $data);
        }
        else
        {
            $data['tabVehicule'] = $this->ViewsVehicule->getAllVehicule();
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $this->load->view('listeTrajetParVehicule', $data);
        }  
    }

    public function deconnexion()
    {
        $this->load->helper('assets_helper');
        $this->session->sess_destroy();
        redirect(base_url());
    }

    public function insertionVehicule()
    {
        $this->load->helper('assets_helper');
        $this->load->model('ViewsVehicule');
        $numero = trim($this->input->post('numero'));
        $marque = trim($this->input->post('marque'));
        $model = trim($this->input->post('modele'));
        $type = $this->input->post('type');
        if(!empty($numero) && !empty($marque) && !empty($model) && !empty($type))
        {
            $view = new ViewsVehicule();
            $view->setNumero($numero);
            $view->setMarque($marque);
            $view->setModele($model);
            $view->setIdType($type);
            $this->ViewsVehicule->insertionVehicule($view);
            $this->load->view('accueil');
        }
        else
        {
            $data['erreur'] = "Oups! Veiullez réessayez s'il vous plait!";
            $this->load->view('accueil', $data);
        }
    }
}
?>