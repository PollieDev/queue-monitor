<template>
  <nav class="flex items-center justify-between border-t border-gray-200 px-4 sm:px-0 select-none"
       v-if="links.length > 3">
    <div class="-mt-px flex w-0 flex-1">
      <Link :href="previous.url" preserve-scroll class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
        <svg class="mr-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M18 10a.75.75 0 01-.75.75H4.66l2.1 1.95a.75.75 0 11-1.02 1.1l-3.5-3.25a.75.75 0 010-1.1l3.5-3.25a.75.75 0 111.02 1.1l-2.1 1.95h12.59A.75.75 0 0118 10z" clip-rule="evenodd" />
        </svg>
        Previous
      </Link>
    </div>
    <div class="hidden md:-mt-px md:flex">
      <template v-for="(link, key) in numbers">
        <Link v-if="link.url" preserve-scroll :href="link.url" v-html="link.label" :key="key"
              :class="link.active ? 'border-gray-800 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
              class="inline-flex items-center border-t-2 px-4 pt-4 text-sm font-medium"></Link>
        <span v-else :key="key" v-html="link.label"
              class="inline-flex items-center border-t-2 border-transparent px-4 pt-4 text-sm font-medium text-gray-500"/>
      </template>
   </div>
    <div class="-mt-px flex w-0 flex-1 justify-end">
      <Link :href="next.url" preserve-scroll class="inline-flex items-center border-t-2 border-transparent pt-4 pl-1 text-sm font-medium text-gray-500 hover:border-gray-300 hover:text-gray-700">
        Next
        <svg class="ml-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
          <path fill-rule="evenodd" d="M2 10a.75.75 0 01.75-.75h12.59l-2.1-1.95a.75.75 0 111.02-1.1l3.5 3.25a.75.75 0 010 1.1l-3.5 3.25a.75.75 0 11-1.02-1.1l2.1-1.95H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
        </svg>
      </Link>
    </div>
  </nav>
</template>

<script>
export default {
  props: {
    links: Array,
  },
  computed: {
    previous() {
      return this.links[0];
    },
    next() {
      return this.links[this.links.length - 1];
    },
    numbers() {
      return this.links.slice(1, -1);
    },
  }
}
</script>