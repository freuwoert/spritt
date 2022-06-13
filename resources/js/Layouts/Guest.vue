<template>
    <main>
        <slot />
    </main>
    <button id="add-button" @click="$emit('add')">add</button>
    <footer>
        <nav>
            <Link :href="route('drives')" :class="{'active': $page.url.startsWith('/drives')}">
                <div class="icon">route</div>
                <span class="label">Fahrten</span>
            </Link>
            <Link :href="route('cars')" :class="{'active': $page.url.startsWith('/cars')}">
                <div class="icon">directions_car</div>
                <span class="label">Autos</span>
            </Link>
            <Link :href="route('passengers')" :class="{'active': $page.url.startsWith('/passengers')}">
                <div class="icon">group</div>
                <span class="label">Mitfahrer</span>
            </Link>
        </nav>
    </footer>
</template>

<script setup>
    import { Link } from '@inertiajs/inertia-vue3'
    import { defineEmits } from 'vue'

    defineEmits(['add'])
</script>

<style lang="sass" scoped>
    main
        display: flex
        flex-direction: column

    #add-button
        position: fixed
        bottom: 5.5rem
        left: 50%
        z-index: 10
        transform: translateX(-50%)
        background: var(--color-primary)
        color: var(--color-background)
        border-radius: 50%
        border: none
        width: 3.5rem
        height: 3.5rem
        display: flex
        align-items: center
        justify-content: center
        font-size: 1.75rem
        font-family: var(--font-icon)
        transition: all 300ms
        cursor: pointer
        box-shadow: var(--shadow-elevation-medium)

    footer
        position: fixed
        bottom: 0
        left: 0
        z-index: 100
        width: 100%
        background-color: #fff
        box-shadow: var(--shadow-elevation-high)
        display: flex

        nav
            flex: 1
            display: flex
            align-items: center
            padding: .5rem
            height: 4.5rem

            a
                flex: 1
                height: 100%
                display: flex
                flex-direction: column
                align-items: center
                justify-content: center
                position: relative

                &.active::after
                    content: ""
                    position: absolute
                    top: 0
                    left: 0
                    width: 100%
                    height: 100%
                    background-color: currentColor
                    opacity: .1
                    pointer-events: none
                    border-radius: .325rem

                .icon
                    font-family: var(--font-icon)
                    font-size: 1.5rem
                    line-height: 1

                .label
                    font-size: .75rem
                    font-weight: 500
</style>