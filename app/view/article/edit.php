<?php
$img = 'gateauauxfraises.jpg';
if ($vars['entity']->getImage()) {
    $img = $vars['entity']->getImage()->getName() . '.' . $vars['entity']->getImage()->getFileExtension();
}



?>

<div class="bg-grey-lightest">
    <div class=" pt-8">
        <div class=" bg-white rounded shadow">
            <div class="ml-1"><a href="">Articles </a>> Article</div>
            <?php if ($vars['entity']->getId()) { ?>
                <div class=" grid lg:gap-10 md:gap-5 grid-cols-2">
                    <form class="" action="<?= $vars['baseUrl'] ?>article/edit/<?= $vars["entity"]->getId() ?>" method="post">


                        <div class="inline-block">
                            <div class="py-4 px-8 text-black lg:text-4xl md:text-3xl  border-grey-lighter">

                                <?php if ($vars["entity"]->getId() == null) {  ?>
                                    Création d'une Recette

                                <?php } else {
                                ?>

                                    Edition d'article
                                <?php }  ?>
                            </div>
                            <div class="py-4 px-8">
                                <div class=" mb-4">
                                    <div class=" mr-1">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">Nom d'usine de l'article'</label>
                                        <span class="appearance-none border rounded inline-block w-full py-2 px-3 text-grey-darker" id="name"> <?= $vars['entity']->getFactoryName() ?> </span>

                                    </div>
                                </div>
                                <div class=" mb-4">
                                    <div class=" mb-4">
                                        <div class=" mr-1">
                                            <label class=" text-grey-darker text-sm font-bold mb-2" for="difficulty">Nom de l'article pour l'utilisateur</label>
                                            <input name="Article[name]" class=" text-center  appearance-none border rounded w-full py-2 px-3 text-grey-darker" id="difficulty" type="text" value="<?= $vars['entity']->getName() ?>">

                                        </div>
                                    </div>

                                </div>
                                <div class=" mb-4">
                                    <div class=" mr-1  flex justify-between">
                                        <div class="inline-block">
                                            <label class="block text-grey-darker text-sm font-bold mb-2" for="portions">Identifiant</label>
                                        </div>
                                        <div class="inline-block w-2/6">
                                            <input name="Article[idArticle]" readonly class=" text-center appearance-none border rounded inline-block w-full py-2 px-3 text-grey-darker" value="<?= $vars['entity']->getId() ?>" id="portions"> </input>
                                        </div>

                                    </div>

                                </div>
                                <div class=" mb-4">
                                    <div class=" mr-1  flex justify-between">
                                        <div class="inline-block  w-3/6">
                                            <label class="block text-grey-darker text-sm font-bold mb-2" for="preparationTime">Prix de vente</label>

                                        </div>
                                        <div class="inline-block w-2/6">
                                            <span name="Article[preparationTime]" class=" text-center appearance-none border rounded inline-block w-full py-2 px-3 text-grey-darker" id="last_price"> <?= $vars['entity']->getLastPrice() ?> </span>
                                        </div>

                                    </div>


                                </div>

                                <div class=" mb-4">
                                    <div class=" mr-1  flex justify-between">
                                        <div class="inline-block  w-3/6">
                                            <label class="block text-grey-darker text-sm font-bold mb-2" for="preparationTime">Stock</label>

                                        </div>
                                        <div class="inline-block w-2/6">
                                            <span name="Article[preparationTime]" class=" text-center appearance-none border rounded inline-block w-full py-2 px-3 text-grey-darker" id="last_price"> <?= $vars['entity']->getInventory() ?> </span>
                                        </div>

                                    </div>


                                </div>
                                <div class="mb-4">
                                    <label class="block text-grey-darker text-sm font-bold mb-2" for="state">Etat</label>

                                    <select name="Article[flag]" class="form-select border border-light-blue-500 border-opacity-0 appearance-none rounded mt-1 block w-full py-2 px-3" id="state">
                                        <option value="a" <?= $vars['entity']->getFlag() == 'a' ? 'selected' : ''; ?>>Actif
                                        </option>
                                        <option value="w" <?= $vars['entity']->getFlag() == 'w' || $vars['entity']->getId() == null ? 'selected' : ''; ?>>
                                            En attente</option>
                                        <option value="b" <?= $vars['entity']->getFlag() == 'b' ? 'selected' : ''; ?>>Bloqué
                                        </option>
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
                                    <input type="reset" value="Annuler" class="cursor-pointer bg-white text-lg  p-2  block lg:inline-block lg:mt-0 relative shadow lg:w-1/5 md:w-1/2 text-center">

                                </div>
                            </div>

                        </div>
                    </form>
                    <!-- <form action=""> -->

                    <div class="inline-block h-full">

                        <div class="py-4 px-8 h-full">

                            <form method="post" class="mb-4 h-full" id="recipeImg" action="<?= $vars['baseUrl'] ?>article/addImage">
                                <div>
                                    <img id="image" class="h-80 rounded lg:w-4/5 md:w-full recipe-img  mb-5 bg-gray-300" src="<?= $vars['baseUrl'] ?>public/images/articles/<?= $img ?>" alt="">
                                    <input type="hidden" value="<?= $vars['entity']->getId() ?>" name="idArticle">
                                </div>
                                <div class="lg:w-4/5 flex justify-between">
                                    <label id="img-url" class="self-center" for=""> <?= $img ?> </label>
                                    <div x-data="{ showModal: false }" :class="{'overflow-y-hidden': showModal }">
                                        <main class="">
                                            <button type="button" @click="showModal = true" class="block"><i class="rounded text-center pt-1 text-3xl h-10 w-10 bg-red-600 border text-white block fas fa-trash-alt my-2"></i></button>

                                        </main>

                                        <!-- Modal1 -->
                                        <div class="fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                            <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                                <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal = false" x-show="showModal" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">

                                                    <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                        <div class=" w-full   grid  bg-white h-20">

                                                            <h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment supprimer l'image ?</h2>

                                                        </div>

                                                    </header>
                                                    <main class="  h-20 grid   p-2 text-center">
                                                        <p class="w-2/3 justify-self-center bg-white rounded-md">
                                                        Vous avez toujours la possibilité d'ajouter un autre a tout moment.
                                                        </p>
                                                    </main>
                                                    <footer class="">

                                                        <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                            <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal = false">
                                                                <span class="text-lg"> Annuller </span>
                                                            </button>

                                                            <div @click="showModal = false" class="bg-green-500 ml-5 text-white active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease">
                                                                <button name="delete" id="deleteImg" data-idarticle="<?= $vars['entity']->getId() ?>" value="1" class="text-lg text-center  block lg:inline-block lg:mt-0">
                                                                    Confirmer </button>


                                                            </div>
                                                        </div>
                                                    </footer>



                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <label>Télécharger une nouvelle image</label>
                                <div class="lg:w-4/5 flex justify-between">
                                    <input name="image_link" class=" w-4/5 appearance-none border rounded py-2 px-3 text-grey-darker" id="image_link" type="file">

                                    <input type="submit" data-id="<?= $vars['entity']->getId() ?>" data-url="<?= $vars['baseUrl'] ?>" id="add-image" value="OK" class="cursor-pointer w-1/6 h-full bg-indigo-500 text-gray-100 p-2 rounded">

                                    <!-- Ok -->
                                    <!-- </input> -->
                                </div>

                            </form>

                        </div>

                    </div>

                    <!-- </form> -->


                </div>
            <?php } else { ?>
                <div class=" grid lg:gap-10 md:gap-5 grid-cols-2">

                    <form class="" action="<?= $vars['baseUrl'] ?>article/edit" method="post" enctype="multipart/form-data">


                        <div class="w-full inline-block">
                            <div class="py-4 px-8 text-black lg:text-4xl md:text-3xl  border-grey-lighter">

                                Importation
                            </div>
                            <div class="w-full py-4 px-8">
                                <div class=" mb-4">
                                    <div class=" mr-1">
                                        <label class="block text-grey-darker text-sm font-bold mb-2" for="name">Téléverser un fichier .CSV</label>
                                        <input class="appearance-none border rounded inline-block w-full py-2 px-3 text-grey-darker" id="name" name="csvfile" type="file">
                                        <?php if (@$vars['message'] == 'error') { ?>
                                            <span class="">
                                                Déconnexion réussi
                                            </span>
                                        <?php } ?>
                                    </div>
                                </div>

                                <div class="  grid">
                                    <div class="relative lg:w-1/2 md:w-1/2 shadow justify-self-end">

                                        <button class="w-full h-full bg-indigo-500 text-gray-100 p-2 rounded 
                                    font-semibold font-display focus:outline-none focus:shadow-outline  hover:bg-indigo-600
                                    ">
                                            Importer
                                        </button>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    <!-- <form action=""> -->

                    <div class="py-4  px-8">
                        <span>Liste des articles importés</span>
                        <div class="border h-5/6">


                            <ul>
                                <?php
                                if (isset($vars['imported'])) {
                                    foreach ($vars['imported'] as $key => $value) {
                                ?>
                                        <li class="flex justify-between">
                                            <span><?= $value['name'] ?></span>
                                            <span><?= $value['amount'] ?></span>
                                            <a href="<?= $vars['baseUrl'] ?>article/edit/<?= $value['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                                        </li>
                                <?php
                                    }
                                    // FormatUtil::dump($vars['imported']);
                                }

                                ?>

                            </ul>

                        </div>
                    </div>

                    <!-- </form> -->


                </div>

            <?php } ?>




        </div>

    </div>
</div>

<script src="<?= $vars['baseUrl'] ?>public/js/image.js"></script>