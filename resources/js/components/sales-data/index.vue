<template>
    <div class="col-12">
        <b-overlay
            id="overlay-background"
            :show="show"
            :variant="variant"
            :opacity="opacity"
            :blur="blur"
            rounded="sm"
            >
            <div class="card">
                <div class="card-header">
                <div>
                    <h4 class="card-title">Sales Data</h4>
                </div>
                <div class="dt-action-buttons text-right">
                    <div class="dt-buttons flex-wrap d-inline-flex">
                        <datepicker :bootstrap-styling="true" placeholder="Please Choose a Start Date" v-model="start_date"></datepicker>
                        <datepicker :disabled-dates="state.disabledDates" class="ml-1" :bootstrap-styling="true" placeholder="Please Choose an End Date" v-model="end_date"></datepicker>
                        <b-button variant="primary" class="ml-1" @click="getSalesData()" :disabled="disableSubmitButton" type="button" value="Apply Filter">
                            {{saving ? "Applying Filter..." : "Apply Filter"}}
                            <b-spinner v-if="saving" small type="grow"></b-spinner>
                        </b-button>
                    </div>
                </div>
                </div>
                <div class="card-body">
                <canvas class="line-chart-ex chartjs" data-height="450"></canvas>
                </div>
            </div>
        </b-overlay>
    </div>
</template>

