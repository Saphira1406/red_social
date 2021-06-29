<template>
  <!--
    <div
        class="alert"
        :class="[`alert-${type}`]"
        v-if="text !== null"
    >
        <p class="mb-0">{{ text }}</p>
    </div>
    -->
  <div
    class="alert alert-dismissible fade show"
    :class="[`alert-${type}`]"
    v-if="text !== null"
    role="alert"
  >
    <p class="mb-0">{{ text }}</p>
    <button
      type="button"
      class="close"
      data-dismiss="alert"
      aria-label="Cerrar"
    >
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
</template>

<script>
export default {
  name: 'BaseNotification',
  // A través de "props" configuramos las propiedades que este componente puede recibir.
  // Recordemos que las "propiedades" son los atributos de HTML que le ponemos al componente.
  // props: ['text', 'type'],
  props: {
    text: {
      type: String,
      required: true,
    },
    type: {
      type: String,
      default: 'info'
    }
  }
}
</script>
