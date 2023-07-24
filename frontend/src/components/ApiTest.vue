<script>

import WeatherDetailsModal from "@/components/WeatherDetailsModal.vue"

export default {
  components: {WeatherDetailsModal},

  data: () => ({
    apiResponse: null,
    user: null,
  }),

  created() {
    this.fetchData()
  },

  methods: {
    async fetchData() {
      const url = 'http://localhost/'
      this.apiResponse = await (await fetch(url)).json()
    },

    showWeatherDetails(user) {
      if (! user.weather) {
        return
      }

      this.user = user;
    }
  }
}
</script>

<template>
    <div v-if="!apiResponse">
        Pinging the api...
    </div>

    <div v-if="apiResponse">
        <ul role="list" class="divide-y divide-gray-100">
            <li class="relative py-5 hover:bg-gray-50 group"
                v-for="user in apiResponse.users"
                @click="showWeatherDetails(user)"
            >
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="mx-auto flex max-w-4xl justify-between gap-x-6">
                        <div class="flex gap-x-4">
                            <div class="h-12 w-12 flex-none rounded-full bg-gray-50 ring-1 ring-gray-300">
                                <svg class="h-8 w-8 mt-2 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                </svg>
                            </div>

                            <div class="min-w-0 flex-auto">
                                <p class="text-sm font-semibold leading-6 text-gray-900">
                                    <a href="#">
                                        <span class="absolute inset-x-0 -top-px bottom-0"></span>
                                        <span v-text="user.name"></span>
                                    </a>
                                </p>

                                <p class="mt-1 flex text-xs leading-5 text-gray-500">
                                    <a :href="`mailto:${user.email}`" class="relative truncate hover:underline" v-text="user.email"></a>
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-x-4" v-if="user.weather">
                            <div class="hidden sm:flex sm:flex-col sm:items-end">
                                <p class="text-sm leading-6 text-gray-900 z-10 cursor-help"
                                   v-text="user.weather.data.timezone"
                                   :title="'Timezone of the user. To be replaced later with the actual area name by using Reverse Geo Location API.'"
                                ></p>

                                <div class="mt-1 text-xs leading-5 text-gray-500">
                                    <span>{{ user.weather.data.currentTemp }} (kelvin)</span>,
                                    <span class="capitalize" v-text="user.weather.data.currentWeatherDesc"></span>
                                </div>
                            </div>

                            <svg class="h-5 w-5 flex-none text-gray-400 group-hover:ml-2 group-hover:-mr-2 transition-all" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                            </svg>
                        </div>

                        <div class="flex items-center gap-x-4" v-else>
                            <p class="text-xs leading-5 text-gray-500">No weather data.</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <WeatherDetailsModal v-if="user" :weather="user.weather" v-on:closing="this.user = null" />
</template>
