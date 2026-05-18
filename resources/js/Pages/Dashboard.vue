<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: Object
})
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Dashboard
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">

                    <!-- Companies -->
                    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total de Empresas
                        </h3>

                        <p class="mt-4 text-4xl font-bold text-indigo-600">
                            {{ stats.companies }}
                        </p>
                    </div>

                    <!-- Projects -->
                    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total de Projetos
                        </h3>

                        <p class="mt-4 text-4xl font-bold text-green-600">
                            {{ stats.projects }}
                        </p>
                    </div>

                    <!-- Tickets -->
                    <div class="bg-white shadow rounded-2xl p-6 border border-gray-100">
                        <h3 class="text-sm font-medium text-gray-500">
                            Total de Tickets
                        </h3>

                        <p class="mt-4 text-4xl font-bold text-red-600">
                            {{ stats.tickets }}
                        </p>
                    </div>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
