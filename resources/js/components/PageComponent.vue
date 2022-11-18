<template>
        <div class="container">
            <div class="row">
                <nav id="sidebarMenu" class="col-md-2 d-md-block sidebar collapse ">
                    <div class="position-sticky pt-3 sidebar-sticky">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link text-center" >
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

                <main class="col-md-10 ms-sm-auto ">
                    <div class=" d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-5 border-bottom_c">
                        <img src="/assets/Avatar.png" class="ms-auto" alt="Avatar">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="p-3">
                                <h4>Weather Reports</h4>
                                <div class="row">
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
                                <h4>Statistics</h4>
                                <div>
                                    <BarChart  />
                                </div>
                            </div>
                        </div>
                    </div>

                </main>
            </div>
        </div>
</template>

<script>
import axiosClient from "../axios"
import BarChart from "./BarChart.vue"
import City from "./City.vue";
export default {
    components: {
        City,
        BarChart
    },
    data() {
        return {
            cities: null,
        };
    },
    created: function() {
        axiosClient.get('/cities/').
        then(res => {
                this.cities = res.data.cities;
        })
    },
};
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
main {
    padding-left: 0 !important;
}
.card {
    width: 9rem;
    background-color: #736099;
    border-radius: 25px;
    border-color:#736099;
}

.nav-scroller {
    position: relative;
    z-index: 2;
    height: 2.75rem;
    overflow-y: hidden;
}

.nav-scroller .nav {
    display: flex;
    flex-wrap: nowrap;
    padding-bottom: 1rem;
    margin-top: -1px;
    overflow-x: auto;
    text-align: center;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
}
</style>
