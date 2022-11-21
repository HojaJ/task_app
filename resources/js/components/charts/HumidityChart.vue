<template>
    <div  class="mb-5 mx-auto">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-color fw-bold fs-5">Humidity (Last 24 Hours)</p>
            <select @change="humidity_onchange($event)" v-model="humidity_selected" class="border-0">
                <option v-for="day in this.days" :value="day" >{{day}}</option>
            </select>
        </div>
        <div class="d-flex align-items-center justify-content-around">
            <h5 id="humidity_tooltip" class="title-color fw-bolder"></h5>
            <Bar
                v-if="loaded"
                :chart-options="chartOptions"
                :chart-data="chartData"
                :chart-id="chartId"
                :dataset-id-key="datasetIdKey"
                :plugins="plugins"
                :css-classes="cssClasses"
                :styles="styles"
                :width="width"
                :height="height"
            />
        </div>
    </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Filler, Title, Tooltip, BarElement, CategoryScale, LinearScale } from 'chart.js'
import axiosClient from '../../axios';
ChartJS.register(BarElement,Filler, Title, Tooltip, CategoryScale, LinearScale)

export default {
    name: 'HumidityChart',
    components: { Bar },
    props: {
        city_selected: {
            type: Number
        },
        chartId: {
            type: String,
            default: 'humidity-chart'
        },
        datasetIdKey: {
            type: String,
            default: 'label'
        },
        width: {
            type: Number,
            default: 400
        },
        height: {
            type: Number,
            default: 100
        },
        cssClasses: {
            default: 'ms-auto w-80',
            type: String
        },
        styles: {
            type: Object,
            default: () => {}
        },
        plugins: {
            type: Object,
            default: () => {}
        }
    },
    data() {
        return {
            humidity_selected: '',
            loaded: false,
            days: null,
            chartData: {
                labels: null,
                datasets: [ { data: null, }, ]
            },
            chartOptions: {
                responsive: true,
                fill:true,
                backgroundColor: '#F5F0FF',
                hoverBackgroundColor:'#7947F7',
                scales: {
                    y: {
                        display: false
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    },

                },
                plugins: {
                    tooltip: {
                        padding: 20,
                        displayColors: false,
                        callbacks: {
                            label: function(tooltipItems, data) {
                                document.getElementById('humidity_tooltip').innerText = tooltipItems.formattedValue + '%'
                                return tooltipItems.formattedValue + '%';
                            },
                            title : () => null
                        }
                    }
                }

            }
        }
    },
    mounted () {
        try {
            const today = new Date();
            let today_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+(today.getDate());
            this.humidity_selected = today_date
            this.get_humidity(this.city_selected,today_date)

        } catch (e) {
            console.error(e)
        }
    },

    methods: {
        humidity_onchange(event){
            this.get_humidity(this.city_selected,event.target.value)
        },
        get_humidity(city,date){
            axiosClient.get(`humidity/${city}/${date}`).then((res) => {
                this.days = res.data.days
                this.chartData.labels = res.data.labels
                this.chartData.datasets[0].data = res.data.datasets
                this.loaded = true
            }).catch((e) => {
                console.log(e);
            })
        }
    },
    watch: {
        city_selected: function(value) {
            this.get_humidity(this.city_selected,this.humidity_selected)
        }
    }

}
</script>
