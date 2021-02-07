<!-- <div id="login d-flex align-content-center">

    <div class="container shadow p-3  mb-5 bg-white rounded">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">
                    <form id="login-form" class="form" action="<?= $vars['baseUrl'] ?>loc=user&action=login" method="post">
                        <h3 class="text-center text-info">Connexion</h3>
                        <div class="form-group">
                            <label for="username" class="text-info">Identifiant:</label><br>
                            <input type="text" name="Users[username]" id="username" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password" class="text-info">Mot de passe:</label><br>
                            <input type="text" name="Users[password]" id="password" value="azerty14AZERTY!" class="form-control">
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

<div class="login-page">
    <div class="content">
        <label for="">Connexion</label>


    </div>
</div> -->
<?php  if(@$vars['message'] == 'disconnect'){
    echo 'toto';
} ?>
<div class="flex w-full h-full justify-center md:mt-48 items-stretch login-page">

    <div class="flex w-1/2  self-center">
        <div class="lg:w-full xl:max-w-screen-sm shadow-2xl bg-white">

            <div class="mt-10 px-12 sm:px-24 md:px-48 lg:px-12 lg:mt-16 xl:px-24 xl:max-w-2xl">
                <h2 class="text-center text-4xl text-indigo-900 font-display font-semibold lg:text-left xl:text-5xl
                    xl:text-bold flex justify-center">Connexion</h2>
                <div class="mt-12">
                    <form id="login-form" class="form" action="<?= $vars['baseUrl'] ?>user/login" method="post">
                        <div>
                            <div class="ml-6 text-sm font-bold text-gray-700 tracking-wide">Identifiant</div>
                            <i class="far fa-user-circle"></i><input class=" w-5/6 ml-2 text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500" type="text" value="luther" placeholder="mike@gmail.com" name="Users[username]">
                        </div>
                        <div class="mt-8">
                            <div class="flex justify-between items-center">
                                <div class="ml-6 text-sm font-bold text-gray-700 tracking-wide">
                                    Mot de passe
                                </div>

                            </div>
                            <i class="fas fa-lock"></i> <input class="w-5/6 ml-2 text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500" value="azerty14AZERTY!" type="password" name="Users[password]" placeholder="Enter your password">
                        </div>
                        <div class="mt-10">
                            <button class="float-right bg-indigo-500 text-gray-100 p-4 mb-2 rounded tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
                                ">
                                Valider
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>