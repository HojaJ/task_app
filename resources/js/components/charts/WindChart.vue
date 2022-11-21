<template>
    <div class="mb-5 mx-auto">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-color fw-bold fs-5 mb-0">Wind (Last 24 Hours)</p>
            <select @change="wind_onchange($event)" v-model="wind_selected" class="border-0">
                <option v-for="day in this.days" :value="day">{{ day }}</option>
            </select>
        </div>
        <div class="d-flex align-items-center justify-content-around">
            <h5 id="wind_tooltip" class="title-color fw-bolder"></h5>
            <Line
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
import {Line} from 'vue-chartjs'
import {Chart as ChartJS, Title, Tooltip, Filler, LineElement, LinearScale, PointElement, CategoryScale} from 'chart.js'
import axiosClient from '../../axios';

ChartJS.register(Title, Tooltip, Filler, LineElement, LinearScale, PointElement, CategoryScale)

export default {
    name: 'WindChart',
    components: {Line},
    props: {
        city_selected: {
            type: Number
        },
        chartId: {
            type: String,
            default: 'wind-chart'
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
            default: () => {
            }
        },
        plugins: {
            type: Object,
            default: () => {
            }
        }
    },
    data() {
        return {
            wind_selected: '',
            days: null,
            loaded: false,
            chartData: {
                labels: null,
                datasets: [{data: null,},]
            },
            chartOptions: {
                cubicInterpolationMode: 'monotone',
                responsive: true,
                fill: true,
                pointHoverRadius: 5,
                pointHoverBorderColor: 'red',
                pointHoverBorderWidth: 3,
                borderColor: (ctx) => {
                    const canvas = ctx.chart.ctx;
                    const gradient = canvas.createLinearGradient(350, 0, 20, 0);
                    gradient.addColorStop(0, 'rgb(255, 216, 225)');
                    gradient.addColorStop(0.25, 'rgb(255, 46, 93)');
                    gradient.addColorStop(.75, 'rgb(255, 46, 93)');
                    gradient.addColorStop(1, 'rgb(255, 216, 225)');
                    return gradient;
                },
                borderWidth: 3,
                backgroundColor: (ctx) => {
                    const canvas = ctx.chart.ctx;
                    const gradient = canvas.createLinearGradient(0, 0, 0, 90);
                    gradient.addColorStop(0, 'rgba(255, 47, 94, 0.12)');
                    gradient.addColorStop(1, 'rgba(255, 46, 94, 0)');
                    return gradient;
                },
                elements: {
                    point: {
                        borderWidth: 0,
                        radius: 10,
                        backgroundColor: 'rgba(0,0,0,0)'
                    }
                },
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
                            label: function (tooltipItems, data) {
                                document.getElementById('wind_tooltip').innerText = tooltipItems.formattedValue + ' km/h'
                                return tooltipItems.formattedValue + ' km/h';
                            },
                            title: () => null
                        }
                    }
                }
            }
        }
    },
    mounted() {
        try {
            const today = new Date();
            let today_date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + (today.getDate());
            this.wind_selected = today_date
            this.get_wind(this.city_selected, today_date)
        } catch (e) {
            console.error(e)
        }
    },

    methods: {
        wind_onchange(event) {
            this.get_wind(this.city_selected, event.target.value)
        },
        get_wind(city, date) {
            axiosClient.get(`wind_speed/${city}/${date}`).then((res) => {
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
        city_selected: function (value) {
            this.get_wind(this.city_selected, this.wind_selected)
        }
    }
}
</script>

<style>

</style>
