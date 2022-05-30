<template>
    <div class="hidden lg:grid grid-cols-2 fixed w-full h-full ">
        <img src="/images/index/frutas_web.png" alt="" class="h-full">
        <div class="w-full h-full py-8 px-12 bg-white">
            <div class="container mx-auto grid grid-cols-1 gap-y-6">
                <div class="h-44 w-44 mx-auto">
                    <img src="/images/index/logos/logo_circular-web.png" alt="" class="object-contain">
                </div>
                <div class="grid grid-cols-1 gap-y-6">
                    <div class="my-font text-center">
                        Iniciar sesión
                    </div>
                    <div>
                        <input v-model="form.email" type="email" :class="error ? 'border-focus-error' : ''" class="w-full bg-white focus:ring-0 outline-none focus:outline-none border-l-0 border-t-0 border-r-0 border-b-2 border-gray-300 placeholder-gray-300 transition duration-200 focus:border-focus" placeholder="Ingresa tu usuario">
                    </div>
                    <div>
                        <input @keyup.enter="submit" v-model="form.password" type="password" :class="error ? 'border-focus-error' : ''"  class="w-full bg-white focus:ring-0 outline-none focus:outline-none border-l-0 border-t-0 border-r-0 border-b-2 border-gray-300 placeholder-gray-300 transition duration-200 focus:border-focus" placeholder="Ingresa tu contraseña">
                    </div>
                </div>
                <div class="flex justify-center">
                    <button :disabled="isProcessing" @click="submit" :class="isProcessing ? 'bg-gray-200 text-black' : 'text-white bg-main hover:bg-main-600'" class="px-6 py-4 text-sm font-bold  rounded-md transition duration-200 ">
                        {{ isProcessing ? 'ESPERE UN MOMENTO' : 'INICIAR SESIÓN' }}
                    </button>
                </div>
                <div v-if="text_error" class="text-sm font-bold">
                    *{{ text_error }}
                </div>
            </div>
        </div>
    </div>
    <div class="fixed w-full h-full flex sm:hidden justify-center items-center fruits2">
        <div class="w-3/4 bg-white rounded-md shadow-md grid grid-cols-1 gap-y-8 p-4">
            <div class="w-44 h-44 mx-auto">
                <img src="/images/index/logos/logo_circular-mobile.png" alt="" class="object-contain">
            </div>
            <div class="grid grid-cols-1 gap-y-8">
                <div class="my-font text-center">
                    Iniciar sesión
                </div>
                <div>
                    <input v-model="form.email" type="email" :class="error ? 'border-focus-error' : ''" class="w-full bg-white focus:ring-0 outline-none focus:outline-none border-l-0 border-t-0 border-r-0 border-b-2 border-gray-300 placeholder-gray-300 transition duration-200 focus:border-focus" placeholder="Ingresa tu usuario">
                </div>
                <div>
                    <input @keyup.enter="submit" v-model="form.password" type="password" :class="error ? 'border-focus-error' : ''"  class="w-full bg-white focus:ring-0 outline-none focus:outline-none border-l-0 border-t-0 border-r-0 border-b-2 border-gray-300 placeholder-gray-300 transition duration-200 focus:border-focus" placeholder="Ingresa tu contraseña">
                </div>
            </div>
            <div class="flex justify-center">
                <button :disabled="isProcessing" @click="submit" :class="isProcessing ? 'bg-gray-200 text-black' : 'text-white bg-main hover:bg-main-600'" class="px-6 py-4 text-sm font-bold  rounded-md transition duration-200 ">
                    {{ isProcessing ? 'ESPERE UN MOMENTO' : 'INICIAR SESIÓN' }}
                </button>
            </div>
            <div v-if="text_error" class="text-sm font-bold text-center">
                *{{ text_error }}
            </div>
        </div>
    </div>
    <div class="fixed w-full h-full hidden sm:flex flex-col lg:hidden ">
        <div class="h-1/3 fruits flex justify-center items-center w-full">
            <div class="h-44 w-44 mx-auto">
                <img src="/images/index/logos/logo_circular-mobile.png" alt="" class="object-contain">
            </div>
        </div>
        <div class="h-2/3 grid grid-cols-1 gap-y-6 py-4 px-12">
            <div class="grid grid-cols-1 gap-y-6">
                <div class="my-font-2 text-center">
                    Iniciar sesión
                </div>
                <div>
                    <input v-model="form.email" type="email" :class="error ? 'border-focus-error' : ''" class="w-full bg-white text-4xl focus:ring-0 outline-none focus:outline-none border-l-0 border-t-0 border-r-0 border-b-2 border-gray-300 placeholder-gray-300 transition duration-200 focus:border-focus" placeholder="Ingresa tu usuario">
                </div>
                <div>
                    <input @keyup.enter="submit" v-model="form.password" type="password" :class="error ? 'border-focus-error' : ''"  class="w-full bg-white text-4xl focus:ring-0 outline-none focus:outline-none border-l-0 border-t-0 border-r-0 border-b-2 border-gray-300 placeholder-gray-300 transition duration-200 focus:border-focus" placeholder="Ingresa tu contraseña">
                </div>
            </div>
            <div class="mx-auto">
                <button :disabled="isProcessing" @click="submit" :class="isProcessing ? 'bg-gray-200 text-black' : 'text-white bg-main hover:bg-main-600'" class="px-8 py-6 text-xl font-bold  rounded-md transition duration-200 ">
                    {{ isProcessing ? 'ESPERE UN MOMENTO' : 'INICIAR SESIÓN' }}
                </button>
            </div>
            <div v-if="text_error" class="text-xl font-bold text-center">
                *{{ text_error }}
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
            error: null,
            text_error: null,
            isProcessing: false
        }
    },
    methods: {
        submit(){
            this.isProcessing = true
            axios.post(this.route('management_login'), this.form)
                .then(response => {
                    window.location = this.route('management.index')
                })
                .catch(err => {
                    this.error = err.response.data.error
                    this.text_error = err.response.data.error
                    this.isProcessing = false
                })
        }
    },
    watch: {
        'form.email': function (oldVal, newVal) {
            if (this.error && oldVal !== newVal) {
                this.error = null
            }
        },
        'form.password': function (oldVal, newVal) {
            if (this.error && oldVal !== newVal) {
                this.error = null
            }
        }
    }
}
</script>

<style scoped>
.fruits {
    background-image: url("/images/index/frutas_web.png");
    background-size: cover;
}
.fruits2 {
    background-image: url("/images/index/frutas_mobile.png");
    background-size: cover;
}
.my-font {
    font-size: 1.5rem;
    font-weight: 900;

}
.my-font-2{
    font-size: 2.5rem;
    font-weight: 900;
}
input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset;
}

input:-webkit-autofill:focus {
    -webkit-box-shadow: white, 0 0 0 50px white inset;
    -webkit-text-fill-color: #333;
}

-webkit-text-fill-color: #838B95 !important;
</style>
