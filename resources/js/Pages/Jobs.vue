<template>
  <div class="rounded-lg bg-white shadow overflow-hidden">
    <div class="grid grid-cols-8 bg-gray-100 font-semibold py-2 text-gray-700 text-sm px-6 space-x-4 text-right">
      <div class="col-span-3 text-left">Job</div>
      <div>Processing</div>
      <div>Processed</div>
      <div>Failed</div>
      <div>Avg Time</div>
      <div>Avg Attempts</div>
    </div>
    <div class="grid grid-cols-8 py-3 px-6 space-x-4 text-right hover:bg-gray-50"
         v-for="job in jobsFiltered" :key="job.job_name">
      <div class="col-span-3 text-left">
        <div class="flex items-center">
          <StatusBadge :status="job.status" class="mr-4"/>
          <p class="font-semibold text-gray-800 text-sm">{{ job.job_name }}</p>
        </div>
        <div class="flex items-center space-x-4 text-xs mt-2 text-gray-400">
          <p>Connection: <span class="font-semibold">{{ job.connection }}</span></p>
          <p>Queue: <span class="font-semibold">{{ job.queue }}</span></p>
          <p>Max Tries: <span class="font-semibold">{{ job.max_tries }}</span></p>
        </div>
      </div>
      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ job.processing }}</div>
      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ job.processed }}</div>
      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ job.failed }}</div>
      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ (parseInt(job.avg_time) / 1000).toFixed(2) }}s</div>
      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ parseFloat(job.avg_attempts).toFixed(2) }}x</div>
    </div>
  </div>
</template>

<script>
import StatusBadge from "../Components/StatusBadge.vue";

export default {
  components: {StatusBadge},
  props: {
    jobs: Array
  },
  data() {
    return {
      int: null
    }
  },
  computed: {
    jobsFiltered() {
      return this.jobs.filter(job => {
        if (this.$root.search && !job.job_name.toLowerCase().includes(this.$root.search.toLowerCase()))
          return false;

        if (this.$root.status && this.$root.status !== job.status)
          return false;

        if (!this.$root.withSilenced && job.silenced)
          return false;

        return true;
      })
    }
  },
  mounted() {
    this.int = setInterval(() => {
      this.$inertia.reload()
    }, 3000)
  },
  beforeDestroy() {
    clearInterval(this.int)
  }
}
</script>