<template>
  <div class="space-y-4">
    <div class="rounded-lg bg-white shadow overflow-hidden">
      <div class="bg-gray-100 px-4 py-3 font-semibold flex items-center">
        <StatusBadge :status="job.status" class="mr-4"/>
        {{ job.job_name }}
      </div>
      <div class="p-4">
        <table class="border-spacing-2">
          <tr>
            <td class="w-1/3 text-gray-400 py-1">ID</td>
            <td class="w-2/3">{{ job.id }}</td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">Connection</td>
            <td class="w-2/3">{{ job.connection }}</td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">Queue</td>
            <td class="w-2/3">{{ job.queue }}</td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">Attempts</td>
            <td class="w-2/3">{{ job.attempts }} <sup>/ {{ job.max_tries }}</sup></td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">Host</td>
            <td class="w-2/3">{{ job.hostname }}</td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">PHP Version</td>
            <td class="w-2/3">{{ job.php }}</td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">Started At</td>
            <td class="w-2/3">{{ moment(job.started_at).format('YYYY-MM-DD HH:mm:ss') }}</td>
          </tr>
          <tr>
            <td class="w-1/3 text-gray-400 py-1">{{ job.status === 'failed' ? 'Failed' : 'Finished' }} At</td>
            <td class="w-2/3">{{ moment(job.finished_at).format('YYYY-MM-DD HH:mm:ss') }}</td>
          </tr>
        </table>
      </div>
    </div>

    <div class="rounded-lg bg-white shadow overflow-hidden" v-if="job.exception">
      <div class="bg-gray-100 px-4 py-3 font-semibold">
        Exception
      </div>
      <div class="p-4">
        <pre class="text-sm text-gray-700 overflow-x-auto">
<span class="text-red-400 font-semibold">{{ jobException.message }}</span>
<span class="italic">{{ jobException.file }}:{{ jobException.line }}</span>

<span class="italic">Trace:</span>
{{ jobException.trace }}
        </pre>
      </div>
    </div>

    <div class="rounded-lg bg-white shadow overflow-hidden" v-if="job.payload">
      <div class="bg-gray-100 px-4 py-3 font-semibold">
        Job Payload
      </div>
      <div class="p-4">
        <pre class="text-sm text-gray-700 overflow-x-auto">
{{ JSON.stringify(JSON.parse(job.payload), null, 2) }}
        </pre>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import StatusBadge from "../Components/StatusBadge.vue";
export default {
  components: {StatusBadge},
  props: {
    job: Object
  },
  computed: {
    jobException() {
      return JSON.parse(this.job.exception)
    },
  },
  methods: {
    moment,
  }
}
</script>