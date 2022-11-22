<template>
    <div class="card text-white mt-5">
        <div class="card-body px-2">
            <h5 class="mb-0 fs-6">{{ name }}</h5>
            <p>{{ country_code }}</p>
            <img :src="'http://openweathermap.org/img/w/' +  condition_icon  + '.png'"
                 class="img-fluid d-block my-4 mx-auto" alt="...">
            <h1 class="text-center">{{ temperature }}<sup>o</sup></h1>
        </div>
    </div>
</template>

<script setup>
defineProps(['name', 'country_code', 'condition_icon', 'temperature'])
</script>
