<template>
  <span class="outer-loader">
    <i class="loader"></i>
  </span>
</template>

<script>
export default {
  name: 'BaseLoader',
  props: {
    size: {
      type: String,
      default: 'normal',
      validator: function (value) {
        return ['normal', 'small'].includes(value);
      }
    }
  }
}
</script>
