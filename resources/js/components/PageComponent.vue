<template>
    <div class="container">
        <div class="row">
            <nav id="sidebarMenu" class="col-md-1 d-md-block sidebar">
                <div class="position-sticky pt-2 sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-center" href="/">
                                <img src="/assets/logo.png" alt="Logo" class="logo">
                            </a>
                        </li>
                        <li class="nav-item pt-4">
                            <a class="nav-link text-center" href="/">
                                <img src="/assets/home.png" alt="Home Icon">
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="col-md-11 ms-sm-auto pl-0">
                <div
                    class=" d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-4 border-bottom_c">
                    <img src="/assets/Avatar.png" class="ms-auto" alt="Avatar">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-3">
                            <h4>Weather Reports</h4>

                            <div class="row justify-content-around">
                                <city
                                    class="col-md-4"
                                    v-for="city in cities"
                                    :key="city.id"
                                    :name="city.name"
                                    :country_code="city.country_code"
                                    :condition_icon="city.condition_icon"
                                    :temperature="city.temperature"
                                ></city>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 statistics">
                        <div class="p-3">
                            <div class="d-flex justify-content-between mb-5 align-items-center">
                                <h3 class="font-bold mb-0">Statistics</h3>
                                <select @change="city_onchange($event)" v-model="city_selected"
                                        class="border-0 fw-bold">
                                    <option v-for="city in cities" :value="city.id">
                                        {{ city.name + ', ' + city.country_code }}
                                    </option>
                                </select>
                            </div>
                            <div>
                                <TemperatureChart :city_selected="city_selected"/>
                                <WindChart :city_selected="city_selected"/>
                                <HumidityChart :city_selected="city_selected"/>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script setup>
import {ref, onMounted, computed} from 'vue';
import axiosClient from "../axios"
import HumidityChart from "./charts/HumidityChart.vue"
import WindChart from "./charts/WindChart.vue"
import TemperatureChart from "./charts/TemperatureChart.vue"
import City from "./city/City.vue";

let city_selected = ref(1);
let cities = ref([]);

onMounted(() => {
    axiosClient.get('/cities/').then(res => {
        cities.value = res.data.cities;
    })
});

function city_onchange(event) {
    city_selected.value = event.target.value
}

</script>
<style>
.statistics {
    border-left: 1px solid #EFECEC;
    background-color: #FFFCFC;
}

.sidebar {
    border-right: 1px solid #EFECEC;
}

.border-bottom_c {
    border-bottom: 1px solid #EFECEC;
}

h1 sup {
    color: #8497C9;
}

.title-color {
    color: #1B2767;
}

select {
    outline: none;
    background: transparent;
}

.w-80 {
    width: 80%;
}

.card {
    width: 9rem;
    background-color: #736099;
    border-radius: 25px;
    border-color: #736099;
}
</style>
