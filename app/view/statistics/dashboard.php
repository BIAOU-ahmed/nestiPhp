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

<script src="<?= $vars['baseUrl'] ?>public/js/toast.js"></script>
<script src="<?= $vars['baseUrl'] ?>public/js/statsCharts.js"></script>