<template>
    <div class="popup-wrapper" :class="{'open': isOpen}">
		<div class="background" @click="close(true)"></div>
		<div class="content">
            <slot></slot>
        </div>
	</div>
</template>

<script>
    export default {
        data() {
            return {
                isOpen: false,
            }
        },
        
        methods: {
            open() {
                this.isOpen = true
            },
            
            close(shouldEmit = false) {
                this.isOpen = false

                if (shouldEmit) this.$emit('close')
            },
        },
    }
</script>

<style lang="sass" scoped>
    .popup-wrapper
        position: fixed
        z-index: 1000
        bottom: 0
        left: 0
        height: 100%
        width: 100%
        pointer-events: none

        &.open
            pointer-events: all

            .background
                opacity: 1
                
            .content
                transform: translate(-50%, 0)

        .background
            position: absolute
            bottom: 0
            left: 0
            height: 100%
            width: 100%
            background: rgba(0, 0, 0, 0.8)
            opacity: 0
            transition: all 300ms

        .content
            position: absolute
            bottom: 0
            max-height: calc(100% - 40px)
            overflow-y: auto
            left: 50%
            width: 100%
            max-width: 700px
            background: var(--color-background)
            padding-block: 20px
            border-radius: 15px 15px 0 0
            display: flex
            flex-direction: column
            transform: translate(-50%, 100%)
            transition: all 400ms cubic-bezier(0.4, 0, 0.2, 1)
</style>