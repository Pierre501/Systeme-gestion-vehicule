<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Chauffeur</title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/metisMenu.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/timeline.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/startmin.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/morris.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    </head>
    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">Chauffeur</a>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i>Website</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    
                </ul>
                <div class="navbar-default sidebar" role="navigation">
                    <div class="sidebar-nav navbar-collapse">
                        <ul class="nav" id="side-menu">
                            <li class="sidebar-search">
                                <div class="input-group custom-search-form">
                                    <input type="text" class="form-control" placeholder="Recherche...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fa fa-search"></i>
                                        </button>
                                </span>
                                </div>
                                <!-- /input-group -->
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/pageAccueil" class="active"><i class="fa fa-dashboard fa-fw"></i>Accueil</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/pageEcheance"><i class="fa fa-table fa-fw"></i>Liste échéance</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/listeTrajet"><i class="fa fa-table fa-fw"></i>Liste trajet</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/vehiculeDisponible"><i class="fa fa-table fa-fw"></i>Disponibilité des véhicule</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/pageAjouterEcheance"><i class="fa fa-plus-square fa-fw"></i>Ajouter écheance</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/pageCarburant"><i class="fa fa-plus-square fa-fw"></i>Carburant</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/deconnexion"><i class="fa fa-sign-out fa-fw"></i>Déconnexion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h3 class="page-header">Formulaire trajet</h3>
                        </div>
                        <div class="col-lg-12"><p style="color: red;"><?php if(isset($erreur)) { echo $erreur; } ?></p></div>
                        <div class="col-lg-6">
                        <form action="<?php echo base_url(); ?>CtrlChauffeur/insertionTrajet" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Numéro du véhicule</label>
                                <select name="numero" class="form-control">
                                    <option>Choisir le numéro du véhicule</option>
                                    <?php foreach($tabVehicule as $vehicule) { ?>
                                        <option value="<?php echo $vehicule->getNumero(); ?>"><?php echo $vehicule->getNumero(); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Type trajet</label>
                                <select name="typeTrajet" class="form-control">
                                    <option>Choisir le type du trajet</option>
                                    <option value="Départ">Départ</option>
                                    <option value="Arrivé">Arrivé</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Lieu</label>
                                <input class="form-control" type="text" name="lieu">
                            </div>
                            <div class="form-group">
                                <label>Kilomètrage</label>
                                <input class="form-control" type="number" name="kilometrage">
                            </div>
                            <div class="form-group">
                                <label>Date du trajet</label>
                                <input class="form-control" type="date" name="date">
                            </div>
                            <div class="form-group">
                                <label>Heure du trajet</label>
                                <input class="form-control" type="time" name="heure">
                            </div>
                            <div class="form-group">
                                <label>Motif du trajet</label>
                                <input class="form-control" type="text" name="motif">
                            </div>
                            <input type="submit" class="btn btn-primary" value="Ajouter"/>
                        </form>
                    </div>
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /#page-wrapper -->

        </div>
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/metisMenu.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/raphael.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/morris-data.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/startmin.js"></script>

    </body>
</html>
