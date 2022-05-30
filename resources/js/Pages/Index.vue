<template>
    <div class="fixed w-full h-full flex justify-center items-center">
        <div class="bg-white rounded-md w-2/4 shadow-md text-center p-4">
            <div class="grid grid-cols-1 gap-y-4 text-gray-400">
                <div v-if="error" class="border rounded-md border-red-500 bg-red-200 text-white text-center flex justify-center p-2 items-center">
                    {{ error }}
                </div>
                <div class="grid grid-cols-1 gap-y-2">
                    <label for="email">Email</label>
                    <input v-model="form.email" id="email" type="email" class="rounded-md shadow-sm border border-gray-200 text-center">
                </div>
                <div class="grid grid-cols-1 gap-y-2">
                    <label for="password">Password</label>
                    <input v-model="form.password" id="password" type="password" class="rounded-md shadow-sm border border-gray-200 text-center">
                </div>
                <div class="flex justify-center">
                    <button @click="submit" class="shadow-md rounded-md bg-blue-500 text-white px-4 py-2 hover:bg-blue-600 transition duration-200">Log In</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Index",
    data(){
        return{
            form: {
                email: '',
                password: ''
            },
            error: null
        }
    },
    methods: {
        submit(){
            axios.post(this.route('management_login'), this.form)
                .then(response => {
                    window.location = this.route('management.index')
                })
                .catch(err => {
                    this.error = err.response.data.error

                })
        }
    }
}
</script>

<style scoped>

</style>
