@extends('layout.app')

@section('content')
<div class="d-flex flex-wrap p-3 gap-1">
    
    <div class="card card-widget" style="width: 100%">
        <div class="card-body">
            <div class="card-title">
                <span>{{ __('Haversine Formula') }}</span>
            </div>
            <div>
                <blockquote>
                  <pre>
                    <code>{{"
public function distinceBetweenZipcodes(\$zipcodeFrom, \$zipcodeTo, \$unit = 'km')
{
    \$changeLatitude = deg2rad(\$zipcodeFrom->latitude()) - deg2rad(\$zipcodeTo->latitude());
    \$changeLongitude = deg2rad(\$zipcodeFrom->longitude()) - deg2rad(\$zipcodeTo->longitude());

    \$angle = (sin(\$changeLatitude / 2) * sin(\$changeLatitude / 2)) + 
        (cos(deg2rad(\$zipcodeFrom->latitude())) * cos(deg2rad(\$zipcodeTo->latitude())) * sin(\$changeLongitude / 2) * sin(\$changeLongitude / 2));
    \$distance = (2 * asin(sqrt(\$angle)) * \$this->earthRadius[\$unit]);

    return \$distance;
}
                    "}}</code>
                  </pre>
                </blockquote>  
            </div>
        </div>
    </div>
    
    <div class="card card-widget" style="width: calc(50% - 1rem)">
        <div class="card-body">
            <div id="zipcode-distance-component">
                <zipcode-distance-component></zipcode-distance-component>
            </div>
        </div>
    </div>
    
    <div class="card card-widget" style="width: calc(50% - 1rem)">
        <div class="card-body">
            <div id="zipcode-distance-tester-component">
                <zipcode-distance-tester-component></zipcode-distance-tester-component>
            </div>
        </div>
    </div>
    
</div>
@endsection

<script type="text/javascript">
    
    document.addEventListener('DOMContentLoaded', function() {
    
        const zipcodeDistanceVue = Vue.createApp({});
        zipcodeDistanceVue.component('zipcode-distance-component', {
            template: `
            
                <div class="form-group mb-0">
                    <label for="zipcode" class="font-xl">{{ __('Starting Point') }}</label>
                    <div class="input-group">
                        <input id="zipcode-input" name="zipcode" type="text" class="form-control" v-model="zipcode">
                        <span class="input-group-addon"><btn id="zipcode-btn" class="btn btn-admin" v-on:click="addZipcode(zipcode)">{{ __('Add Zipcode') }}</btn></span>
                    </div>
                    <div v-if="suggestions.length" class="suggestion-results" role="listbox">
                        <div v-for="suggestion in suggestions" v-text="suggestion.zipcode" class="result-link" v-on:click="addZipcode(suggestion.zipcode)"></div>
                    </div>
                </div>
                                  
                <div v-if="zipcodes.length" class="mt-3">
                    <div class="d-flex flex-column" class="font-xl">
                        <div v-for="(zipcode, key) in zipcodes" class="d-flex flex-row">     
                            <div class="mr-1">
                                <span v-text="zipcode"></span>
                            </div>
                            <div v-if="pullDistance(key)">
                                <span>{{ __('is') }}</span>
                                <span v-text="pullDistance(key)" class="mx-1"></span>
                                <span>{{ __('to the next destination') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-row">                        
                        <div v-if="zipcodes.length >= 2" class="mr-3">
                            <btn class="btn btn-admin" v-on:click="calculateDistance">{{ __('Calculate Distance') }}<btn>
                        </div>
                        <div v-if="zipcodes.length >= 1">                        
                            <btn v-if="zipcodes.length >= 1" class="btn btn-admin" v-on:click="reset">{{ __('Reset') }}<btn>
                        </div>
                    </div>          
                </div>
                                            
                                          
                <div v-if="awaiting" class="font-sm font-italic">
                    <span>{{ __('calculating') }}</span>
                    <span v-text="awaitingElipsis"></span>
                </div>
                <div v-if="isNumeric(timer)" class="font-sm font-italic">
                    <div v-if="timer < 1" class="d-flex flex-wrap">
                        <span>{{ __('Calculation took less than 1 second to complete') }}</span>
                    </div>
                    <div v-if="timer == 1" class="d-flex flex-wrap">
                        <span>{{ __('Calculation took') }}</span>
                        <span v-text="timer" class="mx-2"></span>
                        <span>{{ __('second to complete') }}</span>
                    </div>
                    <div v-if="timer > 1" class="d-flex flex-wrap">
                        <span>{{ __('Calculation took') }}</span>
                        <span v-text="timer" class="mx-2"></span>
                        <span>{{ __('seconds to complete') }}</span>
                    </div>
                </div>
                                    
            
            `,
            props: [],
            data() {
                return {
                    zipcode: null,
                    zipcodes: [],
                    distances: [],
                    suggestions: [],
                    timer: null,
                    interval: null,
                    awaiting: false,
                    awaitingElipsis: '...',
                }
            },
            created() {
                this.$root.$refs.zipcodeDistanceVue = this;
            },
            mounted() {
                this.events();
            },
            watch: {
                zipcode: debounce(function(value, oldValue) {
                    if (value) {
                        this.search();
                    } else {
                        this.suggestions = [];
                    }
                }, 500),
            },
            methods: {
                isLast(link) {
                    return (link === this.zipcodes[this.zipcodes.length - 1]);
                },
                isNumeric(value) {
                    return (typeof value === 'number') ? true : false;
                },
                addZipcode(zipcode) {
                    if (typeof zipcode === 'string' && zipcode.length) {
                        this.zipcodes.push(zipcode);
                        this.suggestions = [];
                        this.zipcode = null;
                    }
                },
                pullDistance(key) {
                    if (this.distances[key]) {
                        return this.distances[key].distance+' '+this.distances[key].unit;
                    }
                },
                reset() {
                    this.zipcodes = [];
                    this.suggestions = [];
                    this.timer = null;
                },
                search() {
                    $.ajax({
                        url: {!! json_encode(route('zipcode-search')) !!},
                        type: 'POST',
                        data: {
                            search: this.zipcode
                        },
                        success: function(response) {
                            if (response.success) {
                                this.suggestions = response.results;
                            }
                            this.$forceUpdate();
                        }.bind(this)
                    });
                },
                calculateDistance() {
                    $.ajax({
                        url: {!! json_encode(route('zipcode-distance')) !!},
                        type: 'POST',
                        data: {
                            zipcodes: this.zipcodes
                        },
                        success: function(response) {
                            if (response.success) {
                                this.distances = response.data;
                            }
                            this.$forceUpdate();
                        }.bind(this)
                    });
                },
                events() {
                    var input = document.getElementById('zipcode-input');
                    input.addEventListener('keyup', function(event) {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                            document.getElementById('zipcode-btn').click();
                        }
                    });
                },
            },
        });
        const zipcodeDistanceVueMount = zipcodeDistanceVue.mount('#zipcode-distance-component');
        
    });
    
</script>
