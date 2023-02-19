<template>
  <div v-if="status === 'processing'"
       class="w-2 h-2 rounded-full bg-orange-300 outline outline-4 outline-orange-500/20"></div>
  <div v-else-if="status === 'processed'"
       class="w-2 h-2 rounded-full bg-green-500 outline outline-4 outline-green-500/20"></div>
  <div v-else-if="status === 'failed'"
       class="w-2 h-2 rounded-full bg-red-500 outline outline-4 outline-red-500/20"></div>
</template>

<script>
export default {
  props: {
    status: String
  }
}
</script>