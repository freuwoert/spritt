<template>
    <Head title="Mitfahrer" />
    
    <GuestLayout @add="openEditPopup()">
        <div class="item-wrapper">
            <div class="item flex gap v-center" v-for="passenger in passengers" :key="passenger.id" @click="openEditPopup(passenger)">
                <b>{{passenger.name}}</b>
                <div class="spacer"></div>
                <span @click.stop>
                    <mui-button type="button" size="small" color="error" variant="text" label="Löschen" @click="openDestroyPopup(passenger)" />
                </span>
            </div>
        </div>
        
        <Popup ref="editPopup">
            <form class="popup-form" @submit.prevent="save()">
                <mui-input type="text" no-border label="Name" v-model="editForm.name" />
                <mui-button type="submit" :label="editForm.id ? 'Speichern' : 'Erstellen'" :loading="editForm.processing"/>
            </form>
        </Popup>

        <Popup ref="destroyPopup">
            <form class="popup-form" @submit.prevent="destroy()">
                <mui-button type="submit" color="error" :label='`"` + destroyForm.name + `" Löschen`' :loading="destroyForm.processing"/>
            </form>
        </Popup>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'
    import Popup from '@/Components/Popup.vue'
    import { ref } from 'vue'



    defineProps({
        passengers: Array,
    })



    const editPopup = ref(null)

    const editForm = useForm({
        id: null,
        name: '',
    })

    const openEditPopup = (passenger = null) => {
        editForm.reset()
        editPopup.value.open()

        if (passenger?.id)
        {
            editForm.id = passenger.id
            editForm.name = passenger.name
        }
    }

    const save = () => {
        if (editForm.id)
        {
            editForm.put(route('passengers.update', {passenger: editForm.id}), {
                onSuccess() {
                    editForm.reset()
                    editPopup.value.close()
                },
            })
        }
        else
        {
            editForm.post(route('passengers.store'), {
                onSuccess() {
                    editForm.reset()
                    editPopup.value.close()
                },
            })
        }
    }



    const destroyPopup = ref(null)

    const destroyForm = useForm({
        id: null,
        name: '',
    })

    const openDestroyPopup = (passenger = null) => {
        destroyForm.reset()
        destroyPopup.value.open()
        destroyForm.id = passenger?.id
        destroyForm.name = passenger?.name
    }

    const destroy = () => {
        destroyForm.delete(route('passengers.destroy', {passenger: destroyForm.id}), {
            onSuccess() {
                destroyForm.reset()
                destroyPopup.value.close()
            },
        })
    }
</script>