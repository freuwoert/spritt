<template>
    <Head title="Fahrten" />
    
    <GuestLayout @add="openEditPopup()">
        <div class="item-wrapper big-items">
            <div class="car-item item flex vertical" v-for="car in drivesGroupedByCar" :key="car.id">
                <h3>{{car.name}}</h3>
                <div class="item-wrapper sub-wrapper">
                    <div class="item flex gap v-center" v-for="drive in car.drives" :key="drive.id" @click="openEditPopup(drive)">
                        <div class="flex flex-1 vertical">
                            <span>
                                <b>{{formatDecimal(drive.distance)}} km</b> • <small>{{formatDecimal(drive.consumption)}} L</small>
                            </span>
                            <small class="drive-passenger-names">{{drive.passengers.map(e => e.name).join(', ')}}</small>
                        </div>
                        <span @click.stop>
                            <mui-button type="button" size="small" variant="text" color="error" label="Löschen" @click="openDestroyPopup(drive)" />
                        </span>
                    </div>
                </div>
                <hr>
                <div class="item-wrapper sub-wrapper">
                    <div class="item flex gap v-center" v-for="passenger in car.passengers" :key="passenger.id">
                        <b class="flex-6">{{passenger.name}}</b>
                        <small class="flex-2" style="text-align: right">{{formatDecimal(passenger.liters)}} L</small>
                        <b class="flex-3" style="text-align: right">{{formatDecimal(passenger.liters * fuelPrice(car.fuel_type))}} €</b>
                    </div>
                </div>
            </div>
        </div>

        
        <Popup ref="editPopup">
            <form class="popup-form" @submit.prevent="save()">
                <select v-model="editForm.car_id">
                    <option :value="car.id" v-for="car in cars" :key="car.id">{{car.name}}</option>
                </select>
                <input type="number" step="0.1" min="0" v-model="editForm.distance" />
                <select v-model="editForm.passengers" multiple>
                    <option :value="passenger.id" v-for="passenger in passengers" :key="passenger.id">{{passenger.name}}</option>
                </select>
                <mui-button type="submit" :label="editForm.id ? 'Speichern' : 'Erstellen'" :loading="editForm.processing"/>
            </form>
        </Popup>

        <Popup ref="destroyPopup">
            <form class="popup-form" @submit.prevent="destroy()">
                <mui-button type="submit" color="error" label='Fahrt Löschen' :loading="destroyForm.processing"/>
            </form>
        </Popup>
    </GuestLayout>
</template>

<script setup>
    import { Head, Link, useForm } from '@inertiajs/inertia-vue3'
    import GuestLayout from '@/Layouts/Guest.vue'
    import Popup from '@/Components/Popup.vue'
    import { ref, computed } from 'vue'



    const props = defineProps({
        drives: Array,
        passengers: Array,
        cars: Array,
    })



    const formatDecimal = (value) => {
        return value.toFixed(2).replace('.', ',')
    }

    const fuelPrice = (fuelType) => {
        switch (fuelType)
        {
            case 'diesel': return 2.019
            case 'e10': return 1.919
            case 'e5': return 1.979
        }
    }



    const drivesGroupedByCar = computed(() => {
        const groups = {}
        
        for (const drive of props.drives)
        {
            if (!groups[drive.car_id])
            {
                groups[drive.car_id] = {id: drive.car_id, name: drive.car.name, fuel_type: drive.car.fuel_type, drives: [], passengers: {}}
            }

            groups[drive.car_id].drives.push(drive)


            
            let litersPerPassenger = drive.consumption / drive.total_passengers

            for (const passenger of drive.passengers)
            {
                if (!groups[drive.car_id].passengers[passenger.id])
                {
                    groups[drive.car_id].passengers[passenger.id] = {id: passenger.id, name: passenger.name, liters: 0}
                }

                groups[drive.car_id].passengers[passenger.id].liters += litersPerPassenger
            }
        }

        return groups
    })



    const editPopup = ref(null)

    const editForm = useForm({
        id: null,
        car_id: null,
        distance: 1.0,
        passengers: [],
    })

    const openEditPopup = (drive = null) => {
        editForm.reset()
        editPopup.value.open()

        if (drive?.id)
        {
            editForm.id = drive.id
            editForm.car_id = drive.car_id
            editForm.distance = drive.distance
            editForm.passengers = drive.passengers.map(e => e.id)
        }
    }

    const save = () => {
        if (editForm.id)
        {
            editForm.put(route('drives.update', {drive: editForm.id}), {
                onSuccess() {
                    editForm.reset()
                    editPopup.value.close()
                },
            })
        }
        else
        {
            editForm.post(route('drives.store'), {
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
    })

    const openDestroyPopup = (drive = null) => {
        destroyForm.reset()
        destroyPopup.value.open()
        destroyForm.id = drive?.id
    }

    const destroy = () => {
        destroyForm.delete(route('drives.destroy', {drive: destroyForm.id}), {
            onSuccess() {
                destroyPopup.value.close()
            },
        })
    }
</script>

<style lang="sass" scoped>
    select[multiple]
        height: 10rem

    .car-item
        h3
            padding-inline: 1rem
            margin-top: .75rem

    .drive-passenger-names
            white-space: nowrap
            overflow: hidden
            text-overflow: ellipsis
            max-width: 190px
</style>