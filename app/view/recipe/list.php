<?php
// require_once $vars['templatesPath'] . 'common/navigation.php'; ?>
<!-- <div class="row-fluid">
    <div class="col">
        <table class="table table-responsive-sm table-striped table-bordered">
            <thead class="thead-dark">
                <th>ID</th>
                <th>Nom</th>
                <th>Difficulté</th>
                <th>Pour</th>
                <th>Temps</th>
                <th>Chef</th>
                <th>Actions</th>
            </thead>
            <tbody>
                <?php foreach ($vars['entities'] as $recipe) { ?>
                    <tr>
                        <td>{{user.firstName}}</td>
                        <td>{{user.lastName}}</td>
                        <td>{{user.birthDate}}</td>
                        <td>{{user.tel}}</td>
                        <td>{{user.country}}</td>
                        <td>{{user.email}}</td>
                        <td class='table-success'><a class='btn' href='{{ baseUrl }}read/{{user.id}}'>Read</a>
                            <a class='btn' href='{{ baseUrl }}edit/{{user.id}}'>Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <a href="{{ baseUrl }}edit" class="btn btn-success mb-2">Add User</a>
    </div>
</div> -->


<div class="antialiased sans-serif h-screen">


    <!-- <link rel="stylesheet" href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css">
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script> -->


    <div class="container mx-auto py-6 px-4" x-data="datatables()">
        <h1 class="text-4xl py-4 border-b mb-10">Recettes</h1>



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
                <div class="shadow rounded flex">
                    <div class="relative">
                        <a href="<?=$vars['baseUrl']?>loc=recipe&action=edit" class="text-lg text-center p-2  block lg:inline-block lg:mt-0">
                        <i class="fas fa-plus-circle text-green-800"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow  relative">
            <table class="border-collapse table-auto w-full whitespace-no-wrap bg-white table-striped relative">
                <thead class="h-20">
                    <tr class="text-left">


                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> ID</th>
                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> Nom</th>
                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> Difficulté</th>
                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> Pour</th>
                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> Temps</th>
                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> Chef</th>
                        <th class="bg-gray-100 sticky top-0 border-b border-gray-200 px-6 py-2 text-gray-600 font-bold tracking-wider uppercase text-xs"> Actions</th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($vars['entities'] as $recipe) { ?>
                        <tr>

                            <td class="border-dashed border-t border-gray-200 userId">
                                <span class="text-gray-700 px-6 py-3 flex items-center"> <?= $recipe->getId() ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 firstName">
                                <span class="text-gray-700 px-6 py-3 flex items-center"><?= $recipe->getName() ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 lastName">
                                <span class="text-gray-700 px-6 py-3 flex items-center"> <?= $recipe->getDifficulty() ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 emailAddress">
                                <span class="text-gray-700 px-6 py-3 flex items-center"> <?= $recipe->getPortions() ?> </span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 gender">
                                <span class="text-gray-700 px-6 py-3 flex items-center"><?= $recipe->getPreparationTime() ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 phoneNumber">
                                <span class="text-gray-700 px-6 py-3 flex items-center"><?= $recipe->getChef()->getUser()->getLastName(); ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 phoneNumber">
                                <span class="text-gray-700  flex items-center">
                                    <a href="" class="underline ">Modifier</a>
                                </span>
                                <span class="text-gray-700  flex items-center">

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