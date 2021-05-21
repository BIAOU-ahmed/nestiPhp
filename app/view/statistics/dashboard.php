<h1 class="mb-2 mt-4 ml-5">Statistiques</h1>
<div class="w-1/3">
</div>


<div class="flex flex-wrap -mx-1 overflow-hidden sm:-mx-1 md:-mx-1 xl:-mx-3">

    <div class="my-1 px-1 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-1/2 lg:w-1/3 xl:my-3 xl:px-3 xl:w-1/3">
        <!-- Column Content -->
        <h2 class="mb-2 mt-4 ml-5">Commandes</h2>
        <div class=" ml-5" id="chartOrders"></div>
    </div>

    <div class="my-1 px-1 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-1/2 lg:w-1/3 xl:my-3 xl:px-3 xl:w-1/3">
        <!-- Column Content -->
        <div class=" ml-5" id="chartConection"></div>
    </div>

    <div class="my-1 px-1 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-1/2 lg:w-1/3 xl:my-3 xl:px-3 xl:w-1/3">
        <!-- Column Content -->
        <h2 class="mb-2 mt-4 ml-5">Top 10 utilisateurs</h2>
        <div class="h-48 max-h-full border w-1/2">
            <ul>
                <?php foreach ($vars['jsVars']['mostConectedUsers'] as $user) { ?>
                    <li class="flex justify-between">
                        <?= $user->getFirstName() . ' ' . $user->getLastName() ?>
                        <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $user->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt "></i></a>
                    </li>


                <?php } ?>
            </ul>


        </div>
    </div>

</div>
<div class="flex flex-wrap -mx-2 overflow-hidden sm:-mx-1 md:-mx-1 xl:-mx-2">

    <div class="my-2 px-2 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-1/2 lg:w-1/3 xl:my-2 xl:px-2 xl:w-1/2">
        <!-- Column Content -->


        <div class="flex flex-wrap -mx-2 overflow-hidden sm:-mx-1 md:-mx-1 xl:-mx-2">

            <div class="my-2 px-2 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-full lg:w-1/3 xl:my-2 xl:px-2 xl:w-full">
                <!-- Column Content -->
                <h4 class="ml-2 mb-3 ">Plus grosse commandes</h4>
                <div class=" border w-2/3">
                    <ul>
                        <?php foreach ($vars['jsVars']['mostBiggenOrders'] as $order) { ?>
                            <li>
                                Commande n°<?= $order->getId()  ?>
                                <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $order->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt"></i></a>
                            </li>


                        <?php } ?>
                    </ul>


                </div>
            </div>

            <div class="my-2 px-2 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-full lg:w-1/3 xl:my-2 xl:px-2 xl:w-full">
                <!-- Column Content -->
                <h2>Recettes</h2>
                <div class="flex flex-wrap -mx-2 overflow-hidden sm:-mx-1 md:-mx-1 xl:-mx-2">

                    <div class="my-2 px-2 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-full lg:w-1/2 xl:my-2 xl:px-2 xl:w-1/3">
                        <!-- Column Content -->
                        <h4 class="ml-2 mb-3 ">Top 10 chefs</h4>
                        <div class="h-48 max-h-full border">
                            <ul>
                                <?php foreach ($vars['jsVars']['topChefs'] as $chef) { ?>
                                    <li>
                                        <?= $chef->getFirstName() . ' ' . $chef->getLastName() ?>
                                        <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $chef->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt"></i></a>
                                    </li>


                                <?php } ?>
                            </ul>


                        </div>
                    </div>

                    <div class="my-2 px-2 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-full lg:w-1/2 xl:my-2 xl:px-2 xl:w-2/3">
                        <!-- Column Content -->
                        <h4 class="ml-2 mb-3 ">Top 10 recettes</h4>
                        <div class="pb-5 border">
                            <ul>
                                <?php foreach ($vars['jsVars']['topRecipes'] as $recipe) { ?>
                                    <li class="flex justify-between">

                                        <a href="<?= $vars['baseUrl'] ?>recipe/edit/<?= $recipe->getId() ?>" class="ml-3 mr-auto"><?= $recipe->getName() ?></a>
                                        <span> par <?= $recipe->getChef()->getFirstName() . ' ' . $recipe->getChef()->getLastName() ?> </span>
                                    </li>


                                <?php } ?>
                            </ul>


                        </div>
                    </div>

                </div>



            </div>

        </div>



    </div>

    <div class="my-2 px-2 w-full overflow-hidden sm:my-1 sm:px-1 md:my-1 md:px-1 md:w-1/2 lg:w-1/3 xl:my-2 xl:px-2 xl:w-1/2">
        <!-- Column Content -->
        <div class="w-1/2 flex-1">
            <h2 class="text-3xl">Articles</h2>
            <div id="chartArticle"></div>
            <div class="bg-white rounded my-6 ">
                <h3>En rupture de stock</h3>
                <table class="text-left w-1/2 border-collapse mb-5 ">
                    <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
                    <thead>
                        <tr class="tables_head">
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Nom</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Qtx vendus</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Benefice (€)</th>
                            <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($vars['jsVars']['articleOutOfStock'] as $article) { ?>
                            <tr class="hover:bg-grey-lighter">
                                <td class="py-4 px-6 border-b border-grey-light"><?= $article->getFactoryName() ?></td>
                                <td class="py-4 px-6 border-b border-grey-light">
                                    <?= $article->getNbOrdered() ?>
                                </td>
                                <td class="py-4 px-6 border-b border-grey-light">
                                    <?= $article->getBenefit() ?>
                                </td>
                                <td class="py-4 px-6 border-b border-grey-light">
                                    <a href="<?= $vars['baseUrl'] ?>article/edit/<?= $article->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt"></i></a>
                                </td>
                            </tr>


                        <?php } ?>



                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>




<script src="<?= $vars['baseUrl'] ?>public/js/toast.js"></script>
<script src="<?= $vars['baseUrl'] ?>public/js/statsCharts.js"></script>