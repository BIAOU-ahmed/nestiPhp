

<div class="flex w-full h-full justify-center md:mt-48 items-stretch login-page">

    <div class="flex flex-col w-1/2 md:w-2/3  self-center">
        <?php if (@$vars['message'] == 'disconnect') { ?>
            <div id="disconnect-message" class="w-full block text-gray-700 text-center px-6 py-4 border-0 relative mb-4">

                <span class="inline-block text-2xl align-middle mr-8">
                    Déconnexion réussi
                </span>

            </div>
        <?php } ?>

        <?php if (@$vars['message'] == 'errorLogin') { ?>
            <div id="error-message" class="w-full block bg-red-400 text-gray-700 text-center px-6 py-4 border-0 relative mb-4">

                <span class="  inline-block text-2xl align-middle mr-8">
                    Erreur d'identifiant ou de mot de passe
                </span>

            </div>
        <?php } ?>
        <div class="lg:w-full xl:max-w-screen-sm shadow-2xl bg-white">

            <div class="mt-10 px-12 md:px-1 sm:px-24 md:px-4 lg:px-12 lg:mt-16 xl:px-24 xl:max-w-2xl">
                <h2 class="text-center text-4xl text-indigo-900 font-display font-semibold lg:text-left xl:text-5xl
                    xl:text-bold flex justify-center">Connexion</h2>
                <div class="mt-12 md:w-10/12">
                    <form id="login-form" class="form " action="<?= $vars['baseUrl'] ?>user/login" method="post">
                        <div >
                            <div class="ml-6 text-sm font-bold text-gray-700 tracking-wide">Identifiant</div>
                            <i class="far fa-user-circle"></i><input class=" w-5/6  ml-2 text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500" type="text" value="" name="Users[username]">
                        </div>
                        <div class="py-2" x-data="{ show: true }">
                            <span class="ml-6 text-sm font-bold text-gray-700 tracking-wide">Mot de passe</span>
                            <div class="relative">
                            <i class="fas fa-lock"></i><input placeholder="" :type="show ? 'password' : 'text'" class="w-5/6 ml-2 text-lg py-2 border-b border-gray-300 focus:outline-none focus:border-indigo-500" value="" type="password" name="Users[password]">
                                <div class="absolute inset-y-0 right-0 pr-16 flex items-center text-sm leading-5">

                                    <svg class="h-6 text-gray-700" fill="none" @click="show = !show" :class="{'hidden': !show, 'block':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 576 512">
                                        <path fill="currentColor" d="M572.52 241.4C518.29 135.59 410.93 64 288 64S57.68 135.64 3.48 241.41a32.35 32.35 0 0 0 0 29.19C57.71 376.41 165.07 448 288 448s230.32-71.64 284.52-177.41a32.35 32.35 0 0 0 0-29.19zM288 400a144 144 0 1 1 144-144 143.93 143.93 0 0 1-144 144zm0-240a95.31 95.31 0 0 0-25.31 3.79 47.85 47.85 0 0 1-66.9 66.9A95.78 95.78 0 1 0 288 160z">
                                        </path>
                                    </svg>

                                    <svg class="h-6 text-gray-700" fill="none" @click="show = !show" :class="{'block': !show, 'hidden':show }" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 640 512">
                                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144.13 144.13 0 0 1-26 2.61zm313.82 58.1l-110.55-85.44a331.25 331.25 0 0 0 81.25-102.07 32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45zm-183.72-142l-39.3-30.38A94.75 94.75 0 0 0 416 256a94.76 94.76 0 0 0-121.31-92.21A47.65 47.65 0 0 1 304 192a46.64 46.64 0 0 1-1.54 10l-73.61-56.89A142.31 142.31 0 0 1 320 112a143.92 143.92 0 0 1 144 144c0 21.63-5.29 41.79-13.9 60.11z">
                                        </path>
                                    </svg>

                                </div>
                            </div>
                            <div class="mt-10">
                                <button class="float-right bg-indigo-500 text-gray-100 p-4 mb-2 rounded tracking-wide
                                font-semibold font-display focus:outline-none focus:shadow-outline hover:bg-indigo-600
                                ">
                                    Valider
                                </button>
                            </div>
                    </form>

                </div>
            </div>
        </div>

    </div>

</div>