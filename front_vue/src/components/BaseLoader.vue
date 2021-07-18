<template>
  <span
    class="loader"
    :class="{
      'loader-small': size === 'small'
    }"
  >
    <i></i>
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
