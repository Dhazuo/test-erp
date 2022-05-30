<template>
    <div class="h-14 bg-blue-600 text-white shadow-md flex justify-between items-center px-4">
        <div>
            <inertia-link :href="route('management.product.index')">Productos</inertia-link>
        </div>
        <div class="flex justify-end">
            <button @click="user_menu = !user_menu" class="rounded-full h-10 w-10 bg-white flex items-center justify-center content-center text-gray-500">
                {{ user.name.substr(0, 1) }}
            </button>
        </div>
    </div>
    <div class="pt-12 pb-4 container mx-auto">
        <slot name="content"></slot>
    </div>
    <div v-if="user_menu" class="bg-white absolute top-14 right-4 rounded-md shadow-md border border-gray-200 py-2 grid grid-cols-1 gap-y-4">
        <div class="px-4 py-2 border-b">Hola, {{ user.name.substr(0, user.name.indexOf(' ') + 1) }}</div>
        <button @click="logout" class="hover:bg-gray-100 transition duration-200 px-4 py-2">Logout</button>
    </div>
    <div v-if="logout_processing" class="fixed text-4xl z-50 bg-black top-0 w-full h-full bg-opacity-25 flex justify-center items-center text-white">
        Saliendo...
    </div>
</template>

<script>
import Button from "../Jetstream/Button";
export default {
    name: "MainLayout",
    components: {Button},
    data(){
        return{
            user_menu: false,
            logout_processing: false
        }
    },
    computed: {
        user(){
            return this.$page.props.auth.user
        }
    },
    methods: {
        logout(){
            this.logout_processing = true
            axios.post(this.route('management_logout'), {
                user_id: this.user.id
            })
            .then(response => {
                window.location = this.route('index')
            })
        }
    }
}
</script>

<style scoped>

</style>
