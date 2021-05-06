<?php
$chef = "";
if ($vars["entity"]->getId() == null && UserController::getLoggedInUser()->isChef()) {
    $chef =  UserController::getLoggedInUser()->getFirstName() . ' ' . UserController::getLoggedInUser()->getLastName();
} elseif ($vars["entity"]->getId() != null) {
    $chef =  $vars["entity"]->getChef()->getFirstName() . ' ' . $vars["entity"]->getChef()->getLastName();
}
$img = 'gateauauxfraises.jpg';
if ($vars['entity']->getImage()) {
    $img = $vars['entity']->getImage()->getName() . '.' . $vars['entity']->getImage()->getFileExtension();
}

?>

<div class="font-sans antialiased bg-grey-lightest">

    <!-- Content -->
    <div class="bg-grey-lightest">
        <div class=" pt-8">
            <div class=" bg-white rounded shadow">
                <div class="ml-1"><a href="">Recettes </a>> Recette</div>
                <div class=" grid lg:gap-10 md:gap-5 grid-cols-2">
                    <form class="" action="<?= $vars['baseUrl'] ?>recipe/edit/<?= $vars["entity"]->getId() ?>" method="post">


                        <div class="inline-block">
                            <div class="py-4 px-8 text-black lg:text-4xl md:text-3xl  border-grey-lighter">

                                <?php if ($vars["entity"]->getId() == null) {  ?>
                                    Création d'une Recette

                                <?php } else { ?>
                                    Edition de Recette
                                <?php }  ?>
                            </div>
                            <div class="py-4 px-8">
                                <div class="mb-4">
                                    <div class=" mr-1">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">Nom de la recette</label>
                                        <input name="Recipe[name]" class="<?= isset($vars["errors"]['name']) ? 'border-red-600' : '' ?> appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="name" type="text" value="<?= $vars['entity']->getName() ?>" placeholder="Le nom de la recette">
                                        <div class="">Auteur de la recette: <?= $chef ?>.</div>

                                        <?php if (isset($vars["errors"]['name']['notEmpty'])) { ?>
                                            <div class="invalid-feedback text-red-600">Le nom de la recette est obligatoire.</div>
                                        <?php } ?>


                                    </div>

                                </div>
                                <div class=" mb-4">
                                    <div class=" mr-1 flex justify-between">
                                        <div class="inline-block">
                                            <label class=" text-grey-darker text-sm font-bold mb-2" for="difficulty">Difficulté(note sur 5)</label>

                                        </div>

                                        <div class="inline-block w-2/6">
                                            <input name="Recipe[difficulty]" class="<?= isset($vars["errors"]['difficulty']) ? 'border-red-600' : '' ?> text-center  appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="difficulty" type="number" value="<?= $vars['entity']->getDifficulty() ?>">
                                        </div>

                                    </div>
                                    <?php if (isset($vars["errors"]['difficulty']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">La difficulter est obligatoire.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['difficulty']['uciqueNumber'])) { ?>
                                        <div class="invalid-feedback text-red-600">La difficulter doit etre un nombre entre [0-5].</div>
                                    <?php } ?>

                                </div>
                                <div class=" mb-4">
                                    <div class=" mr-1  flex justify-between">
                                        <div class="inline-block">
                                            <label class="block text-grey-darker text-sm font-bold mb-2" for="portions">Nombre de personnes</label>
                                        </div>
                                        <div class="inline-block w-2/6">
                                            <input name="Recipe[portions]" class="<?= isset($vars["errors"]['portions']) ? 'border-red-600' : '' ?> text-center appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="portions" type="number" value="<?= $vars['entity']->getPortions() ?>">
                                        </div>

                                    </div>
                                    <?php if (isset($vars["errors"]['portions']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le nombre de personne est ogligatoire.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['portions']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le nombre de personnes doit etre un nombre.</div>
                                    <?php } ?>

                                </div>
                                <div class=" mb-4">
                                    <div class=" mr-1  flex justify-between">
                                        <div class="inline-block  w-3/6">
                                            <label class="block text-grey-darker text-sm font-bold mb-2" for="preparationTime">Temps de préparation en minutes</label>

                                        </div>
                                        <div class="inline-block w-2/6">
                                            <input name="Recipe[preparationTime]" class="<?= isset($vars["errors"]['preparationTime']) ? 'border-red-600' : '' ?> text-center appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="preparationTime" type="number" value="<?= $vars['entity']->getPreparationTime() ?>">
                                        </div>

                                    </div>
                                    <?php if (isset($vars["errors"]['preparationTime']['notEmpty'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le temps de preparation est necessaire.</div>
                                    <?php } ?>
                                    <?php if (isset($vars["errors"]['preparationTime']['numeric'])) { ?>
                                        <div class="invalid-feedback text-red-600">Le temps doit etre un nombre.</div>
                                    <?php } ?>

                                </div>


                                <?php
                                if ($vars['entity']->getId() == '' || $vars['loggedInUser']->getId() == $vars['entity']->getChef()->getId() || $vars['loggedInUser']->isAdministrator()) { ?>
                                    <div class="  flex">
                                        <div class="relative mr-5 lg:w-1/6 md:w-1/2 shadow">

                                            <button class="w-full h-full bg-indigo-500 text-gray-100 p-2 rounded 
            font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
            ">
                                                Valider
                                            </button>

                                        </div>

                                        <input type="reset" value="Annuler" class="cursor-pointer bg-white text-lg  p-2  block lg:inline-block lg:mt-0 relative shadow lg:w-1/5 md:w-1/2 text-center">
                                    </div>
                                <?php }
                                ?>
                            </div>

                        </div>
                    </form>
                    <!-- <form action=""> -->

                    <div class="inline-block h-full">

                        <div class="py-4 px-8 h-full">

                            <form method="post" class="mb-4 h-full" id="recipeImg" action="<?= $vars['baseUrl'] ?>recipe/addImage">
                                <div>
                                    <img id="image" class="h-80 rounded lg:w-4/5 md:w-full recipe-img  mb-5 bg-gray-300" src="<?= $vars['baseUrl'] ?>public/images/recipes/<?= $img ?>" alt="">
                                    <input type="hidden" value="<?= $vars['entity']->getId() ?>" name="idRecipe">
                                </div>
                                <?php if ($vars['entity']->getId()) { ?>
                                    <div class="lg:w-4/5 flex justify-between">
                                        <label id="img-url" class="self-center" for=""> <?= $img ?> </label>
                                        <div x-data="{ showModal: false }" :class="{'overflow-y-hidden': showModal }">
                                            <main class="">
                                                <?php
                                                if ($vars['loggedInUser']->getId() == $vars['entity']->getChef()->getId() || $vars['loggedInUser']->isAdministrator()) { ?>
                                                    <button type="button" @click="showModal = true" class="block"><i class="rounded text-center pt-1 text-3xl h-10 w-10 bg-red-600 border text-white block fas fa-trash-alt my-2"></i></button>
                                                <?php } ?>
                                            </main>

                                            <!-- Modal1 -->
                                            <div class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                                    <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal = false" x-show="showModal" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">

                                                        <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                            <div class=" w-full   grid  bg-white h-20">

                                                                <h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment supprimer l'element: ?</h2>

                                                            </div>

                                                        </header>
                                                        <main class="  h-20 grid   p-2 text-center">
                                                            <p class="w-2/3 justify-self-center bg-white rounded-md">
                                                                Cette action est définitive et irréversible
                                                            </p>
                                                        </main>
                                                        <footer class="">

                                                            <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                                <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal = false">
                                                                    <span class="text-lg"> Annuller </span>
                                                                </button>

                                                                <div @click="showModal = false" class="bg-green-500 ml-5 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                                                                    <button name="delete" id="deleteImg" data-idrecipe="<?= $vars['entity']->getId() ?>" value="1" class="text-lg text-center  block lg:inline-block lg:mt-0">
                                                                        Confirmer </button>


                                                                </div>
                                                            </div>
                                                        </footer>



                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                <?php } ?>
                                <label>Télécharger une nouvelle image</label>
                                <div class="lg:w-4/5 flex justify-between">
                                    <input name="image_link" class=" w-4/5 appearance-none border rounded py-2 px-3 text-grey-darker" id="image_link" type="file">
                                    <?php if ($vars['entity']->getId() == '' || $vars['loggedInUser']->getId() == $vars['entity']->getChef()->getId() || $vars['loggedInUser']->isAdministrator()) { ?>
                                        <input type="submit" data-id="<?= $vars['entity']->getId() ?>" data-url="<?= $vars['baseUrl'] ?>" id="add-image" value="OK" class="cursor-pointer w-1/6 h-full bg-indigo-500 text-gray-100 p-2 rounded">
                                    <?php } ?>
                                    <!-- Ok -->
                                    <!-- </input> -->
                                </div>

                            </form>

                        </div>

                    </div>

                    <!-- </form> -->


                </div>





            </div>

        </div>
    </div>


</div>
<div class="font-sans antialiased bg-grey-lightest mb-5">

    <!-- Content -->
    <div class="bg-grey-lightest">
        <div class=" pt-8">
            <div class=" bg-white rounded shadow">


                <div class="grid lg:gap-10 md:gap-1 lg:grid-cols-3 md:grid-cols-5 ">


                    <div class="inline-block lg:col-span-2 md:col-span-3">
                        <div class="py-4 px-8  text-black lg:text-4xl md:text-3xl  border-grey-lighter">


                            Préparations


                        </div>
                        <div class="py-4 lg:px-8 md:px-4">
                            <div id="paragraph-container" class="mb-4">
                                <div class="flex mr-1 ">
                                    <div class="inline-block h-full self-center mr-3">
                                        <button class="block"> <i class="text-center bg-yellow-500 text-white pt-1 text-3xl h-10 w-10 border block fas fa-arrow-up my-2"></i></button>
                                        <button class="block"> <i class="text-center bg-yellow-400 text-white pt-1 text-3xl h-10 w-10 border block fas fa-arrow-down my-2"></i></button>

                                        <!-- <button class="block"><i class="rounded text-center pt-1 text-3xl h-10 w-10 bg-red-600 border text-white block fas fa-trash-alt my-2"></i></button> -->


                                        <div x-data="{ showModal: false }" :class="{'overflow-y-hidden': showModal }">
                                            <main class="flex flex-col sm:flex-row justify-center items-center">

                                                <button @click="showModal = true" class="block"><i class="rounded text-center pt-1 text-3xl h-10 w-10 bg-red-600 border text-white block fas fa-trash-alt my-2"></i></button>

                                            </main>

                                            <!-- Modal1 -->
                                            <div class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                                <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                                    <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal = false" x-show="showModal" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                                                        <form action="<?= $vars['baseUrl'] ?>user/delete/" method="post">


                                                            <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                                <div class=" w-full   grid  bg-white h-20">

                                                                    <h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment supprimer l'element: ?</h2>

                                                                </div>

                                                            </header>
                                                            <main class="  h-20 grid   p-2 text-center">
                                                                <p class="w-2/3 justify-self-center bg-white rounded-md">
                                                                    Cette action est définitive et irréversible
                                                                </p>
                                                            </main>
                                                            <footer class="">

                                                                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                                    <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal = false">
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
                                    </div>
                                    <div class="inline-block w-full">
                                        <textarea readonly class="resize-none w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="5"></textarea>
                                    </div>

                                </div>

                            </div>


                            <div x-data="{ showModal: false }" :class="{'overflow-y-hidden': showModal } ">
                                <main class="flex w-full flex-col sm:flex-row justify-center items-center">

                                    <div class="w-full ml-15 h-20 mt-5 flex justify-end">
                                        <?php if ($vars['entity']->getId() == '' || $vars['loggedInUser']->getId() == $vars['entity']->getChef()->getId() || $vars['loggedInUser']->isAdministrator()) { ?>

                                            <button id="addprep" class="justify-self-end rounded-lg w-11/12 border h-full" @click="showModal = true"><i class="text-4xl fas fa-plus"></i></button>
                                        <?php } ?>
                                    </div>
                                </main>

                                <!-- Modal1 -->
                                <div id="modal" class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                    <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                        <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal= false" x-show="showModal" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                                            <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                <div class=" w-full   grid  bg-white h-20">

                                                    <h2 class=" font-semibold text-center justify-self-center self-center "> Veilleez entrer le contenu du paragraph</h2>

                                                </div>

                                            </header>
                                            <main class=" grid   p-2 text-center">
                                                <div class="inline-block w-full">
                                                    <textarea id="preparationsContent" class="resize-none  w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" rows="5"></textarea>
                                                </div>
                                            </main>
                                            <footer class="">

                                                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                    <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal = false">
                                                        <span class="text-lg"> Annuler </span>
                                                    </button>

                                                    <div class="bg-green-500 ml-5 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" @click="showModal = false" style="transition: all .15s ease">
                                                        <button id="add-preparation" data-id="<?= $vars['entity']->getId() ?>" data-url="<?= $vars['baseUrl'] ?>" class="text-lg text-center  block lg:inline-block lg:mt-0">
                                                            Confirmer
                                                        </button>

                                                    </div>
                                                </div>
                                            </footer>
                                        </div>
                                    </div>
                                </div>


                            </div>

                        </div>

                    </div>
                    <div class="inline-block h-full lg:col-span-1 md:col-span-2">

                        <div class="py-4 lg:px-8 md:px-3 h-full">

                            <div class="mb-4 h-full">
                                <h2>Liste des ingredients</h2>
                                <div class="inline-block  w-full">
                                    <div class="resize-none min-h-full w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none pb-5">

                                        <ul id="ingredient-list" data-cantDelete="<?= ($vars['entity']->getId() == '' || $vars['loggedInUser']->getId() == $vars['entity']->getChef()->getId() || $vars['loggedInUser']->isAdministrator()) ? 'true' : 'false' ?>">
                                            <!-- <div class="flex lg:justify-between mb-2">
                                                <li >3 litre de poire </li>
                                                <button data-id="" data-url="" id="add-ingredient" class="md:ml-2 md:w-1/6 lg:w-1/12 bg-indigo-500 text-gray-100  rounded">
                                                    X
                                                </button>
                                            </div>
                                            <div class="flex lg:justify-between">
                                                <li class="flex lg:justify-between">3 litre de poire </li>
                                                <button data-id="" data-url="" id="add-ingredient" class="md:ml-2 md:w-1/6 lg:w-1/12 bg-indigo-500 text-gray-100  rounded">
                                                    X
                                                </button>
                                            </div> -->
                                        </ul>
                                    </div>
                                </div>
                                <span>Ajouter un ingredient</span>
                                <div class="inline-block w-full mb-5 mt-3">
                                    <input list="ingredient_list" class="resize-none h-80 w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none" id="ingredient" type="text"></input>
                                    <datalist id="ingredient_list">
                                        <?php foreach ($vars['entity']->getAllIngredient() as $ingredient) {
                                            if ($ingredient->isIngredient()) {
                                        ?>
                                                <option value="<?= $ingredient->getName() ?>">
                                            <?php }
                                        } ?>
                                    </datalist>
                                </div>
                                <div class="w-full flex justify-between">
                                    <input name="" class=" w-1/3 appearance-none border rounded py-2 px-3 text-grey-darker" id="quantity" type="number">
                                    <input list="unit_list" name="" class=" w-1/3 appearance-none border rounded py-2 px-3 text-grey-darker" id="unit" type="text">
                                    <datalist id="unit_list">
                                        <?php foreach ($vars['entity']->getAllUnit() as $unit) {

                                        ?>
                                            <option value="<?= $unit->getName() ?>">
                                            <?php } ?>
                                    </datalist>
                                    <input data-id="<?= $vars['entity']->getId() ?>" data-url="<?= $vars['baseUrl'] ?>" id="add-ingredient" type="hidden" name="">
                                    <?php if ($vars['entity']->getId() == '' || $vars['loggedInUser']->getId() == $vars['entity']->getChef()->getId() || $vars['loggedInUser']->isAdministrator()) { ?>

                                        <button id="add_ingredient" class=" lg:w-1/6 md:1/3 h-full bg-indigo-500 text-gray-100 p-2 rounded">
                                            Ok

                                        </button>
                                    <?php } ?>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


            </div>

        </div>
    </div>


</div>
<script src="<?= $vars['baseUrl'] ?>public/js/recipe.js"></script>
<script src="<?= $vars['baseUrl'] ?>public/js/image.js"></script>
<script>

</script>