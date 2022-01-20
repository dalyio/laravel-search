@extends('layout.app')

@section('content')
<div class="d-flex flex-wrap p-3 gap-1">
    <div class="card card-widget" style="width: calc(50% - 1rem)">
        <div class="card-body">
            <div class="card-title">
                <span>{{ __('Number Chains - Sum of Square of Digits') }}</span>
            </div>
            <div>
                <blockquote>
                  <pre>
                    <code>{{"
public function numberChain(\$number)
{
    \$chain = [\$number];
    \$numberChain = function(\$number) use(&\$chain, &\$numberChain) {

        // Split into digits and get the sum of square of digits
        \$newNumber = array_sum(array_map(function(\$digit) {
            return pow(\$digit, 2);
        }, str_split(\$number)));

        \$chain[] = \$newNumber;

        // Break if number is either 1 or 89
        if ((\$newNumber === 1) || (\$newNumber === 89)) {
            return \$chain;
        }

        // Calculate next number in number chain
        return \$numberChain(\$newNumber);
    };

    return \$numberChain(\$number);
}
                    "}}</code>
                  </pre>
                </blockquote>  
            </div>
            <div id="test-numberchain-component">
                <test-numberchain-component></test-numberchain-component>
            </div>
        </div>
    </div>
    <div class="card card-widget" style="width: 50%">
        <div class="card-body">
            <div class="card-title">
                <span>{{ __('How Many Arrive At 89?') }}</span>
            </div>
            <div class="codeblock">
                <blockquote>
                  <pre>
                    <code>{{"
public function arrivesAt(\$limit, \$arrivalNumber = 89)
{
    \$result = 0;
    for (\$n = 1; \$n <= \$limit; \$n++) {

        \$arrivesAt = function(\$number) use(&\$arrivesAt) {

            // Split into digits and get the sum of square of digits
            \$newNumber = array_sum(array_map(function(\$digit) {
                return pow(\$digit, 2);
            }, str_split(\$number)));

            // Break if number is either 1 or 89
            if ((\$newNumber === 1) || (\$newNumber === 89)) {
                return \$newNumber;
            }

            // Calculate next number in number chain
            return \$arrivesAt(\$newNumber);
        };

        if (\$arrivesAt(\$n) == \$arrivalNumber) \$result++;
    }

    return \$result;
}
                    "}}</code>
                  </pre>
                </blockquote>  
            </div>
            <div>
                <div id="test-problem-component" class="align-self-end">
                    <test-problem-component></test-problem-component>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script type="text/javascript">
    
    document.addEventListener('DOMContentLoaded', function() {
    
        const testNumberchainVue = Vue.createApp({});
        testNumberchainVue.component('test-numberchain-component', {
            template: `
                <div class="form-group">
                    <label for="test_numberchain" class="font-xl">{{ __('Test It') }}</label>
                    <div class="input-group">
                        <input id="test-numberchain-input" name="starting_number" type="text" class="form-control" v-model="number">
                        <span class="input-group-addon"><btn id="test-numberchain-btn" class="btn btn-admin" v-on:click="submit">{{ __('Submit') }}</btn></span>
                    </div>
                </div>
                <div v-if="numberchain.length" class="mt-3">
                    <div class="d-flex flex-wrap" class="font-lg">
                        <div v-for="link in numberchain">
                            <span v-text="link"></span>
                            <span v-if="!isLast(link)" class="px-2">
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
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
                    number: null,
                    numberchain: [],
                    timer: null,
                }
            },
            created() {
                this.$root.$refs.testNumberchainVue = this;
            },
            mounted() {
                this.events();
            },
            watch: {
                number(value, oldValue) {
                    this.reset();
                },
            },
            methods: {
                isLast(link) {
                    return (link === this.numberchain[this.numberchain.length - 1]);
                },
                isNumeric(value) {
                    return (typeof value === 'number') ? true : false;
                },
                reset() {
                    this.numberchain = [];
                    this.timer = null;
                },
                submit() {
                    $.ajax({
                        url: {!! json_encode(route('test-numberchain')) !!},
                        type: 'POST',
                        data: {
                            number: this.number
                        },
                        success: function(response) {
                            if (response.success) {
                                this.numberchain = response.numberchain;
                                this.timer = response.timer;
                            }
                            this.$forceUpdate();
                        }.bind(this)
                    });
                },
                events() {
                    var input = document.getElementById('test-numberchain-input');
                    input.addEventListener('keyup', function(event) {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                            document.getElementById('test-numberchain-btn').click();
                        }
                    });
                },
            },
        });
        const testNumberchainVueMount = testNumberchainVue.mount('#test-numberchain-component');
        
    });
    
</script>

<script type="text/javascript">
    
    document.addEventListener('DOMContentLoaded', function() {
    
        const testProblemVue = Vue.createApp({});
        testProblemVue.component('test-problem-component', {
            template: `
                <div class="form-group" class="mb-1">
                    <label for="test_problem" class="font-xl">{{ __('Test It') }}</label>
                    <div class="input-group">
                        <input id="test-problem-input" name="test_limit" type="text" class="form-control" v-model="testLimit">
                        <span class="input-group-addon"><btn id="test-problem-btn" class="btn btn-admin" v-on:click="submit">{{ __('Submit') }}</btn></span>
                    </div>
                </div>
                <div v-if="result" class="mt-3">
                    <div class="d-flex flex-wrap" class="font-lg">
                        <span>{{ __('The number chains for numbers at or below') }}</span>
                        <span v-text="testLimit" class="mx-2"></span>
                        <span>{{ __('arrive at') }}</span>
                        <span v-text="arrivalNumber" class="mx-2"></span>
                        <span>{{ __('a total of') }}</span>
                        <span v-text="result" class="mx-2"></span>
                        <span>{{ __('times') }}</span>
                    </div>
                </div>
                <div v-if="awaiting" class="font-sm font-italic">
                    <span>{{ __('calculating') }}</span>
                    <span v-text="awaitingElipsis"></span>
                </div>
                <div v-if="timer" class="font-sm font-italic">
                    <div v-if="timer < 1" class="d-flex flex-wrap">
                        <span>{{ __('calculation took less than 1 second to complete') }}</span>
                    </div>
                    <div v-if="timer == 1" class="d-flex flex-wrap">
                        <span>{{ __('calculation took') }}</span>
                        <span v-text="timer" class="mx-1"></span>
                        <span>{{ __('second to complete') }}</span>
                    </div>
                    <div v-if="timer > 1" class="d-flex flex-wrap">
                        <span>{{ __('calculation took') }}</span>
                        <span v-text="timer" class="mx-1"></span>
                        <span>{{ __('seconds to complete') }}</span>
                    </div>
                </div>
            `,
            props: [],
            data() {
                return {
                    arrivalNumber: 89,
                    testLimit: null,
                    result: null,
                    timer: null,
                    interval: null,
                    awaiting: false,
                    awaitingElipsis: '...',
                }
            },
            created() {
                this.$root.$refs.testProblemVue = this;
            },
            mounted() {
                this.events();
            },
            watch: {
                testLimit(value, oldValue) {
                    this.reset();
                },
                awaiting(value, oldValue) {
                    if (value) {
                        this.interval = setInterval(function() {
                            if (this.awaitingElipsis.length === 3) {
                                this.awaitingElipsis = '';
                            } else {
                                this.awaitingElipsis += '.';
                            }
                        }.bind(this), 1000);
                    } else {
                        clearInterval(this.interval);
                    }
                },
            },
            computed: {
                
            },
            methods: {
                reset() {
                    this.result = null;
                    this.timer = null;
                    this.awaiting = false;
                },
                submit() {
                    $.ajax({
                        url: {!! json_encode(route('test-problem')) !!},
                        type: 'POST',
                        data: {
                            arrival_number: this.arrivalNumber,
                            test_limit: this.testLimit
                        },
                        success: function(response) {
                            if (response.success) {
                                this.result = response.result;
                                this.timer = response.timer;
                            }
                            this.$forceUpdate();
                        }.bind(this),
                        beforeSend: function() {
                            this.reset();
                            this.awaiting = true;
                        }.bind(this),
                        complete: function(response) {
                            this.awaiting = false;
                        }.bind(this),
                    });
                },
                events() {
                    var input = document.getElementById('test-problem-input');
                    input.addEventListener('keyup', function(event) {
                        if (event.keyCode === 13) {
                            event.preventDefault();
                            document.getElementById('test-problem-btn').click();
                        }
                    });
                },
            },
        });
        const testProblemVueMount = testProblemVue.mount('#test-problem-component');
        
    });
    
</script>
