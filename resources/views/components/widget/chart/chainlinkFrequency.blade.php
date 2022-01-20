<div class="card card-widget-chart" style="width: {{ $width }}">
    <div class="card-body">
        <div id="most-frequent-chainlinks-chart"></div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        Highcharts.chart('most-frequent-chainlinks-chart', {

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
                title: {
                    text: ''
                },
                type: 'logarithmic'
            },
                    
            tooltip: {
                headerFormat: '<b>{point.name}</b><br/>',
                pointFormat: 'Total: {point.y}'
            },
            
            series: [{
                color: {!! json_encode($color) !!},
                data: {!! json_encode($data) !!},
            }],
        
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
            
            legend: {
                enabled: false
            },
            
            credits: {
                enabled: false
            }

        });
    });
</script>