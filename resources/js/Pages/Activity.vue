<template>
  <div class="rounded-lg bg-white shadow overflow-hidden">
    <div class="grid grid-cols-5 bg-gray-100 font-semibold py-2 text-gray-700 text-sm px-6 space-x-4">
      <div class="col-span-2">Job</div>
      <div>Runtime</div>
      <div>Started At</div>
      <div>Jobs in queue</div>
<!--      <div>Avg Time</div>-->
<!--      <div>Avg Attempts</div>-->
    </div>
    <div v-if="!jobs.data.length" class="p-6 text-center font-bold text-gray-400 select-none">
      No results found...
    </div>
    <div class="grid grid-cols-5 py-3 px-6 space-x-4 hover:bg-gray-50 group"
         v-for="job in jobs.data" :key="job.id">
      <div class="col-span-2">
        <div class="flex items-center">
          <StatusBadge :status="job.status" class="mr-4"/>
          <Link :href="`/queue-monitor/activity/${job.id}`"
                class="font-semibold text-gray-800 text-sm group-hover:underline">{{ job.job_name }}</Link>
        </div>
        <div class="flex items-center space-x-4 text-xs mt-2 text-gray-400">
          <p>Connection: <span class="font-semibold">{{ job.connection }}</span></p>
          <p>Queue: <span class="font-semibold">{{ job.queue }}</span></p>
          <p>Max Tries: <span class="font-semibold">{{ job.max_tries }}</span></p>
        </div>
      </div>
      <div class="flex items-center text-gray-600 font-semibold text-sm">
        {{ job.finished_at ? (job.finished_at - job.started_at) / 1000 : 'Running...' }}s
      </div>
      <div class="flex items-center text-gray-600 text-sm">
        {{ moment(job.started_at).format('YYYY-MM-DD HH:mm:ss') }} <br>
<!--        {{ job.finished_at ? moment(job.finished_at).format('YYYY-MM-DD HH:mm:ss') : 'Running...' }}-->
      </div>
      <div class="flex items-center text-gray-600 font-semibold text-sm">{{ job.pending_jobs }} in queue</div>
<!--      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ job.failed }}</div>-->
<!--      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ (parseInt(job.avg_time) / 1000).toFixed(2) }}s</div>-->
<!--      <div class="flex justify-end items-center text-gray-600 font-semibold">{{ parseFloat(job.avg_attempts).toFixed(2) }}x</div>-->
    </div>

    <Pagination :links="jobs.links" class="mb-4 mx-6"/>
  </div>
</template>

<script>
import moment from "moment";
import Pagination from "../Components/Pagination.vue";
import StatusBadge from "../Components/StatusBadge.vue";
export default {
  components: {StatusBadge, Pagination},
  props: {
    jobs: Object
  },
  data() {
    return {
      int: null
    }
  },
  methods: {
    moment,
    fetch() {
      this.$inertia.reload({
        only: ['jobs'],
        data: {
          search: this.$root.search || undefined,
          status: this.$root.status || undefined,
          'with-silenced': this.$root.withSilenced || undefined
        }
      })
    }
  },
  watch: {
    '$root.search': function (val) {
      this.fetch()
    },
    '$root.status': function (val) {
      this.fetch()
    },
    '$root.withSilenced': function (val) {
      this.fetch()
    }
  },
  mounted() {
    this.int = setInterval(this.fetch, 3000)
  },
  beforeDestroy() {
    clearInterval(this.int)
  }
}
</script>