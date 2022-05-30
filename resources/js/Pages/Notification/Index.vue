<template>
    <div class="p-2 grid grid-cols-1 gap-y-4 text-sm">

        <div class="grid grid-cols-1 gap-y-2">
            <div v-for="notification in notifications" :id="notification.id"
                 :class="id == notification.id ? 'border border-main-700 bg-main-100' : 'border border-gray-600 bg-gray-50' "
                 class="w-full p-2 rounded-md">
                <div v-if="notification.data.type == 'user'">
                    <div>El usuario <b>{{ notification.data.auth_name }}</b> creó el usuario
                        <b>{{ notification.data.name }}</b>
                        con el email <b>{{ notification.data.email }}</b></div>
                    <div class="font-bold">Fecha de creación: {{ notification.created_at }}</div>
                </div>
                <inertia-link :href="route('management.sales.show', notification.data.sale_id)"
                              v-else-if="notification.data.type == 'sale'">
                    <div>
                        El usuario <b>{{ notification.data.auth_name }}</b> creó la venta con el token:
                        <b>{{ notification.data.token }}</b> para el cliente <b>{{ notification.data.customer }}</b> con
                        el stock de <b>{{ notification.data.total_stock }}</b> por un precio de
                        <b>${{ notification.data.total_price }}</b>.
                    </div>
                    <div class="font-bold">Fecha de creación: {{ notification.created_at }}</div>
                </inertia-link>
                <div v-else-if="notification.data.type == 'sale_delete_request' " as="button"
                              @click="markAsRead(notification.id, notification.read_at)"
                              :href="route('management.notification.index', {id: notification.id})" class="text-left">
                    <div> El usuario <b>{{ notification.data.auth_name }}</b> desea eliminar la venta con el token: <inertia-link :href="route('management.sales.show', notification.data.id)" class="text-blue-500">{{
                            notification.data.token
                        }}</inertia-link>. Haz click <inertia-link :href="route('management.sales.pending_to_delete.show', notification.data.token)" class="text-blue-500">aquí</inertia-link> para realizar acciones.
                    </div>
                    <div class="font-bold">Fecha de creación: {{ notification.created_at }}</div>
                </div>
                <div v-else-if="notification.data.type == 'sale_deleted'">
                    <div>Se ha eliminado tu venta con el token: {{ notification.data.token }}</div>
                    <div class="font-bold">Fecha de eliminación: {{ notification.created_at }}</div>
                </div>
                <div v-else-if="notification.data.type == 'sale_conserved'">
                    <div>Se ha decidido conservar tu venta con el token: {{ notification.data.token }}</div>
                    <div class="font-bold">Fecha de decisión: {{ notification.created_at }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import MainLayout from "@/Layouts/MainLayout";

export default {
    layout: MainLayout,
    props: ['notifications', 'id'],
    mounted() {
        if (this.id) {
            location.href = `#${this.id}`
        }
        console.log(this.notifications)
    },
    beforeUnmount() {
        if (this.id) {
            location.href = '#'
        }
    }
}
</script>

<style scoped>

</style>
