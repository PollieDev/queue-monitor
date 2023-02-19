<template>
  <div class="min-h-full">
    <div class="bg-gray-800 pb-32">
      <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="border-b border-gray-700">
            <div class="flex h-16 items-center justify-between px-4 sm:px-0">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M9.638 1.093a.75.75 0 01.724 0l2 1.104a.75.75 0 11-.724 1.313L10 2.607l-1.638.903a.75.75 0 11-.724-1.313l2-1.104zM5.403 4.287a.75.75 0 01-.295 1.019l-.805.444.805.444a.75.75 0 01-.724 1.314L3.5 7.02v.73a.75.75 0 01-1.5 0v-2a.75.75 0 01.388-.657l1.996-1.1a.75.75 0 011.019.294zm9.194 0a.75.75 0 011.02-.295l1.995 1.101A.75.75 0 0118 5.75v2a.75.75 0 01-1.5 0v-.73l-.884.488a.75.75 0 11-.724-1.314l.806-.444-.806-.444a.75.75 0 01-.295-1.02zM7.343 8.284a.75.75 0 011.02-.294L10 8.893l1.638-.903a.75.75 0 11.724 1.313l-1.612.89v1.557a.75.75 0 01-1.5 0v-1.557l-1.612-.89a.75.75 0 01-.295-1.019zM2.75 11.5a.75.75 0 01.75.75v1.557l1.608.887a.75.75 0 01-.724 1.314l-1.996-1.101A.75.75 0 012 14.25v-2a.75.75 0 01.75-.75zm14.5 0a.75.75 0 01.75.75v2a.75.75 0 01-.388.657l-1.996 1.1a.75.75 0 11-.724-1.313l1.608-.887V12.25a.75.75 0 01.75-.75zm-7.25 4a.75.75 0 01.75.75v.73l.888-.49a.75.75 0 01.724 1.313l-2 1.104a.75.75 0 01-.724 0l-2-1.104a.75.75 0 11.724-1.313l.888.49v-.73a.75.75 0 01.75-.75z"></path>
                  </svg>
                </div>
                <div class="hidden md:block">
                  <div class="ml-10 flex items-baseline space-x-4">
                    <Link :href="is(item.href) ? undefined : item.href" v-for="item in navItems" :key="item.href"
                          :class="is(item.href) ? 'bg-gray-900' : ''"
                       class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">
                      {{ item.name }}
                    </Link>
                  </div>
                </div>
              </div>
              <div class="-mr-2 flex md:hidden">
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                        class="inline-flex items-center justify-center rounded-md bg-gray-800 p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
                        aria-controls="mobile-menu" aria-expanded="false">
                  <span class="sr-only">Open main menu</span>

                  <svg v-if="!mobileMenuOpen" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                       stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                  </svg>
                  <svg v-else class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                       stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>

        <div class="border-b border-gray-700 md:hidden" id="mobile-menu" v-if="mobileMenuOpen">
          <div class="space-y-1 px-2 py-3 sm:px-3">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <Link :href="item.href" v-for="item in navItems" :key="item.href"
                  class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">
              {{ item.name }}
            </Link>
          </div>
        </div>
      </nav>
      <header class="py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between">
          <h1 class="text-3xl font-bold tracking-tight text-white">
            {{ $page.props.title || 'Dashboard' }}
          </h1>
          <div v-if="$page.props.filters" class="flex items-center">
            <div class="mr-3 text-center w-40">
              <select v-model="$root.status" class="bg-transparent focus:outline-none border-b-2 border-gray-500 border-dashed font-semibold text-gray-500 pr-3">
                <option value="">All</option>
                <option value="processing">Processing</option>
                <option value="processed">Processed</option>
                <option value="failed">Failed</option>
              </select>
              <div class="flex justify-center">
                <p class="cursor-pointer text-xs mt-1 py-1 px-2 rounded-full"
                   :class="$root.withSilenced ? 'bg-green-500/30 text-green-300' : 'bg-red-500/30 text-red-300'"
                   @click="$root.withSilenced = !$root.withSilenced">
                  {{ $root.withSilenced ? 'With Silenced Jobs' : 'Without Silenced Jobs' }}
                </p>
              </div>
            </div>
            <input class="rounded-lg bg-gray-700 focus:outline-none px-3 py-2 placeholder-gray-500 text-gray-100 font-semibold"
                   placeholder="Search..." v-model="$root.search"/>
          </div>
        </div>
      </header>
    </div>

    <main class="-mt-32">
      <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
        <slot/>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      mobileMenuOpen: false
    }
  },
  computed: {
    navItems() {
      return [
        {
          name: 'Dashboard',
          href: '/queue-monitor'
        },
        {
          name: 'Jobs',
          href: '/queue-monitor/jobs'
        },
        {
          name: 'Activity',
          href: '/queue-monitor/activity'
        }
      ]
    }
  },
  methods: {
    is(route) {
      return window.location.pathname === route;
    }
  },
  watch: {
    '$page.url': function (newUrl, oldUrl) {
      const newUrlWithoutQuery = newUrl.split('?')[0];
      const oldUrlWithoutQuery = oldUrl.split('?')[0];

      if (newUrlWithoutQuery !== oldUrlWithoutQuery) {
        this.mobileMenuOpen = false;
        this.$root.search = '';
        this.$root.status = '';
        this.$root.withSilenced = '';
        this.$forceUpdate();
      }
    }
  }
}
</script>