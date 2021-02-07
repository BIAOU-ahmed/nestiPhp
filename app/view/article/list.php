



<div class="antialiased sans-serif">


<!-- <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script> -->


<div class="container mx-auto py-6 px-4" x-data="datatables()">
    <h1 class="text-4xl py-4 border-b mb-10">Articles</h1>



    <div class="mb-4 flex justify-between items-center">
        <div class="flex-1 pr-4">
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
        <div>
            <div class=" rounded flex">
                <div class="order-link relative mr-5 shadow ">
                    <a href="<?=$vars['baseUrl']?>recipe/edit" class="text-lg text-center p-2  block lg:inline-block lg:mt-0">
                    <i class="fas fa-plus-circle text-green-800"></i>  Commandes
                    </a>
                    
                </div>
                <div class="relative shadow">
                    <a href="<?=$vars['baseUrl']?>recipe/edit" class="text-lg text-center p-2  block lg:inline-block lg:mt-0">
                    <i class="fas fa-plus-circle text-green-800"></i> Ajouter
                    </a>
                  
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow  relative">
        <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
            <thead class="h-20">
                <tr class="text-center">


                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold  uppercase text-lg"> ID</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold   text-xs"> Nom</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold   text-xs"> Prix de vente</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold   text-xs"> Type</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold   text-xs"> Derniere Importation</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold   text-xs"> stock</th>
                    <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold   text-xs"> Actions</th>

                </tr>
            </thead>
            <tbody>

                <?php foreach ($vars['entities'] as $article) { ?>
                    <tr class="text-center">

                        <td class="border-dashed border-t border-gray-200 ">
                            <span class="text-gray-700 px-6 py-3 "> <?= $article->getId() ?></span>
                        </td>
                        <td class="border-dashed border-t border-gray-200 ">
                            <span class="text-gray-700 px-6 py-3 "><?= $article->getProduct()->getName() ?></span>
                        </td>
                        <td class="border-dashed border-t border-gray-200 ">
                            <span class="text-gray-700 px-6 py-3 "> <?= $article->getLastPrice() ?></span>
                        </td>
                        <td class="border-dashed border-t border-gray-200 ">
                            <span class="text-gray-700 px-6 py-3 "> <?= 'Ingredient' ?> </span>
                        </td>
                        <td class="border-dashed border-t border-gray-200 ">
                            <span class="text-gray-700 px-6 py-3 "><?= '12-01-2021' ?></span>
                        </td>
                        <td class="border-dashed border-t border-gray-200 ">
                            <span class="text-gray-700 px-6 py-3 "><?= '120' ?></span>
                        </td>
                        <td class="border-dashed border-t border-gray-200 text-center pt-3">
                            <span class="text-gray-700  ">
                                <a href="" class="underline ">Modifier</a>
                            </span><br>
                            <span class="text-gray-700  ">

                                <a href="" class="underline ">Supprimer</a>
                            </span>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>


</div>