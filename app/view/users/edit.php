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
                <form class="grid gap-4 grid-cols-2" action="<?= $vars['baseUrl'] ?>user/edit" method="post">


                    <div class="inline-block">
                        <div class="py-4 px-8">
                            <div class="mb-4">
                                <div class=" mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="name">Nom</label>
                                    <input name="Users[lastName]" class="appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="name" type="text" value="<?= $vars['entity']->getLastName(); ?>" placeholder="Your first name">
                                    <?php if (isset($vars["errors"]['firstName']['notEmpty'])) { ?>
                                        <div class="invalid-feedback">Your last name cannot be empty.</div>
                                    <?php } ?>


                                </div>

                            </div>
                            <div class=" mb-4">
                                <div class=" mr-1">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="first_name">Prénom</label>
                                    <input name="Users[firstName]" class="appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="first_name" type="text" value="<?= $vars['entity']->getFirstName(); ?>" placeholder="Your first name">
                                    <?php if (isset($vars["errors"]['firstName']['notEmpty'])) { ?>
                                        <div class="invalid-feedback">Your first name cannot be empty.</div>
                                    <?php } ?>
                                </div>

                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="role">Role</label>
                                <select name="role" class="form-select border border-light-blue-500 border-opacity-0 appearance-none rounded mt-1 block w-full py-2 px-3" id="state">
                                    <option value=""></option>
                                    <option value="admin">Administrateur</option>
                                    <option value="chef">Chef</option>
                                    <option value="mod">Moderateur</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-grey-darker text-sm font-bold mb-2" for="state">Etat</label>

                                <select name="Users[flag]" class="form-select border border-light-blue-500 border-opacity-0 appearance-none rounded mt-1 block w-full py-2 px-3" id="state">
                                    <option value="a">Actif</option>
                                    <option value="w" selected>En attente</option>
                                    <option value="b">Bloqué</option>
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

                                <div class="relative shadow lg:w-1/5 md:w-1/2 text-center">
                                    <a href="<?= $vars['baseUrl'] ?>user/" class="text-lg  p-2  block lg:inline-block lg:mt-0">
                                        <?php if ($vars["entity"]->getId() == null) {  ?>
                                            Anuller
                                        <?php } else { ?>
                                            Supprimer
                                        <?php }  ?>
                                    </a>

                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="inline-block">
                        <?php if ($vars["entity"]->getId() == null) {  ?>
                            <div class="py-4 px-8">

                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="email">Email</label>
                                    <input name="Users[email]" class="appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="email" type="email" placeholder="Your email address">
                                    <?php if (isset($vars["errors"]['email']['email'])) { ?>
                                        <div class="invalid-feedback">Your email must be of type email.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['email']['unique'])) { ?>
                                        <div class="invalid-feedback">Your email may be unique.</div>
                                    <?php } ?>
                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="password">Mot de passe</label>
                                    <input name="passwordHash" class="appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="password" type="password" placeholder="Your secure password">

                                    <?php if (isset($vars["errors"]['passwordHash']['notEmpty'])) { ?>
                                        <div class="invalid-feedback">Your password cannot be empty.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['passwordHash']['strong'])) { ?>
                                        <div class="invalid-feedback">Your password is not strong </div>
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

                                <div id="digit" class="mt-1 ml-5 flex fas">
                                    <i></i> <span class="ml-2">Doit contenir au moin un chiffre </span>
                                </div>
                                <div id="lower" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Doit contenir au moin une lettre miniscule</span>
                                </div>
                                <div id="uper" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Doit contenir au moin une lettre ajuscule</span>
                                </div>
                                <div id="spe" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Doit contenir un des caractere speciaux suivant (!#%_?*$\)</span>
                                </div>
                                <div id="uper" class="mt-1 ml-5 flex fas ">
                                    <span class="ml-2">Ne doit pas contenire d'espace</span>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="py-4  px-8">
                                <span>Informations</span>
                                <div class="border h-5/6"></div>
                                <button>Réinitialisation du mot de passe</button>
                            </div>
                        <?php }  ?>
                    </div>

                </form>


            </div>

        </div>
    </div>


</div>


<div class="font-sans antialiased bg-grey-200">

    <!-- Content -->
    <div class="bg-grey-lightest">
        <div class=" ">
            <div class=" bg-gray-50 rounded shadow">

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

                        <table class="bg-white border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
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
                                    <tr class="text-center" onclick='showDetail(this)'>;

                                        <td class="border-dashed border-t border-gray-200  ">
                                            <span class="text-gray-700 py-3 "> <?= $order->getId() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700 py-3 "><?= $vars['entity']->getFirstName() . ' ' . $vars['entity']->getLastName() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3 "> <?= '$order->getRoles()'  ?></span>
                                        </td>
                                        <td class="border-dashed border-t text-left border-gray-200 ">
                                            <span class="text-gray-700 py-3 "> <?= sizeof($order->getOrderLines()) ?> </span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3"><?= $order->getDateCreation() ?></span>
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
                            <span class="bg-yellow-200">N°</span>
                        </div>


                        <div id="orderLineDetail" class="border h-80 bg-white">
                        </div>
                    </div>

                </div>




            </div>

        </div>
    </div>


</div>


<script>
    let orderDetail = <?= json_encode($vars['orderLines']) ;?>;
    function showDetail(tableRow) {
        let orderId = tableRow.querySelector('td:first-child span').innerHTML;
        console.log(orderDetail)
    }
    document.addEventListener("DOMContentLoaded", function() {


        let displayStrength = document.querySelector('#strength');
        let progressBar = document.querySelector('#progressBar');
        let barContainer = document.querySelector('#barMain');
        let password = document.querySelector('#password');
        console.log(password)

        password.addEventListener('keyup', progress);

        function progress() {
            barContainer.classList.remove("hidden");
            console.log(password)
            console.log("in prof " + password.value)
            let strength = parseInt(force(password.value))
            progressBar.style.width = strength + "%";
            if (strength <= 20) {
                progressBar.style.background = "red";
                displayStrength.innerHTML = "Faible";
            } else if (strength >= 80) {
                progressBar.style.background = "green";
                displayStrength.innerHTML = "Fort";
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
            var n = 0;
            var regex = /\d/g;
            var regexLower = /[a-z]/;
            var regexUpper = /[A-Z]+/;
            var regexCharSpe = /[!#%_?*$\\]/;

            if (value.match(regex)) {
                n += 10;
                console.log("in dig");
                itOk(digitMessage)

            } else {
                notOk(digitMessage)
            }



            if (value.match(regexLower)) {
                n += 26;
                console.log("in low");
                itOk(lowerMessage)
            } else {
                notOk(lowerMessage)
            }


            if (value.match(regexUpper)) {
                n += 26;
                itOk(upperMessage)
            } else {
                notOk(upperMessage)
            }

            if (value.match(regexCharSpe)) {
                n += 8;
                itOk(speMessage)
            } else {
                notOk(speMessage)
            }
            return Math.round(value.length * Math.log2(n));
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