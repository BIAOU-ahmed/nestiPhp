<div id="login d-flex align-content-center">

    <div class="container shadow p-3  mb-5 bg-white rounded">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="<?= $vars['baseUrl'] ?>/loc=user&action=login" method="post">
                        <h3 class="text-center text-info">Connexion</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Identifiant:</label><br>
                            <input type="text" name="User[username]" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Mot de passe:</label><br>
                            <input type="text" name="User[password]" id="password" class="form-control">
                        </div>
                        <div class="form-group float-right">
                            <input type="submit" name="submit" class="btn btn-info btn-md" value="Valider">
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>