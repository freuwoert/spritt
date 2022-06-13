<template>
    <Head title="Autos" />
    
    <GuestLayout @add="openEditPopup()">
        <div class="item-wrapper">
            <div class="item flex gap v-center" v-for="car in cars" :key="car.id" @click="openEditPopup(car)">
                <div class="flex flex-1 vertical">
                    <b>{{car.name}}</b>
                    <div class="flex v-center">
                        <small class="flex-1">{{formatDecimal(car.consumption)}} L / 100km</small>
                        <small class="flex-1">{{car.fuel_type.toUpperCase()}}</small>
                    </div>
                </div>
                <span @click.stop>
                    <mui-button type="button" size="small" variant="text" color="error" label="Löschen" @click="openDestroyPopup(car)" />
                </span>
            </div>
        </div>
        
        <Popup ref="editPopup">
            <form class="popup-form" @submit.prevent="save()">
                <mui-input type="text" no-border label="Name" v-model="editForm.name" />
                <input type="number" step="0.1" min="0" max="20" v-model="editForm.consumption" />
                <select v-model="editForm.fuel_type">
                    <option value="e10">E10</option>
                    <option value="e5">E5</option>
                    <option value="diesel">Diesel</option>
                </select>
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
        cars: Array,
    })



    const formatDecimal = (value) => {
        return value.toFixed(1).replace('.', ',')
    }



    const editPopup = ref(null)

    const editForm = useForm({
        id: null,
        name: '',
        consumption: 5.0,
        fuel_type: 'e10',
    })

    const openEditPopup = (car = null) => {
        editForm.reset()
        editPopup.value.open()

        if (car?.id)
        {
            editForm.id = car.id
            editForm.name = car.name
            editForm.consumption = car.consumption
            editForm.fuel_type = car.fuel_type
        }
    }

    const save = () => {
        if (editForm.id)
        {
            editForm.put(route('cars.update', {car: editForm.id}), {
                onSuccess() {
                    editForm.reset()
                    editPopup.value.close()
                },
            })
        }
        else
        {
            editForm.post(route('cars.store'), {
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

    const openDestroyPopup = (car = null) => {
        destroyForm.reset()
        destroyPopup.value.open()
        destroyForm.id = car?.id
        destroyForm.name = car?.name
    }

    const destroy = () => {
        destroyForm.delete(route('cars.destroy', {car: destroyForm.id}), {
            onSuccess() {
                destroyPopup.value.close()
            },
        })
    }
</script>