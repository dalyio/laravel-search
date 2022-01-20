<div class="card card-widget-chart" style="width: {{ $width }}">
    <div class="card-body">
        <div id="chainlink-counts-chart"></div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        
        Highcharts.chart('chainlink-counts-chart', {

            chart: {
                type: 'column'
            },

            title: {
                text: '<span class="chart-label">{{ $label }}</span>',
                useHhtml: true
            },
                    
            subtitle: {
                text: '<span class="chart-sublabel">{{ $sublabel }}</span>',
                useHhtml: true
            },
            
            xAxis: {
                labels: {
                    format: '{text}'
                }
            },

            yAxis: {
                min: 0,
                title: {
                    text: ''
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: ( // theme
                            Highcharts.defaultOptions.title.style &&
                            Highcharts.defaultOptions.title.style.color
                        ) || 'gray'
                    }
                }
            },
                    
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: -10,
                floating: true,
                backgroundColor:
                    Highcharts.defaultOptions.legend.backgroundColor || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
                    
            tooltip: {
                headerFormat: '<b>{series.name}</b><br/>',
                pointFormat: 'Total: {point.y}'
            },
            
            series: {!! json_encode($data) !!},
                
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true
                    }
                }
            },
        
            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            },
            
            credits: {
                enabled: false
            }

        });
    });
</script>