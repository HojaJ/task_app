<template>
    <div class="mb-5 mx-auto">
        <div class="d-flex justify-content-between align-items-center">
            <p class="title-color fw-bold fs-5 mb-0">Temperature (Last 24 Hours) </p>
            <select @change="temperature_onchange($event)" v-model="temperature_selected" class="border-0">
                <option v-for="day in this.days" :value="day" >{{day}}</option>
            </select>
        </div>

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
</template>

<script>
import { Line } from 'vue-chartjs'
import { Chart as ChartJS, Title,Filler,Tooltip,LineElement,LinearScale, PointElement, CategoryScale } from 'chart.js'
import axiosClient from '../../axios';
ChartJS.register( Title, Tooltip,Filler, LineElement,LinearScale, PointElement, CategoryScale)

export default {
    name: 'TemperatureChart',
    components: { Line },
    props: {
        city_selected: {
            type: Number
        },
        chartId: {
            type: String,
            default: 'temperature-chart'
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
            default: 'mt-5',
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
            temperature_selected: '',
            loaded: false,
            days: null,
            chartData: {
                labels: null,
                datasets: [ { data: null, }, ]
            },
            chartOptions: {
                responsive: true,
                fill: true,
                borderColor: (ctx) => {
                    const canvas = ctx.chart.ctx;
                    const gradient = canvas.createLinearGradient(250,0,0,0);
                    gradient.addColorStop(0, '#7947F7');
                    gradient.addColorStop(1, '#4CDFE8');
                    return gradient;
                },
                backgroundColor:(ctx) => {
                    const canvas = ctx.chart.ctx;
                    const gradient = canvas.createLinearGradient(250,0,0,0);
                    gradient.addColorStop(0, 'rgba(121, 71, 247, 0.05)');
                    gradient.addColorStop(1, 'rgba(76, 223, 232, 0.05)');
                    return gradient;
                },
                borderWidth:2,
                scales: {
                    y: {
                        gridLines: {
                            borderDash:[10,10],
                        },
                        ticks: {
                            callback: function (value, index, ticks)  {
                                value = Math.round(value)
                                return `${value}\u2103`;

                            }
                        },
                        border: {
                            display:false,
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    },


                },
                elements:{
                    point:{
                        borderWidth: 0,
                        radius: 10,
                        backgroundColor: 'rgba(0,0,0,0)'
                    }
                },
                plugins: {
                    tooltip: {
                        padding: 20,
                        displayColors: false,
                        callbacks: {
                            label: function(tooltipItems, data) {
                                return `${tooltipItems.formattedValue}\u2103`;
                            },
                            title : () => null
                        }
                    }
                }
            },
        }
    },
    mounted () {
        try {
            const today = new Date();
            let today_date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+(today.getDate());
            this.temperature_selected = today_date
            this.get_temperature(this.city_selected,today_date)
        } catch (e) {
            console.error(e)
        }
    },
    methods: {
        temperature_onchange(event){
                this.get_temperature(this.city_selected,event.target.value)
        },
        get_temperature(city, date){
            axiosClient.get(`temp/${city}/${date}`).then((res) => {
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
            this.get_temperature(this.city_selected,this.temperature_selected)
        }
    }

}
</script>
