<script setup>
import generalNav from '~/components/navbar/frontpageHead.vue';
import foot from '~/components/footer/footer.vue';
</script>


<template>

<generalNav />
<main>
    <slot>
        
    </slot>
</main>

<foot />





</template>