<template>
    

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-10">
            <div class="rounded-lg">
                <div class="bg-white p-5 flex justify-between items-center border-b-1 border-gray-300">
                    <p class="text-xl font-semibold text-gray-700 mb-4">My Profile</p>
                    <div class="flex items-center jestify-between gap-x-1 p-2 bg-blue-500 hover:bg-blue-300 text-white rounded-lg">
                        <edit />
                        <NuxtLink to="#" > Edit </NuxtLink>
                    </div>
                    
                </div>

                <div class="bg-white md:p-20 p-5">
                    <div class="md:flex justify-center md:gap-x-50 space-y-5">
                        <div class="md:flex-col flex-row justify-between space-y-3">
                            <div class="flex-shrink-0 flex items-center justify-center rounded-full w-30 h-30 bg-gradient-to-r from-blue-500 to-blue-600">
                                <p class="text-white font-normal text-7xl">SJ</p>
                            </div>
                            <div>
                                <p class="text-gray-800 font-bold text-xl">Sarah Johnson</p>
                            
                            </div>
                            <div class="flex justify-between items-center gap-x-5">
                                <div>
                                    <p class="text-gray-600 text-md">Total Loans</p>
                                    <!--fetch from table laon of user-->
                                    <p class="text-xl font-bold text-gray-800">10</p>
                                </div>
                                <div>
                                    <p class="text-3xl text-gray-500">|</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 text-md">Active Loans</p>
                                    <!--fetch from table laon of user-->
                                    <p class="text-xl font-bold text-gray-800">10</p>
                                </div>
                            </div>


                        </div>
                        <div class="border-gray-300 border-1">
                        
                        </div>

                        <div>
                            <div class="md:space-y-5">
                                <p class="tex-gray-800 font-semibold tex-lg">Personal Infomation</p>
                                <div class="flex justify-between items-center gap-x-30 ">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                            </div>

                            <div class="mt-10 md:space-y-5">
                                <p class="tex-gray-800 font-semibold tex-lg">Employment information</p>
                                <div class="flex justify-between items-center gap-x-30 ">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="text-gray-700 text-md font-normal">Date of birth</p>
                                    <p class="text-gray-800 text-md font-normal">_________________</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>





        </div>
   

</template>


<script setup>
    import edit from '~/components/icons/edit.vue'
    definePageMeta({
        layout:'borrower',
        middleware:'auth'
    })

</script>