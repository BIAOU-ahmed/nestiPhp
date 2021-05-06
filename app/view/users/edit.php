<div class="font-sans antialiased bg-grey-lightest">

    <!-- Content -->
    <div class="bg-grey-lightest">
        <div class=" pt-8">
            <div class=" bg-white rounded shadow">

                <div class="py-4 px-8 text-black text-xl border-b border-grey-lighter">

                    <?php if ($vars["entity"]->getId() == null) {  ?>
                        Création d'un utilisateur

                    <?php } else { ?>
                        Edition des utilisateurs
                    <?php }  ?>
                </div>
                <form class="grid gap-4 grid-cols-2" action="<?= $vars['baseUrl'] ?>user/edit/<?= $vars["entity"]->getId() ?>" method="post">


                    <div class="inline-block">
                        <div class="py-4 px-8">
                            <div class="mb-4">
                                <div class=" mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="name">Nom</label>
                                    <input name="Users[lastName]" class="<?= isset($vars["errors"]['lastName']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="name" type="text" value="<?= $vars['entity']->getLastName(); ?>" placeholder="Votre nom">
                                    <?php if (isset($vars["errors"]['lastName']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le nom est obligatoire.</div>
                                    <?php } ?>


                                </div>

                            </div>
                            <div class=" mb-4">
                                <div class=" mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="first_name">Prénom</label>
                                    <input name="Users[firstName]" class="<?= isset($vars["errors"]['firstName']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="first_name" type="text" value="<?= $vars['entity']->getFirstName(); ?>" placeholder="Votre prenom">
                                    <?php if (isset($vars["errors"]['firstName']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le prenom est obligatoire.</div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class=" mb-4">
                                <div class=" mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="address1">adresse</label>
                                    <input name="Users[address1]" class="<?= isset($vars["errors"]['address1']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="address1" type="text" value="<?= $vars['entity']->getAddress1(); ?>" placeholder="Votre adresse">
                                    <?php if (isset($vars["errors"]['address1']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Votre adresse ne peut pas etre vide.</div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class=" mb-4">
                                <div class=" mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="address2">Complement</label>
                                    <input name="Users[address2]" class="appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="address2" type="text" value="<?= $vars['entity']->getAddress2(); ?>" placeholder="Complement d'adresse">

                                </div>

                            </div>
                            <div class=" mb-4 lg:flex justify-between">
                                <div class=" mr-1 lg:inline-block ">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 " for="zipCode">Code Postale</label>
                                    <input name="Users[zipCode]" class="<?= isset($vars["errors"]['zipCode']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="zipCode" type="text" value="<?= $vars['entity']->getZipCode(); ?>" placeholder="34070">
                                    <?php if (isset($vars["errors"]['zipCode']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le code postale est obligatoire.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['zipCode']['numeric'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le code postale doit etre un nombre.</div>
                                    <?php } ?>
                                </div>
                                <div class=" mr-1 lg:inline-block ">
                                    <label class="block text-grey-darker text-sm font-bold mb-2 " for="city">Ville</label>
                                    <input list="citys" name="Users[city]" class="<?= isset($vars["errors"]['city']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="city" type="text" value="<?= $vars['entity']->getCity() != null ? $vars['entity']->getCity()->getName() : ''; ?>" placeholder="Montpellier" />
                                    <?php if (isset($vars["errors"]['city']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">La ville est obligatoire.</div>
                                    <?php } ?>
                                    <datalist id="citys">
                                        <?php foreach ($vars['entity']->getAllCities() as $city) { ?>
                                            <option value="<?= $city->getName() ?>">
                                            <?php } ?>
                                    </datalist>
                                </div>

                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="role">Role</label>
                                <div class="grid gap-4 grid-cols-3">
                                    <label class="inline-flex items-center mt-3">
                                        <input <?= $vars['entity']->isAdministrator() ? 'checked' : ''; ?> type="checkbox" name="roles[admin]" value="admin" class="form-checkbox h-5 w-5 text-purple-600"><span class="ml-2 text-gray-700">Administrateur</span>
                                    </label>
                                    <label class="inline-flex items-center mt-3">
                                        <input <?= $vars['entity']->isChef() ? 'checked' : ''; ?> type="checkbox" name="roles[chef]" value="chef" class="form-checkbox h-5 w-5 text-purple-600"><span class="ml-2 text-gray-700">Chef</span>
                                    </label>
                                    <label class="inline-flex items-center mt-3">
                                        <input <?= $vars['entity']->isModerator() ? 'checked' : ''; ?> type="checkbox" name="roles[moderator]" value="moderator" class="form-checkbox h-5 w-5 text-purple-600"><span class="ml-2 text-gray-700">Moderateur</span>
                                    </label>
                                </div>


                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="state">Etat</label>

                                <select name="Users[flag]" class="form-select border border-light-blue-500 border-opacity-0 appearance-none rounded mt-1 block w-full py-2 px-3" id="state">
                                    <option value="a" <?= $vars['entity']->getFlag() == 'a' ? 'selected' : ''; ?>>Actif</option>
                                    <option value="w" <?= $vars['entity']->getFlag() == 'w' || $vars['entity']->getId() == null ? 'selected' : ''; ?>>En attente</option>
                                    <option value="b" <?= $vars['entity']->getFlag() == 'b' ? 'selected' : ''; ?>>Bloqué</option>
                                </select>
                            </div>

                            <div class="  flex">
                                <div class="relative mr-5 lg:w-1/6 md:w-1/2 shadow">

                                    <button class="w-full h-full bg-indigo-500 text-gray-100 p-2 rounded 
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
                                ">
                                        Valider
                                    </button>

                                </div>

                                <?php if ($vars["entity"]->getId() == null) {  ?>
                                    <input type="reset" value="Annuler" class="cursor-pointer bg-white text-lg  p-2  block lg:inline-block lg:mt-0 relative shadow lg:w-1/5 md:w-1/2 text-center">

                                <?php } else { ?>
                                   <a href="<?= $vars['baseUrl'] ?>user/delete/<?= $vars["entity"]->getId() ?>" class="bg-white text-lg  p-2  block lg:inline-block lg:mt-0 relative shadow lg:w-1/5 md:w-1/2 text-center">

                                        Supprimer
                                    </a>
                                    
                                <?php }  ?>

                            </div>
                            <?php  ?>
                        </div>

                    </div>
                    <div class="inline-block">
                        <?php if ($vars["entity"]->getId() == null) {  ?>
                            <div class="py-4 px-8">

                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="login">Login</label>
                                    <input name="Users[login]" class="<?= isset($vars["errors"]['login']) ? 'border-red-600' : '' ?>  appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="login" type="text" placeholder="Le pseudo">
                                    <?php if (isset($vars["errors"]['login']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le pseudo est obligatoire.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['login']['unique'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le pseudo doit etre unique.</div>
                                    <?php } ?>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="email">Email</label>
                                    <input name="Users[email]" class="<?= isset($vars["errors"]['email']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" type="email" placeholder="john.doe@example.com">
                                    <?php if (isset($vars["errors"]['email']['email'])) { ?>
                                        <div class="invalid-feedback text-red-600">Invalid email.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['email']['unique'])) { ?>
                                        <div class="invalid-feedback text-red-600">L'email doit etre unique.</div>
                                    <?php } ?>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">Mot de passe</label>
                                    <input name="Users[password]" class="<?= isset($vars["errors"]['password']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="password" type="password" placeholder="mot de passe">

                                    <?php if (isset($vars["errors"]['password']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Mot de passe obligatoire.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['password']['strong'])) { ?>
                                        <div class="invalid-feedback text-red-600">Mot de passe trop faible</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['password']['haveNumber'])) { ?>
                                        <div class="invalid-feedback text-red-600">le mot de passe doit avoir au moins un nombre </div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['password']['haveLower'])) { ?>
                                        <div class="invalid-feedback text-red-600">le mot de passe doit avoir au moins une lettre minuscule </div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['password']['haveUpper'])) { ?>
                                        <div class="invalid-feedback text-red-600">le mot de passe doit avoir au moins une lettre majuscule </div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['password']['haveSpecialChar'])) { ?>
                                        <div class="invalid-feedback text-red-600">le mot de passe doit avoir au moins un caractère speciale </div>
                                    <?php } ?>
                                    <div class="grid">
                                        <span id="strength" class="justify-self-end"></span>
                                    </div>

                                    <div id="barMain" class="hidden mt-2 h-2 relative max-w-xl rounded-full overflow-hidden">
                                        <div class="w-full h-full bg-gray-200 absolute"></div>

                                        <div id="progressBar" class="h-full bg-green-500 absolute"></div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between mt-8">
                                    <span>Conseils pour le mot de passe: </span>
                                </div>

                                <div id="nomberof" class="mt-1 ml-5 flex fas">
                                    <i></i> <span class="ml-2">Doit Avoir au moins 10 carateres </span>
                                </div>
                                </br>
                                <div id="digit" class="mt-1 ml-5 flex fas ">
                                    <i></i> <span class="ml-2">Doit contenir au moins un chiffre </span>
                                </div>
                                <div id="lower" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Doit contenir au moins une lettre miniscule</span>
                                </div>
                                <div id="uper" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Doit contenir au moins une lettre Majuscule</span>
                                </div>
                                <div id="spe" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Doit contenir un des caractere speciaux suivant (!#%_?*$\)</span>
                                </div>

                            </div>
                        <?php } else { ?>
                            <div class="py-4  px-8">
                                <span>Informations</span>
                                <div class="border h-5/6">
                                    <span>Date de création:</span> <br>
                                    <span>Dernière Connexion: <?= $vars["entity"]->getLastConnectionDate() ?></span><br>
                                    <?php if ($vars["entity"]->isChef()) { ?>
                                        <h4 class="block text-grey-darker text-xl font-bold">Chef Patissier</h4>
                                        <span>Nombre de recette: <?= $vars["entity"]->getChef()->getNbRecipe() ?></span><br>
                                        <span>Dernière Recette: <?= $vars["entity"]->getChef()->getLastRecipe() ?></span>
                                    <?php } ?>
                                    <h4 class="block text-grey-darker text-xl font-bold">Utilisateur</h4>
                                    <span>Nombre de commande: <?= $vars["entity"]->getNbOrder() ?></span><br>
                                    <span>Montant total des commandes: <?= $vars["entity"]->ordersPrice() ?></span><br>
                                    <span>Derniere commande: <?= $vars["entity"]->getLastOrder() ?></span><br>
                                    <?php if ($vars["entity"]->isAdministrator()) { ?>
                                        <h4 class="block text-grey-darker text-xl font-bold">Administrateur</h4>
                                        <span>Nombre d'importation faite: <?= $vars["entity"]->getAdministrator()->getNbImportation() ?></span><br>
                                        <span>date de la derniere importation: <?= $vars["entity"]->getAdministrator()->getLastImportation() ?></span>
                                    <?php } ?>
                                    <?php if ($vars["entity"]->isModerator()) { ?>
                                        <h4 class="block text-grey-darker text-xl font-bold">Modérateur</h4>
                                        <span>Nombre de commentaire bloqué: <?= $vars["entity"]->getModerator()->getNbBlockedComment() ?></span><br>
                                        <span>Nombre de commentaire approuvé: <?= $vars["entity"]->getModerator()->getNbApprovedComment() ?></span>
                                    <?php } ?>
                                </div>
                                <button class="w-full bg-indigo-500 text-gray-100 text-xl p-2 rounded mt-5
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
                                ">
                                    Réinitialisation du mot de passe
                                </button>
                            </div>
                        <?php }  ?>
                    </div>

                </form>


            </div>

        </div>
    </div>


</div>

<?php if ($vars["entity"]->getId() != null) {  ?>

    <div class="font-sans antialiased bg-grey-200 mb-5">

        <!-- Content -->
        <div class="bg-grey-lightest">
            <div class="bg-gray-50 rounded shadow pb-5">

                <div class="pt-4 px-8 text-black text-4xl  border-grey-lighter">

                    Ses commandes
                </div>
                <span class="py-4 px-8 text-xs text-grey">Consultation des commandes</span>


                <div class="grid gap-5 grid-cols-3">



                    <div class=" ml-3 rounded-lg mb-5  col-span-2 relative">
                        <div class="flex-1 pr-4 mt-5 mb-5 ml-3">
                            <div class="relative md:w-1/3">
                                <input type="search" class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Search...">
                                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <circle cx="10" cy="10" r="7" />
                                        <line x1="21" y1="21" x2="15" y2="15" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <table class="bg-white  border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead class="h-20">
                                <tr class="">


                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/12 px-2 text-gray-600 font-bold  uppercase"> ID</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/6 text-gray-600 font-bold  "> Utilisateur</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200  w-1/6 text-gray-600 font-bold  "> Montant</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/6  text-gray-600 font-bold "> Nb d'article</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/6 text-gray-600 font-bold "> Date</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200  w-1/6 text-gray-600 font-bold  "> Etat</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($vars['entity']->getOrders() as $order) {
                                    $orderLines = $order->getOrderLines(); ?>
                                    <tr class="order text-center" data-url="<?= $vars['baseUrl'] ?>" data-id="<?= $order->getId(); ?>">

                                        <td class="border-dashed border-t border-gray-200  ">
                                            <span class="text-gray-700 py-3 "> <?= $order->getId() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700 py-3 "><?= $order->getUser()->getFirstName() . ' ' . $order->getUser()->getLastName() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3 "> <?= $order->getPrice()  ?></span>
                                        </td>
                                        <td class="border-dashed border-t text-left border-gray-200 ">
                                            <span class="text-gray-700 py-3 "> <?= $order->getNbArticle() ?> </span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3"><?= $order->getFormatedDate() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 grid pt-3">
                                            <?= $order->getState($order) ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                    <div class="ml-5 mr-5 mt-10">
                        <div class="block flex-grow flex ">
                            <span class="text-xl mr-5">Détails</span>
                            <span id="order-id" class="bg-yellow-200">N°</span>
                        </div>


                        <div id="orderLineDetail" class="h-48 border bg-white">
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>
    <div class="font-sans antialiased bg-grey-200 mb-5">

        <!-- Content -->
        <div class="bg-grey-lightest">
            <div class=" ">
                <div class=" bg-gray-50 rounded shadow pb-5">

                    <div class="pt-4 px-8 text-black text-4xl  border-grey-lighter">

                        Ses commentaires
                    </div>
                    <span class="py-4 px-8 text-xs text-grey">Modération de ces commentaires</span>




                    <div class=" mx-8 rounded-lg mb-5 relative">
                        <table class=" px-4 mb-5 bg-white border-collapse w-full table-auto  whitespace-no-wrap bg-white table-striped relative">
                            <thead class="h-20">
                                <tr class="">


                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/6 text-gray-600 font-bold  "> Titre</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200  w-1/6 text-gray-600 font-bold  "> Recette</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/6  text-gray-600 font-bold "> Contenu</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 w-1/6 text-gray-600 font-bold "> Date</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200  w-1/6 text-gray-600 font-bold  "> Etat</th>
                                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200  w-1/6 text-gray-600 font-bold  "> Actions</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                foreach ($vars['entity']->getComments() as $comment) {

                                ?>
                                    <tr class="text-center" onclick='showDetail(this)'>

                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700 py-3 "><?= $comment->getCommentTitle() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3 "> <?= $comment->getRecipe()->getName()  ?></span>
                                        </td>
                                        <td class="border-dashed border-t text-left border-gray-200 ">
                                            <span class="text-gray-700 py-3 "> <?= $comment->getCommentContent() ?> </span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3"><?= $comment->getFormatedDate() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 pt-3">
                                            <?= $comment->getState($comment) ?>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 grid pt-3">

                                            <div x-data="{ showModal<?= $comment->getIdUsers() ?>: false }" :class="{'overflow-y-hidden': showModal<?= $comment->getIdUsers() ?> }">
                                                <main class="flex flex-col sm:flex-row justify-center items-center">
                                                    <a class="cursor-pointer underline  text-gray-700 p-2 w-32   " @click="showModal<?= $comment->getIdUsers() ?> = true">
                                                        Approuver
                                                    </a>

                                                </main>

                                                <!-- Modal1 -->
                                                <div class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal<?= $comment->getIdUsers() ?>" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                    <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                                        <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal<?= $comment->getIdUsers() ?> = false" x-show="showModal<?= $comment->getIdUsers() ?>" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                                                            <form action="<?= $vars['baseUrl'] ?>user/approuvedComment/<?= $vars['entity']->getId() ?>" method="post">

                                                                <input type="hidden" name="id" value="<?= $comment->getRecipe()->getId() ?>">
                                                                <input type="hidden" name="idModerator" value="<?= UserController::getLoggedInUser()->getId() ?>">

                                                                <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                                    <div class=" w-full   grid  bg-white h-20">

                                                                        <h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment approuver ce commentaire ? </h2>

                                                                    </div>

                                                                </header>
                                                                <main class="  h-20 grid   p-2 text-center">
                                                                    <p class="w-2/3 justify-self-center bg-white rounded-md">
                                                                        Cette action est définitive et irréversible
                                                                    </p>
                                                                </main>
                                                                <footer class="">

                                                                    <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                                        <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal<?= $comment->getIdUsers() ?> = false">
                                                                            <span class="text-lg"> Annuller </span>
                                                                        </button>

                                                                        <div class="bg-green-500 ml-5 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                                                                            <button name="delete" type="submit" value="1" class="text-lg text-center  block lg:inline-block lg:mt-0">
                                                                                Confirmer </button>


                                                                        </div>
                                                                    </div>
                                                                </footer>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div> <br>
                                            <div x-data="{ showModal<?= $comment->getIdUsers() ?>: false }" :class="{'overflow-y-hidden': showModal<?= $comment->getIdUsers() ?> }">
                                                <main class="flex flex-col sm:flex-row justify-center items-center">
                                                    <a class="cursor-pointer underline  text-gray-700 p-2 w-32   " @click="showModal<?= $comment->getIdUsers() ?> = true">
                                                        Bloquer
                                                    </a>

                                                </main>

                                                <!-- Modal1 -->
                                                <div class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal<?= $comment->getIdUsers() ?>" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                    <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                                        <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal<?= $comment->getIdUsers() ?> = false" x-show="showModal<?= $comment->getIdUsers() ?>" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                                                            <form action="<?= $vars['baseUrl'] ?>user/blockedComment/<?= $vars['entity']->getId() ?>" method="post">

                                                                <input type="hidden" name="id" value="<?= $comment->getRecipe()->getId() ?>">
                                                                <input type="hidden" name="idModerator" value="<?= UserController::getLoggedInUser()->getId() ?>">
                                                                <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                                    <div class=" w-full   grid  bg-white h-20">

                                                                        <h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment bloquer ce commentaire ? </h2>

                                                                    </div>

                                                                </header>
                                                                <main class="  h-20 grid   p-2 text-center">
                                                                    <p class="w-2/3 justify-self-center bg-white rounded-md">
                                                                        Cette action est définitive et irréversible
                                                                    </p>
                                                                </main>
                                                                <footer class="">

                                                                    <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                                        <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal<?= $comment->getIdUsers() ?> = false">
                                                                            <span class="text-lg"> Annuller </span>
                                                                        </button>

                                                                        <div class="bg-green-500 ml-5 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                                                                            <button name="delete" type="submit" value="1" class="text-lg text-center  block lg:inline-block lg:mt-0">
                                                                                Confirmer </button>


                                                                        </div>
                                                                    </div>
                                                                </footer>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </td>
                                    </tr>
                                <?php } ?>

                            </tbody>
                        </table>
                    </div>
                </div>







            </div>

        </div>
    </div>


    </div>



<?php } ?>


<script>
    document.addEventListener("DOMContentLoaded", function() {


        let displayStrength = document.querySelector('#strength');
        let progressBar = document.querySelector('#progressBar');
        let barContainer = document.querySelector('#barMain');
        let password = document.querySelector('#password');

        if (password != null) {
            password.addEventListener('keyup', progress);
        }


        function progress() {
            barContainer.classList.remove("hidden");
            console.log(password)
            console.log("in prof " + password.value)
            let strength = parseInt(force(password.value))
            progressBar.style.width = strength + "%";
            if (strength >= 80) {

                progressBar.style.background = "green";
                displayStrength.innerHTML = "Fort";

            } else if (strength >= 60) {
                progressBar.style.background = "#ffbb32";
                displayStrength.innerHTML = "Moyen";
            } else if (strength <= 60) {

                progressBar.style.background = "red";
                displayStrength.innerHTML = "Faible";
            }
            console.log(strength)

            if (password.value.length == 0) {
                progressBar.style.width = "0%";
            }

        }

        function force(value) {

            let digitMessage = document.querySelector('#digit');
            let lowerMessage = document.querySelector('#lower');
            let upperMessage = document.querySelector('#uper');
            let speMessage = document.querySelector('#spe');
            let numbe = document.querySelector('#nomberof');
            var n = 0;
            var regex = /\d/g;
            var regexLower = /[a-z]/;
            var regexUpper = /[A-Z]+/;
            var regexCharSpe = /[!#%_?*$\\]/;
            let allvalideted = true;
            if (value.match(regex)) {
                n += 10;
                itOk(digitMessage)

            } else {
                allvalideted = false;
                notOk(digitMessage)
            }



            if (value.match(regexLower)) {
                n += 26;
                itOk(lowerMessage)
            } else {
                allvalideted = false;
                notOk(lowerMessage)
            }


            if (value.match(regexUpper)) {
                n += 26;
                itOk(upperMessage)
            } else {
                allvalideted = false;
                notOk(upperMessage)
            }

            if (value.match(regexCharSpe)) {
                n += 8;
                itOk(speMessage)
            } else {
                allvalideted = false;
                notOk(speMessage)
            }
            if (value.length >= 10) {
                n += 10;
                itOk(numbe)
            } else {
                n = 10;
                notOk(numbe)
            }
            if (value.length >= 16) {
                n += 10;
            } else {

                allvalideted = false;
            }
            if (allvalideted) {
                n = 100;
            }

            return n;

        }

        function notOk(element) {
            element.style.color = "red";

            element.className += "  fa-times";
            element.classList.remove("fa-check");
        }

        function itOk(element) {
            element.style.color = "green";

            element.className += " fa-check";
            element.classList.remove("fa-times");
        }
    });
</script>
<script src="<?= $vars['baseUrl'] ?>public/js/orders.js"></script>