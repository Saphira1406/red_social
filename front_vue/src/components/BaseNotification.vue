<template>
    <div
        class="alert"
        :class="[`alert-${type}`]"
        v-if="text !== null"
    >
        <p class="mb-0">{{ text }}</p>
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
