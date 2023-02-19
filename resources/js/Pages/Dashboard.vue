<template>
  <div class="mt-[-165px]">
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
      <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500">Jobs Per Minute</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ parseInt(jobsPerMin) }}</dd>
      </div>

      <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500">Jobs Past Hour</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ jobsPastHour }}</dd>
      </div>

      <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
        <dt class="truncate text-sm font-medium text-gray-500">Failed Jobs Today</dt>
        <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ failedJobsToday }}</dd>
      </div>
    </dl>

    <div class="mt-16 flow-root">
      <div class="-my-2 -mx-6 overflow-x-auto lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
              <tr>
                <th scope="col" class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">
                  Queue
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-[200px]">
                  Currently In Queue
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-[200px]">
                  Processed Past Hour
                </th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 w-[200px]">
                  Failed Past Hour
                </th>
              </tr>
              </thead>
              <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="queue in queues">
                <td class="whitespace-nowrap py-4 pl-6 pr-3 text-sm font-medium text-gray-900">
                  {{ queue.name }}
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  {{ queue.queued }}
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  {{ queue.processed }}
                </td>
                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                  {{ queue.failed }}
                </td>
              </tr>

              <!-- More people... -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    jobsPerMin: Number,
    jobsPastHour: Number,
    failedJobsToday: Number,
    queues: Array
  },
  data() {
    return {
      int: null
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