<h1 class="mb-2 mt-4 ml-5">Statistiques</h1>

<div class="flex space-x-4 ...">
    <div class="flex-1 ...">
        <h2 class="mb-2 mt-4 ml-5">Commandes</h2>
        <div class=" ml-5" id="chartOrders"></div>
    </div>
    <div class="flex-1 ...">
        <div class=" ml-5" id="chartConection"></div>
    </div>
    <div class="flex-1 ...">
        <h2 class="mb-2 mt-4 ml-5">Top 10 utilisateurs</h2>
        <div class="h-48 max-h-full border">
            <ul>
                <?php foreach ($vars['jsVars']['mostConectedUsers'] as $user) { ?>
                    <li>
                        <?= $user->getFirstName() . ' ' . $user->getLastName() ?>
                        <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $user->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt"></i></a>
                    </li>


                <?php } ?>
            </ul>


        </div>
    </div>
</div>

<div class="h-48 max-h-full border">
    <ul>
        <?php foreach ($vars['jsVars']['mostBiggenOrders'] as $order) { ?>
            <li>
                Commande n°<?= $order->getId()  ?>
                <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $order->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt"></i></a>
            </li>


        <?php } ?>
    </ul>


</div>

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

<div class="h-48 max-h-full border">
    <ul>
        <?php foreach ($vars['jsVars']['topRecipes'] as $recipe) { ?>
            <li>

                <a href="<?= $vars['baseUrl'] ?>recipe/edit/<?= $recipe->getId() ?>" class="ml-3 "><?= $recipe->getName() ?></i></a>
                par <?= $recipe->getChef()->getFirstName() . ' ' . $recipe->getChef()->getLastName() . ' note ' . $recipe->getRate() ?>
            </li>


        <?php } ?>
    </ul>


</div>

<div class="bg-white shadow-md rounded my-6 ">
    <table class="text-left w-1/2 border-collapse mb-5 ">
        <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
        <thead>
            <tr>
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
                    <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $article->getId() ?>" class="ml-3 "><i class="fas fa-pencil-alt"></i></a>
                    </td>
                </tr>


            <?php } ?>



        </tbody>
    </table>
</div>

<div id="chartArticle"></div>

<script src="<?= $vars['baseUrl'] ?>public/js/toast.js"></script>
<script src="<?= $vars['baseUrl'] ?>public/js/statsCharts.js"></script>