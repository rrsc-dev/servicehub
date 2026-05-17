<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Eye } from 'lucide-vue-next';

defineProps({
    company: Object
});
</script>

<template>
    <Head :title="`Detalhes - ${company.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('companies.index')" class="text-gray-600 hover:text-gray-900 transition-colors">
                    <ArrowLeft class="w-6 h-6" />
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ company.name }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informações da Empresa</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">CNPJ</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ company.document || 'Não informado' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ company.email || 'Não informado' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Telefone</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ company.phone || 'Não informado' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</span>
                            <span class="mt-1 inline-flex px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                {{ company.is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Projetos Relacionados</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome do Projeto</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Qtd. Tickets</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="project in company.projects" :key="project.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ project.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="text-gray-600 text-sm">
                                            {{ project.status === 1 ? 'Ativo' : 'Inativo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold leading-none text-indigo-800 bg-indigo-100 rounded-full">
                                            {{ project.tickets_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('projects.show', project.id)" class="inline-flex text-blue-600 hover:text-blue-900" title="Visualizar Projeto">
                                            <Eye class="w-5 h-5" />
                                        </Link>
                                    </td>
                                </tr>
                                
                                <tr v-if="!company.projects || company.projects.length === 0">
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        Esta empresa não possui nenhum projeto cadastrado no momento.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>