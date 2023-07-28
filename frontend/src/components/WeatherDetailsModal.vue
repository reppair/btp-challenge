<template>
    <div class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" @click.away="">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

        <div class="fixed inset-0 z-10 overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-xl sm:p-6">
                    <div>
                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-sky-100">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-sky-900">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                            </svg>
                        </div>

                        <div class="mt-2 sm:mt-5">
                            <h3 class="text-base text-center font-semibold leading-6 text-gray-900" id="modal-title">Weather Report</h3>

                            <p class="text-xs text-center text-gray-500 mt-2">
                                Last updated at:
                                <br>
                                {{ toDateTimeString(weather.updated_at)  }}
                            </p>

                            <div class="border rounded p-4 mt-4">
                                <h4 class=" text-sm font-semibold leading-6 text-gray-900" id="modal-title">Current Weather</h4>

                                <dl class="mt-1 text-sm text-gray-600 inline-block mx-auto">
                                    <div class="flex space-x-2">
                                        <dt>Weather Conditions:</dt>
                                        <dd class="font-medium capitalize" v-text="weather.data.currentWeatherDesc"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Temperature (Kelvin):</dt>
                                        <dd class="font-medium" v-text="weather.data.currentTemp"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>UV Index:</dt>
                                        <dd class="font-medium" v-text="weather.data.currentUvi"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Wind Speed (m/s):</dt>
                                        <dd class="font-medium" v-text="weather.data.currentWindSpeed"></dd>
                                    </div>
                                </dl>

                                <h4 class="mt-4 text-sm font-semibold leading-6 text-gray-900" id="modal-title">Daily Forecast</h4>

                                <dl class="mt-1 text-sm text-gray-600 inline-block mx-auto">
                                    <div class="flex space-x-2">
                                        <dt>Summary:</dt>
                                        <dd class="font-medium" v-text="weather.data.dailySummary"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Minimum Temperature (Kelvin):</dt>
                                        <dd class="font-medium" v-text="weather.data.dailyTempMin"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Maximum Temperature (Kelvin):</dt>
                                        <dd class="font-medium" v-text="weather.data.dailyTempMax"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Day Temperature (Kelvin):</dt>
                                        <dd class="font-medium" v-text="weather.data.dailyTempDay"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Night Temperature (Kelvin):</dt>
                                        <dd class="font-medium" v-text="weather.data.dailyTempNight"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>UV Index:</dt>
                                        <dd class="font-medium" v-text="weather.data.dailyUvi"></dd>
                                    </div>

                                    <div class="flex space-x-2">
                                        <dt>Wind Speed (m/s):</dt>
                                        <dd class="font-medium" v-text="weather.data.dailyWindSpeed"></dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 sm:mt-4">
                        <button type="button"
                                class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                @click="$emit('closing')"
                        >
                            Go back to dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        weather: {
            required: true,
            type: Object,
        },
    },

    methods: {
        toDateTimeString(value) {
            return (new Date(value)).toString()
        },
    },
}
</script>
