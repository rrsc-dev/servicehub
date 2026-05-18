<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Welcome" />

    <div class="relative min-h-screen bg-white">

        <div class="absolute top-0 right-0 p-6">
            <template v-if="$page.props.auth.user">
                <Link
                    :href="route('dashboard')"
                    class="text-gray-700 hover:text-black font-medium"
                >
                    Dashboard
                </Link>
            </template>

            <template v-else>
                <div class="flex items-center gap-4">

                    <Link
                        v-if="canLogin"
                        :href="route('login')"
                        class="text-gray-700 hover:text-black font-medium"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="text-gray-700 hover:text-black font-medium"
                    >
                        Register
                    </Link>

                </div>
            </template>
        </div>

        <div class="flex min-h-screen items-center justify-center">
            <div class="flex flex-col md:flex-row items-center gap-6">

                <img
                    src="/images/logo.png"
                    alt="Logo"
                    class="w-32 h-32 object-contain"
                />

                <h1 class="text-6xl font-extrabold tracking-tight text-gray-900">
                    Service Hub
                </h1>

            </div>
        </div>

    </div>
</template>