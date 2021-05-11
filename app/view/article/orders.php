<div class="font-sans antialiased bg-grey-200 mb-5">

    <!-- Content -->
    <div class="bg-grey-lightest">
        <div class=" ">
            <div class=" bg-gray-50 rounded shadow pb-5">
                <div class="ml-1"><a href="<?=$vars['baseUrl']?>article/list">Article </a>> Commandes</div>
                <div class="pt-4 px-8 text-black text-4xl  border-grey-lighter">

                    Commandes
                </div>
                <span class="py-4 px-8 text-xs text-grey">Consultation des commandes</span>


                <div class="grid gap-5 grid-cols-3">



                    <div class=" ml-3 rounded-lg mb-5  col-span-2 relative">
                        <div class="flex-1 pr-4 mt-5 mb-5 ml-3">
                            <div class="relative md:w-1/3">
                                <input id="search" type="search" class="w-full pl-10 pr-4 py-2 rounded-lg shadow focus:outline-none focus:shadow-outline text-gray-600 font-medium" placeholder="Search...">
                                <div class="absolute top-0 left-0 inline-flex items-center p-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-400" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="0" y="0" width="24" height="24" stroke="none"></rect>
                                        <circle cx="10" cy="10" r="7" />
                                        <line x1="21" y1="21" x2="15" y2="15" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <table id="myTable" class="hover border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                            <thead class="h-20 tables_hesad">
                                <tr class="tables_head">


                                    <th class="sticky top-0 border-b border-gray-200 w-1/12 px-2 text-white font-bold  uppercase"> ID</th>
                                    <th class="sticky top-0 border-b border-gray-200 w-1/6 text-white font-bold  "> Utilisateur</th>
                                    <th class="sticky top-0 border-b border-gray-200  w-1/6 text-white font-bold  "> Montant</th>
                                    <th class="sticky top-0 border-b border-gray-200 w-1/6  text-white font-bold "> Nb d'article</th>
                                    <th class="sticky top-0 border-b border-gray-200 w-1/6 text-white font-bold "> Date</th>
                                    <th class="sticky top-0 border-b border-gray-200  w-1/6 text-white font-bold  "> Etat</th>

                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach ($vars['entities'] as $order) {
                                    $orderLines = $order->getOrderLines(); ?>
                                    <tr class="order text-center cursor-pointer " data-url="<?= $vars['baseUrl'] ?>" data-id="<?= $order->getId(); ?>">

                                        <td class="border-dashed border-t border-gray-200  ">
                                            <span class="text-gray-700 py-3 "> <?= $order->getId() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700 py-3 "><?= $order->getUser()->getFirstName() . ' ' . $order->getUser()->getLastName() ?></span>
                                        </td>
                                        <td class="border-dashed border-t border-gray-200 ">
                                            <span class="text-gray-700  py-3 "> <?= $order->getPrice().' €'  ?></span>
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


</div>

<script src="<?= $vars['baseUrl'] ?>public/js/orders.js"></script>