<script>
import Datepicker from 'vuejs-datepicker';
import moment from 'moment';
export default {
    components: { Datepicker },
    data() {
        return {
            history: [],
            dates: [],
            values: [],
            variant: 'light',
            opacity: 0.85,
            blur: '2px',
            variants: [
                'transparent',
                'white',
                'light',
                'dark',
                'primary',
                'secondary',
                'success',
                'danger',
                'warning',
                'info',
            ],
            blurs: [
                { text: 'None', value: '' },
                '1px',
                '2px',
                '5px',
                '0.5em',
                '1rem'
            ],
            start_date: '',
            end_date: '',
            show: true,
            saving: false,
            errors: null,
            notificationSystem: {
            options: {
                success: {
                    position: "center",
                    timeout: 3000,
                    class: 'success_notification'
                },
                error: {
                    overlay: true,
                    zindex: 999,
                    position: "center",
                    timeout: 3000,
                    class: 'error_notification'
                },
                completed: {
                    position: 'center',
                    timeout: 1000,
                    class: 'complete_notification'
                },
                info: {
                    overlay: true,
                    zindex: 999,
                    position: 'center',
                    timeout: 3000,
                    class: 'info_notification',
                }
            }
            },
            state: {
                disabledDates: {
                from: new Date(), // Disable all dates up to specific date
                //days: [6, 0], 
                // Disable Saturday's and Sunday's
                
                }
            },
        };
    },

    mounted() {
        this.getSalesData()
    },

    methods: {

        customFormatter(date) {
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
        },

        getSalesData(){
            var newstartdate = ""
            var newenddate = ""
            if(this.start_date) {
                newstartdate = moment(this.start_date).format('YYYY-MM-DD')
            }
            if(this.end_date) {
                newenddate = moment(this.end_date).format('YYYY-MM-DD')
            }
            this.history = []
            this.dates = []
            this.values = []
            this.show = true
            axios.get(base_url + 'sales-data?start_date=' + newstartdate + '&end_date=' + newenddate)
            .then(response => {
                console.log(response)
                this.dates = response.data.dates
                this.values = response.data.sales
                // console.log(this.dates)
                this.loadChart()
                this.show = false
            })
        },

        loadChart() {
            var chartWrapper = $('.chartjs')
            var flatPicker = $('.flat-picker')
            var lineChartEx = $('.line-chart-ex')

            // Color Variables
            var primaryColorShade = '#836AF9'
            var yellowColor = '#ffe800'
            var successColorShade = '#28dac6'
            var warningColorShade = '#ffe802'
            var warningLightColor = '#FDAC34'
            var infoColorShade = '#299AFF'
            var greyColor = '#4F5D70'
            var blueColor = '#2c9aff'
            var blueLightColor = '#84D0FF'
            var greyLightColor = '#EDF1F4'
            var tooltipShadow = 'rgba(0, 0, 0, 0.25)'
            var lineChartPrimary = '#666ee8'
            var lineChartDanger = '#ff4961'
            var labelColor = '#6e6b7b'
            var grid_line_color = 'rgba(200, 200, 200, 0.2)'; // RGBA color helps in dark layout

            // Detect Dark Layout
            if ($('html').hasClass('dark-layout')) {
                labelColor = '#b4b7bd';
            }

            // Wrap charts with div of height according to their data-height
            if (chartWrapper.length) {
                chartWrapper.each(function () {
                $(this).wrap($('<div style="height:' + this.getAttribute('data-height') + 'px"></div>'));
                });
            }

            // Init flatpicker
            if (flatPicker.length) {
                var date = new Date();
                flatPicker.each(function () {
                $(this).flatpickr({
                    mode: 'range',
                    // defaultDate: ['2019-05-01', '2019-05-10']
                });
                });
            }

            // Line Chart
            // --------------------------------------------------------------------
            if (lineChartEx.length) {
                var lineExample = new Chart(lineChartEx, {
                type: 'line',
                plugins: [
                    // to add spacing between legends and chart
                    {
                    beforeInit: function (chart) {
                        chart.legend.afterFit = function () {
                        this.height += 20;
                        };
                    }
                    }
                ],
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    backgroundColor: false,
                    hover: {
                        mode: 'label'
                    },
                    tooltips: {
                        // Updated default tooltip UI
                        shadowOffsetX: 1,
                        shadowOffsetY: 1,
                        shadowBlur: 8,
                        shadowColor: tooltipShadow,
                        backgroundColor: window.colors.solid.white,
                        titleFontColor: window.colors.solid.black,
                        bodyFontColor: window.colors.solid.black
                    },
                    layout: {
                        padding: {
                            top: -15,
                            bottom: -25,
                            left: -15
                        }
                    },
                    scales: {
                        xAxes: [
                            {
                            display: true,
                            scaleLabel: {
                                display: true
                            },
                            gridLines: {
                                display: true,
                                color: grid_line_color,
                                zeroLineColor: grid_line_color
                            },
                            ticks: {
                                fontColor: labelColor
                            }
                            }
                        ],
                        yAxes: [
                            {
                            display: true,
                            scaleLabel: {
                                display: true
                            },
                            ticks: {
                                stepSize: 5,
                                min: 0,
                                max: 40,
                                fontColor: labelColor
                            },
                            gridLines: {
                                display: true,
                                color: grid_line_color,
                                zeroLineColor: grid_line_color
                            }
                            }
                        ]
                    },
                    legend: {
                    position: 'top',
                    align: 'start',
                    labels: {
                        usePointStyle: true,
                        padding: 25,
                        boxWidth: 9
                    }
                    }
                },
                data: {
                    labels: this.dates,
                    datasets: [
                    {
                        data: this.values,
                        label: 'No. of sales',
                        borderColor: lineChartDanger,
                        lineTension: 0.5,
                        pointStyle: 'circle',
                        backgroundColor: lineChartDanger,
                        fill: false,
                        pointRadius: 1,
                        pointHoverRadius: 5,
                        pointHoverBorderWidth: 5,
                        pointBorderColor: 'transparent',
                        pointHoverBorderColor: window.colors.solid.white,
                        pointHoverBackgroundColor: lineChartDanger,
                        pointShadowOffsetX: 1,
                        pointShadowOffsetY: 1,
                        pointShadowBlur: 5,
                        pointShadowColor: tooltipShadow
                    }
                    ]
                }
                });
            }
        }
    },

    computed: {
        disableSubmitButton() {
            return this.saving ? true: false
        }
    },
}
</script>