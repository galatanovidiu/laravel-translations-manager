<template>
    <component :is="tag" :type="type" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150 transform hover:scale-110 cursor-pointer" :class="bgColor">
        <slot />
    </component>
</template>

<script>
export default {
    props: {
        tag: {
            type: String,
            default: 'button',
        },
        type: {
            type: String,
            default: 'submit',
        },
        bgColor: {
            type: String,
            default: 'bg-gray-800',
        },
    }
}
</script>
