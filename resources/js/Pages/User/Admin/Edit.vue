<template>
    <div class="p-2 grid grid-cols-1 gap-y-8">
        <div class="flex justify-start ">
            <inertia-link :href="route('management.user.index')"
                          class="hover:bg-gray-100 transition duration-200 px-4 py-2 rounded-md shadow-sm border border-gray-200 text-gray-600">
                Regresar
            </inertia-link>

        </div>
        <div class="w-full flex justify-center ">
            <div class="w-2/4 rounded-md shadow-md border border-gray-200 grid grid-cols-1">
                <div class="p-2 bg-gray-100 text-gray-400 text-2xl border-b border-gray-500 text-center">
                    Editando: {{ user.name }}
                </div>
                <div class="grid grid-cols-1 gap-y-6 p-2">
                    <div class="text-center grid grid-cols-1 gap-y-2">
                        <label for="name">Nombre</label>
                        <input v-model="form.name" id="name" type="text"
                               class="text-center rounded-md shadow-sm border border-gray-200">
                    </div>
                    <div class="grid grid-cols-2 gap-x-6">

                        <div class="text-center grid grid-cols-1 gap-y-2">
                            <label for="email">Email</label>
                            <input v-model="form.email" id="email" type="email"
                                   class="text-center rounded-md shadow-sm border border-gray-200">
                        </div>
                        <div class="text-center grid grid-cols-1 gap-y-2">
                            <label for="role">Rol</label>
                            <select v-model="form.role" name="" id="role"
                                    class="rounded-md shadow-sm border border-gray-200">
                                <option>admin</option>
                                <option>manager</option>
                                <option>seller</option>
                            </select>
                        </div>
                    </div>
                    <div class="w-full flex justify-center">
                        <button @click="save" class="px-4 py-2 bg-blue-500 text-white shadow-md rounded-md">
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
import MainLayout from "@/Layouts/MainLayout";

export default {
    layout: MainLayout,

    components: {MainLayout},
    props: ['user'],
    data() {
        return {
            form: {
                name: this.user.name,
                email: this.user.email,
                role: this.user.role
            }
        }
    },
    methods: {
        save() {
            axios.put(this.route('management.user.update', this.user), this.form)
                .then(() => {
                    window.location = this.route('management.user.show', this.user)
                })
        },

    }


}
</script>

<style scoped>

</style>
