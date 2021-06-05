<div class="  antialiased sans-serif h-screen">


    <?php
    if (isset($_SESSION['message'])) { ?>
        <div id="sucess_message" class="w-1/2 ml-auto alert flex flex-row items-center bg-green-200 p-5 rounded border-b-2 border-green-300 mt-2">
            <div class="alert-icon flex items-center bg-green-100 border-2 border-green-500 justify-center h-10 w-10 flex-shrink-0 rounded-full">
                <span class="text-green-500">
                    <svg fill="currentColor" viewBox="0 0 20 20" class="h-6 w-6">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </span>
            </div>
            <div class="alert-content ml-4">
                <div class="alert-title font-semibold text-lg text-green-800">
                    Success
                </div>
                <div class="alert-description text-sm text-green-600">
                    L'utilisateur a été supprimer avec succès!
                </div>
            </div>
        </div>
    <?php
        unset($_SESSION["message"]);
    } ?>

    <div class="py-6 px-4">
        <h1 class="text-4xl py-4 border-b mb-10">Utilisateurs</h1>
        <div class="mb-4 flex justify-between items-center">
            <div class="flex-1 pr-4">
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
            <div>
                <div class="shadow rounded flex">
                    <div class="relative">
                        <a href="<?= $vars['baseUrl'] ?>user/edit" class="text-lg text-center p-2  block lg:inline-block lg:mt-0">
                            <i class="fas fa-plus-circle text-green-800"></i> Ajouter
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow  relative">
            <table id="myTable" class="display nowrap ml-0 w-full tab_datatable">
                <thead class="">
                    <tr class="tables_head">
                        <th class="sticky top-0 border-b border-gray-200 w-1/12 px-2 text-white font-bold  uppercase"> ID</th>
                        <th class="sticky top-0 border-b border-gray-200 w-1/6 text-white font-bold  "> Nom</th>
                        <th class="sticky top-0 border-b border-gray-200  w-1/6 text-white font-bold  "> Role</th>
                        <th class="sticky top-0 border-b border-gray-200 w-1/6  text-white font-bold "> Derniere connexion</th>
                        <th class="sticky top-0 border-b border-gray-200 w-1/6 text-white font-bold "> Etat</th>
                        <th class="sticky top-0 border-b border-gray-200  w-1/6 text-white font-bold  "> Actions</th>

                    </tr>
                </thead>
                <tbody>

                    <?php foreach ($vars['entities'] as $user) { ?>
                        <tr class="text-center">

                            <td class="border-dashed border-t border-gray-200  ">
                                <span class="text-gray-700 py-3 "> <?= $user->getId() ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 ">
                                <span class="text-gray-700 py-3 "><?= $user->getFirstName() . ' ' . $user->getLastName() ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 ">
                                <span class="text-gray-700  py-3 "> <?= $user->getRoles()  ?></span>
                            </td>
                            <td class="border-dashed border-t text-left border-gray-200 ">
                                <span class="text-gray-700 py-3 "> <?= $user->getLastConnectionDate() ?> </span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 ">
                                <span class="rounded <?= $user->getStateClass($user) ?> py-1 px-3 text-xs font-bold"><?= $user->getState($user) ?></span>
                            </td>
                            <td class="border-dashed border-t border-gray-200 grid pt-3">
                                <span class="text-gray-700  text-center ">
                                    <a href="<?= $vars['baseUrl'] ?>user/edit/<?= $user->getId() ?>" class="underline ">Modifier</a>
                                </span> <br>

                                <div x-data="{ showModal<?= $user->getId() ?>: false }" :class="{'overflow-y-hidden': showModal<?= $user->getId() ?> }">
                                    <main class="flex flex-col sm:flex-row justify-center items-center">
                                        <a class="delete_btn cursor-pointer underline  text-gray-700 p-2 w-32   " @click="showModal<?= $user->getId() ?> = true">
                                            Supprimer
                                        </a>

                                    </main>

                                    <!-- Modal1 -->
                                    <div class="delete_modale hidden fixed inset-0 w-full h-full z-20 bg-gray-200 bg-opacity-50 duration-300 overflow-y-auto" x-show="showModal<?= $user->getId() ?>" x-transition:enter="transition duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                        <div class="relative sm:w-3/4 md:w-1/2 lg:w-1/3  sm:mx-auto my-10 opacity-100">
                                            <div class="relative bg-gray-300 shadow-lg rounded-md text-gray-900 z-20" @click.away="showModal<?= $user->getId() ?> = false" x-show="showModal<?= $user->getId() ?>" x-transition:enter="transition transform duration-300" x-transition:enter-start="scale-0" x-transition:enter-end="scale-100" x-transition:leave="transition transform duration-300" x-transition:leave-start="scale-100" x-transition:leave-end="scale-0">
                                                <form action="<?= $vars['baseUrl'] ?>user/delete/<?= $user->getId() ?>" method="post">


                                                    <header class="w-full h-40 grid mb-5 flex items-center  ">
                                                        <div class=" w-full   grid  bg-white h-20">

                                                            <h2 class=" font-semibold text-center justify-self-center self-center "><i class="text-3xl text-red-600 fas fa-exclamation-triangle"></i> Voulez-vous vraiment supprimer l'element: <?= $user->getId() ?> ?</h2>

                                                        </div>

                                                    </header>
                                                    <main class="  h-20 grid   p-2 text-center">
                                                        <p class="w-2/3 justify-self-center bg-white rounded-md">
                                                            Cette action est définitive et irréversible
                                                        </p>
                                                    </main>
                                                    <footer class="">

                                                        <div class="flex items-center justify-end p-6 border-t border-solid border-gray-300 rounded-b">
                                                            <button class="bg-red-500  active:bg-green-600 font-bold uppercase text-sm px-6 py-3 rounded shadow hover:shadow-lg outline-none focus:outline-none mr-1 mb-1" type="button" style="transition: all .15s ease" @click="showModal<?= $user->getId() ?> = false">
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
