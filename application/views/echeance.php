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
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/listeTrajetParVehicule"><i class="fa fa-table fa-fw"></i>Liste trajet</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/vehiculeDisponible"><i class="fa fa-table fa-fw"></i>Disponibilité  des véhicule</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlChauffeur/pageAjouterEcheance"><i class="fa fa-plus-square fa-fw"></i>Ajouter écheance</a>
                            </li>
                            <li>
                                <a href="tables.html"><i class="fa fa-plus-square fa-fw"></i>Carburant</a>
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
                            <h3 class="page-header">Filtre d'échéance par numéro du véhicule</h3>
                        </div>
                        <div class="col-lg-6">
                            <p style="color: red;"><?php if(isset($erreur)) { echo $erreur; } ?></p>
                            <form action="<?php echo base_url(); ?>CtrlChauffeur/listeEcheance" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Numéro du véhicule</label>
                                <select name="numero" class="form-control">
                                    <option>Choisir le numéro du véhicule</option>
                                    <?php foreach($tabVehicule as $vehicule) { ?>
                                        <option value="<?php echo $vehicule->getNumero(); ?>"><?php echo $vehicule->getNumero(); ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Afficher"/>
                        </form>
                        <br>
                        <?php if(isset($tabEcheance)) { ?>
                            <h3>Liste d'échéance</h3>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Numéro du véhicule</th>
                                    <th>Type d'échéance</th>
                                    <th>Date fin d'echeance</th>
                                    <th>Jours restant d'échéance</th>
                                    <th>Options</th>
                                </tr>
                            <?php foreach($tabEcheance as $echeance) { ?>
                                <form action="<?php echo base_url(); ?>CtrlChauffeur/modifier" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $echeance->getIdDetailsEcheance(); ?>" />
                                    <tr style="background-color: <?php echo $echeance->getCouleur(); ?>;">
                                        <td><?php echo $echeance->getNumeroVehicule(); ?></td>
                                        <td><?php echo $echeance->getTypeEcheance(); ?></td>
                                        <td><?php echo $echeance->getDateEcheance(); ?></td>
                                        <td><?php echo $echeance->getJoursRestantEcheance(); ?></td>
                                        <td><input type="submit" value="Modifier" class="btn btn-primary" /></td>
                                    </tr>
                                </form>
                            <?php } ?>
                            </table>
                        <?php } ?>
                        <br>
                        <?php if(isset($condition)) { ?>
                            <h3>Modier une échéance</h3>
                            <p style="color: red;"><?php if(isset($erreur)) { echo $erreur; } ?></p>
                            <form action="<?php echo base_url(); ?>CtrlChauffeur/modificationEcheance" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $echeances->getIdDetailsEcheance(); ?>"/>
                                <div class="form-group">
                                    <label>Numéro du véhicule</label>
                                    <select name="numero" class="form-control">
                                        <option value="<?php echo $echeances->getIdVehicule(); ?>"><?php echo $echeances->getNumeroVehicule(); ?></option>
                                        <?php foreach($tabVehiculeFiltre as $vehicule) { ?>
                                            <option value="<?php echo $vehicule->getIdVehicule(); ?>"><?php echo $vehicule->getNumero(); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Type d'échéance</label>
                                    <select name="echeance" class="form-control">
                                        <option value="<?php echo $echeances->getIdEcheance(); ?>"><?php echo $echeances->getTypeEcheance(); ?></option>
                                        <?php foreach($tabEcheanceFiltre as $echeance) { ?>
                                            <option value="<?php echo $echeance->getIdEcheance(); ?>"><?php echo $echeance->getTypeEcheance(); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <input type="date" name="date" class="form-control" value="<?php echo $echeances->getDateEcheance(); ?>">
                                </div>
                                <input type="submit" class="btn btn-primary" value="Modifier"/>
                            </form>
                        <?php } ?>
                        </div>
                    </div>  
                </div>
            </div>

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
