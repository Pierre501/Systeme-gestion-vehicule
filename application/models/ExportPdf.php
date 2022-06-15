<?php if(! defined('BASEPATH')) exit('No direct script access allowed');
require_once('Fpdf.php');

class ExportPdf extends Fpdf
{

	public function getDateDuJour()
	{
		date_default_timezone_set('Africa/Nairobi');
		$annee_encours = date('Y'); 
		$mois_encours = date('M');
		$jour_ancours = date('d');
		$date = $jour_ancours."/".$mois_encours."/".$annee_encours;
		return $date;
	}

    public function Header()
	{
   		$this->SetFont('Arial','B',15);
    	$this->Cell(170,10,'LISTES DES TRAJET DU VEHICULE',0,0,'C');
    	$this->Ln(10);
	}

	public function Theader()
	{
		$this->setFont('Times','B','12');
		$this->cell(20,10,'Numéro',1,0,'C');
		$this->cell(30,10,'Type du trajet',1,0,'C');
		$this->cell(30,10,'Lieu',1,0,'C');
		$this->cell(30,10,'kilomètrage',1,0,'C');
		$this->cell(50,10,'Motif',1,0,'C');
		$this->cell(30,10,'Date',1,0,'C');
		$this->Ln();
	}

	public function Tbody($numero)
	{
		$this->setFont('Times','','12');
		$this->load->model('ViewsTrajet');
		$tabViewstrajet = $this->ViewsTrajet->getAllViewsTrajet($numero);
		foreach($tabViewstrajet as $viewTrajet)
		{
			$this->cell(20,10,$viewTrajet->getNumero(),1,0,'C');
			$this->cell(30,10,$viewTrajet->getTypeTrajet(),1,0,'L');
			$this->cell(30,10,$viewTrajet->getLieu(),1,0,'L');
			$this->cell(30,10,$viewTrajet->getKilometrage(),1,0,'L');
			$this->cell(50,10,$viewTrajet->getMotif(),1,0,'L');
			$this->cell(30,10,$viewTrajet->getDateTrajet(),1,0,'L');
			$this->Ln();
		}
		$this->Ln(5);
	}

	public function BeforeFooter()
	{
		$this->setFont('Times','','12');
		$this->cell(300,10,'Fait a Antananarivo,le '.$this->getDateDuJour(),0,0,'C');
		$this->Ln(4);
	}

	public function Footer()
	{
    	$this->SetY(-15);
    	$this->SetFont('Arial','I',8);
    	$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}


}
?>