<header class="z-10 py-4 bg-white shadow-md" x-data="{ 'isProfileMenuOpen': false }">
   <div class="container flex items-center justify-end h-full px-6 mx-auto text-pequant-blue-600">
      <!-- Mobile hamburger -->
      <button class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple" @click="isSideMenuOpen = true" aria-label="Menu">
         <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
         </svg>
      </button>
      <ul class="flex items-center flex-shrink-0 space-x-6">
         <!-- Profile menu -->
         <li class="relative" x-data="">
            <button class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none" @click="isProfileMenuOpen = true" aria-label="Account" aria-haspopup="true">
               <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
               </svg>
            </button>
            <div x-show="isProfileMenuOpen">
               <ul 
               x-transition:leave="transition ease-in duration-150" 
               x-transition:leave-start="opacity-100" 
               x-transition:leave-end="opacity-0" 
               @click.away="isProfileMenuOpen = false" 
               @keydown.escape="isProfileMenuOpen = false" 
               class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md" aria-label="submenu">
                  <li class="flex">
                     <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800" href="/user/profile">
                        <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                           <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>Profile</span>
                     </a>
                  </li>
                  <li class="flex">
                     <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf

                        <button type="submit" class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800">
                           <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                              <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                           </svg>
                           <span>{{ __('Log Out') }}</span>
                        </button>
                     </form>
                  </li>
               </ul>
            </div>
         </li>
      </ul>
   </div>
</header>