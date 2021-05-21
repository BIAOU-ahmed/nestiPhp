<nav class="flex items-center justify-between h-24  shadow-2xl mt-5">

  <div class="w-full block flex-grow flex items-center h-full  ">
    <div class="text-sm h-full nav-links xl:w-3/4 lg:w-3/4 md:w-2/3 flex justify-between items-center lg:mr-auto pr-2 ">
      <a href="<?=$vars['baseUrl']?>recipe/list" class="<?=($vars['urlParameters']['location']=='recipe')?'active':'';?> ml-2 text-lg text-center nav-button block  lg:inline-block lg:mt-0 text-teal-lighter text-white lg:w-1/6 md:w-3/12">
          <i class="far fa-list-alt"></i> Recettes
      </a>
      <a href="<?=$vars['baseUrl']?>article/list" class="<?=($vars['urlParameters']['location']=='article')?'active':'';?> text-lg text-center nav-button block lg:inline-block lg:mt-0 text-teal-lighter text-white lg:w-1/6 md:w-2/12">
      <i class="fas fa-utensils"></i> Articles
      </a>
      <a href="<?=$vars['baseUrl']?>user/list" class=" <?=($vars['urlParameters']['location']=='user')?'active':'';?> text-lg text-center nav-button block  lg:inline-block lg:mt-0 text-teal-lighter text-white lg:w-1/6 md:w-3/12">
          <i class="inline-block fas fa-users"></i>
          <span class="inline-block">
              Utilisateurs
          </span>
      </a>
      <a href="<?=$vars['baseUrl']?>statistics/dashboard" class="<?=($vars['urlParameters']['location']=='statistics')?'active':'';?> mr-2 text-lg text-center nav-button block lg:inline-block lg:mt-0 text-white lg:w-1/6 md:w-3/12">
      <i class="far fa-chart-bar"></i> Statistiques
      </a>
    </div>
    <div class="xl:w-1/5 lg:w-1/5 md:w-1/3">
     <label for="" class="text-muted sm:ml-2 "> <i class="far fa-user-circle"></i>  <?=$vars['loggedInUser']->getFirstName().' '.$vars['loggedInUser']->getLastName();?> </label>
     <a href="<?=$vars['baseUrl']?>user/logout" class="ml-5 mr-3"> <i class="fas fa-sign-out-alt"></i>Deconnexion</a>
    </div>
  </div>
</nav>