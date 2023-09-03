<template>
    <div>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
                Omni Hotelier Internasional
            </a>
            <div class="w-full bg-white rounded-lg shadow-lg md:mt-0 sm:max-w-md xl:p-0 ">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
                        Create Account
                    </h1>
                    <form class="space-y-4 md:space-y-6" @submit.prevent="login">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Your name</label>
                            <input type="text" v-model="name" name="name" id="name" placeholder="Your Name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-brand-500 focus:outline-none focus:border-brand-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Your phone</label>
                            <input type="text" v-model="phone" phone="phone" id="phone" placeholder="Your phone"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-brand-500 focus:outline-none focus:border-brand-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Your email</label>
                            <input type="email" v-model="email" name="email" id="email" placeholder="example@email.com"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-brand-500 focus:outline-none focus:border-brand-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                            <input v-model="password" type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-brand-500 focus:outline-none focus:border-brand-500 block w-full p-2.5"
                                required>
                        </div>
                        <div>
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password Confirmation</label>
                            <input v-model="password" type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-brand-500 focus:outline-none focus:border-brand-500 block w-full p-2.5"
                                required>
                        </div>
                        <div class="flex items-center justify-between">

                            <p class="text-sm font-light text-gray-500">
                                Already have an Account?

                            </p>
                            <button @click="() => $router.push('/login')"  type="button" class="font-medium text-primary-600 hover:underline">Log In</button>

                        </div>
                        <button type="submit"
                            class="w-full text-black bg-primary-600 hover:bg-primary-700 focus:ring-4 border border-lg border-gray-300 focus:ring-brand-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Sign
                            in</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: '',
            errors: [],
        }
    },
    methods: {
        login() {
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            }).then(response => {
                this.$store.dispatch('login', response.data)
                window.location.href = '/'
            }).catch(error => {
                this.errors = error.response.data.errors
            })
        }
    }
}
</script>