<template>
    
    
        <div class="max-w-7xl mx-auto m-10 px-4 sm:px-6 lg:px-8 py-12">
            <div v-if="loading">Loanding</div>
            <div v-else>
                
                <div v-if="loans" class="w-full bg-white rounded-lg p-10 space-y-4">
                    <!--user profile-->
                    <div class="space-y-4">
                        <div class="flex justify-start items-center gap-x-5">
                            <NuxtLink
                            to="#"
                            class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center text-xl font-semibold"
                            >
                            {{ loans.lender?.first_name.charAt(0).toUpperCase() }}{{ loans.lender?.last_name.charAt(0).toUpperCase() }}
                            </NuxtLink>
                            <span class="text-lg font-medium text-gray-900">{{ loans.lender?.first_name }} {{ loans.lender?.last_name }}</span>
                        </div>
                        
                        <!--border bottom-->
                        <div class="border-1 border-gray-200"></div>

                    </div>

                    <!--request amount-->
                    <div class="flex flex-col">
                        <p class="text-gray-600 text-md">Total Amount To Pay</p>
                        <p class="text-3xl font-bold text-gray-900">{{ loans.total }}</p>
                    </div>

                    <!--payment amount-->
                    <form @submit.prevent="handleFund" class="space-y-10">

                    <div class="flex flex-col space-y-2">
                        <label for="amount" class="text-gray-600 text-md">Payment Amount *</label>
                        <div>
                            <div class="flex items-center rounded-md bg-gray-100 h-10 pl-3 outline-1 -outline-offset-1 outline-gray-300 has-[input:focus-within]:outline-2 has-[input:focus-within]:-outline-offset-2 has-[input:focus-within]:outline-indigo-600">
                                <div class="shrink-0 text-base text-gray-500 select-none sm:text-sm/6">$</div>
                                <input type="number" step="0.01" v-model="form.total" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <!--fund or cancel-->
                    <div class="w-full">
                        <div class="flex justify-end space-x-4">
                            <NuxtLink
                            :to="`/userUI/borrower/creditRecord`"
                            class="px-6 py-3 md:px-10 md:py-3 lg:px-20 lg:py-3 bg-gray-300 hover:bg-gray-400 text-gray-900 font-semibold rounded-lg transition-colors duration-200 text-center"
                            >
                            Cancel
                            </NuxtLink>
                            <button
                            type="submit"
                            class="px-6 py-3 md:px-10 md:py-3 lg:px-20 lg:py-3 bg-[#10B981] hover:bg-green-500 text-white font-semibold rounded-lg transition-colors duration-200 text-center"
                            >
                            Fund
                            </button>
                        </div>
                    </div>
                    </form>

                    <!---->
                </div>
            </div>
        </div>


   


</template>



<script setup>

    import {ref, onMounted} from 'vue'
    import { useRuntimeConfig , useRouter, useRoute} from '#app';
    import { useAuthLender } from '~/composables/useAuthLender';
    import { borrowerProfileData } from '~/composables/borrowerProfileData';


    definePageMeta({
        layout:'borrower',
        middleware: 'auth'
    })

    const token=useAuthLender()
    const config=useRuntimeConfig()
    const router=useRouter()
    const route=useRoute()
    const {id}= await borrowerProfileData()

    const loading=ref(true)
    const loans=ref()
    
    const form=ref({
        total:''
    })
    const error=ref({
        total:''
    })
    onMounted(async()=> {
    try{
        const res = await $fetch(`${config.public.sanctum.baseUrl}/getLoanAfterApproveforBorrower/${route.params.paybackLoanId}`, {
        
        headers: {
            Authorization: `Bearer ${token.value}`,
        },    

        })

        if (res) {
         loans.value=res.loan
         form.value.total = Number(res.loan.total)
        }


    } catch(error) {
        console.error('Failed to fetch loans:', error)
    } finally {
        loading.value=false
    }
    })

   

    const handleFund=async() => {

        try{
            const res= await $fetch(`${config.public.sanctum.baseUrl}/payback/${route.params.paybackLoanId}/${id}`, {
                method:'POST',
                body: {
                    total: Number(form.value.total),
                },
                headers: {
                    Authorization: `Bearer ${token.value}`,
                },    
            })
            if (res) {
                alert ('payback success')
                router.push('/userUI/borrower/creditRecord')
            }
        } catch(error) {
        console.error('Failed to fetch loans:', error)
        

        }


        




    }
</script>