<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Administrateur</title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/metisMenu.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/timeline.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/startmin.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/morris.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/colors.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>assets/css/version/tech.css" rel="stylesheet">
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">Administrateur</a>
                </div>
                <ul class="nav navbar-nav navbar-left navbar-top-links">
                    <li><a href="#"><i class="fa fa-home fa-fw"></i>Back Office</a></li>
                </ul>

                <ul class="nav navbar-right navbar-top-links">
                    <li class="dropdown navbar-inverse">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i> <b class="caret"></b>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i> secondtruth <b class="caret"></b>
                        </a>
                    </li>
                </ul>
                <div class="navbar-default sidebar" role="navigation" style="margin-top: 60px;">
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
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlAdministrateur/pageAccueil" class="active"><i class="fa fa-dashboard fa-fw"></i>Accueil</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlAdministrateur/listeTrajet"><i class="fa fa-table fa-fw"></i>Liste trajet</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlAdministrateur/pageAjouterElement"><i class="fa fa-plus-square fa-fw"></i>Ajouter éléments</a>
                            </li>
                            <li>
                                <a href="<?php echo base_url(); ?>CtrlAdministrateur/deconnexion"><i class="fa fa-sign-out"></i>Déconnexion</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">Liste des trajet par des véhicule</h1>
                        </div>
                    </div>
                    <div class="col-lg-6">
                    <p style="color: red;"><?php if(isset($erreur)) { echo "Oups! Veiullez réessayez s'il vous plait!"; } ?></p>
                            <form action="<?php echo base_url(); ?>CtrlAdministrateur/listeTrajetParVehicule" method="post" enctype="multipart/form-data">
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
                    </div>
                    <div class="col-lg-12">
                        <?php if(isset($tabViewsTrajet)) {  ?>
                            <table class="table table-bordered table-hover">
                                <tr>
                                    <th>Numéro</th>
                                    <th>Type du trajet</th>
                                    <th>Lieu</th>
                                    <th>Kilomètrage</th>
                                    <th>Date et Heure</th>
                                    <th>Motif</th>
                                </tr>
                                <?php foreach($tabViewsTrajet as $viewsTrajet) { ?>
                                    <tr>
                                        <td><?php echo $viewsTrajet->getNumero(); ?></td>
                                        <td><?php echo $viewsTrajet->getTypeTrajet(); ?></td>
                                        <td><?php echo $viewsTrajet ->getLieu(); ?></td>
                                        <td><?php echo $viewsTrajet->getKilometrage() ?></td>
                                        <td><?php echo $viewsTrajet->getDateTrajet(); ?> <?php echo $viewsTrajet->getHeureTrajet(); ?></td>
                                        <td><?php echo $viewsTrajet->getMotif() ?></td>
                                    </tr>
                                <?php } ?>
                            </table>
                            <form action="<?php echo base_url(); ?>CtrlAdministrateur/exportPdf" method="post">
                                <input type="hidden" name="numero" value="<?php echo $numero; ?>" />
                                <input type="submit" class="btn btn-primary" value="Export en pdf" />
                            </form>
                        <?php } ?>
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
        <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/tether.min.js"></script>
    </body>
</html>
