<template>
    <div>
        <p class="text-small">Humidity (Last 24 hours)</p>
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
</template>

<script>
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, BarElement, CategoryScale, LinearScale } from 'chart.js'
import axiosClient from '../axios';
ChartJS.register(BarElement, Title, Tooltip, CategoryScale, LinearScale)

export default {
    name: 'BarChart',
    components: { Bar },
    props: {
        chartId: {
            type: String,
            default: 'bar-chart'
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
            default: 150
        },
        cssClasses: {
            default: '',
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
            loaded: false,
            chartData: {
                labels: null,
                datasets: [ { data: null, }, ]
            },
            chartOptions: {
                responsive: true,
                fill:true,
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
                backgroundColor: '#F5F0FF',
            }
        }
    },
    mounted () {
        this.loaded = false
        try {
            axiosClient.get('humidity').then((res) => {
                console.log(res)
                this.chartData.labels = res.data.labels
                this.chartData.datasets[0].data = res.data.datasets
                this.loaded = true
            }).catch((e) => {
                console.log(e);
            })

        } catch (e) {
            console.error(e)
        }
    }

}
</script>
