<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="<?php echo css_loader("bootstrap"); ?>" rel="stylesheet">
    <link href="<?php echo css_loader("bootstrap.min"); ?>" rel="stylesheet">
</head>
<body>
<section class="vh-100"  style="background-color: skyblue;">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-2-strong" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">
            <h1 class="mb-5">Login Admin</h1>
            <p style="color: red;"><?php if(isset($erreur)) { echo "Oups! Veiullez réessayez s'il vous plait!"; } ?></p>
            <form action="<?php echo base_url(); ?>CtrlAccueil/connexion" method="post">
              <div class="form-outline mb-3">
                <label class="form-label" for="typeEmailX-2">Nom d'utilisateur</label>
                <input type="email" name="username" id="typeEmailX-2" class="form-control" />
              </div>
              <div class="form-outline mb-3">
                <label class="form-label" for="typePasswordX-2">Mot de passe</label>
                <input type="password" name="mdp" id="typePasswordX-2" class="form-control" />
              </div>
              <div class="form-outline mb-3">
                <label class="form-label" for="typePasswordX-2">Rôle</label>
                <select id="typePasswordX-2" class="form-control" name="role">
                        <option>Choisir une rôle</option>
                        <option value="Chauffeur">Chauffeur</option>
                        <option value="Administrateur">Administrateur</option>
                </select>
              </div>
              <div class="form-check d-flex justify-content-start mb-3">
                <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                <label class="form-check-label" for="form1Example3">Mot de passe oublié ?</label>
              </div>
              <input class="btn btn-primary btn-lg btn-block" type="submit" value="Se connecter" />
            </form>
            <hr class="my-4">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>