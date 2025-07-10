<script setup>
    import hero from '~/assets/image/Peer-To-Peer-Lending.png';
    import trust from '~/assets/image/take-care.png';
    import flash from '~/assets/image/flash.png';
    import shield from '~/assets/image/shield.png';
    
    definePageMeta({
        layout: 'default'
    })
</script>


<template>


  <!--hero-->
    <div class="bg-[#1b1d97] headhero">
        <div class="mx-auto max-w-7xl py-24 sm:px-6 sm:py-32 lg:px-8 lg:py-20">
            <div class="relative isolate overflow-hidden  px-6 pt-16  sm:px-16 md:pt-24 lg:flex lg:gap-x-20 lg:px-5 lg:pt-0">
                <div class="mx-auto max-w-md text-center lg:mx-0 lg:flex-auto lg:py-10 lg:text-left sm:mb-10
                ">
                    <h2 class="text-balance text-3xl font-semibold tracking-tight text-white sm:text-4xl">LoanBridge Quick & Easy</h2>
                    <p class="mt-6 text-pretty text-lg/7 text-gray-300">Connect directly with borrowers or lenders, Earn more, Borrow smart, All in one trusted platform.</p>

                    <div class="mt-10 flex items-center justify-center gap-x-6 lg:justify-start">
                        <a href="#" class="rounded-lg bg-white px-3.5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm border border-gray-900 hover:bg-gray-200 focus-outline focus-visible:outline-2 fucus-visible:outline-offset-2 focus-visible:outline-white">I'm Lender</a>
                        <a href="#" class=" rounded-lg text-sm/6 px-3.5 py-2 font-seminbold text-white shadow-sm border border-gray-100 hover:bg-blue-800 focus-outline focus-visible:outline-2 fucus-visible:outline-offset-2 focus-visible:outline-white">I'm Borrower</a>
                    </div>
                </div>
                <div class="relative lg:mx-0 lg:py-5 lg:px-10">
                    <img class="left-0 top-0" :src="hero" alt="hero" width="581.11px" height="317.11px">
                </div>
                
            </div>
        </div>
    </div>

    <!--why choose us-->

    <div class="bg-slate-50">
        <div class="mx-auto max-w-7xl px-6 py-6 lg:px-8 lg:py-20">
            <div class="grid grid-cols-3 gap-x-20 gap-y-16 text-center lg:grid-cols-3">
                <div class="text-center bg-white rounded-[15px] shadow-sm px-5 py-3 place-items-center">
                    <img :src="trust" alt="trust" class="w-20 h-20">
                    <h3 class="order-first text-2xl font-semibold tracking-tight text-gray-900 py-5">Trusted, Transparent Platform</h3>
                    <p class="text-base/7 text-gray-600">Our platform verify user for register to ensures only credible borrowers and lenders join our platform, giving you peace of mind.</p>
                    
                </div>
                <div class="text-center bg-white rounded-[15px] shadow-sm px-5 py-3 place-items-center">
                    <img :src="flash" alt="fast" class="w-20 h-20 fill-blue-500">
                    <h3 class="order-first text-2xl font-semibold tracking-tight text-gray-900 py-5">Fast & Flexible</h3>
                    <p class="text-base/7 text-gray-600">Access funds quickly and conveniently. Whether for personal needs or business growth, our flexible loan terms make borrowing simple and affordable.</p>
                    
                </div>
                <div class="text-center bg-white rounded-[15px] shadow-sm px-5 py-3 place-items-center">
                    <img :src="shield" alt="shield" class="w-20 h-20">
                    <h3 class="order-first text-2xl font-semibold tracking-tight text-gray-900 py-5">Secure & Regulated</h3>
                    <p class="text-base/7 text-gray-600">we set up the some regulations for the borrower in term of applying loan requested in order to reduce the risk for the lender </p>
                    
                </div>
            </div>
        </div>
    </div>

    <!--rating-->

    <!--footer-->

    <div>
        
    </div>
    


   

</template>

<style scoped>
    .headhero {
        background-image:
            url('~/assets/image/bg-dot.png'),
            url('~/assets/image/bg-dot.png'),
            url('~/assets/image/bg-round.png'),
            url('~/assets/image/bg-tree.png');
        background-position:
            10px 10px,
            bottom 190px right 10px,
            left 55% top -1px,
            left 45% bottom -1px;
        background-repeat: no-repeat;
    }


</style>