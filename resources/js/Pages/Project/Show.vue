<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ArrowLeft, Eye } from 'lucide-vue-next';

defineProps({
    project: Object
});

const formatDate = (dateString) => {
    if (!dateString) return 'Não definida';
    const date = new Date(dateString + 'T00:00:00');
    return new Intl.DateTimeFormat('pt-BR').format(date);
};
</script>

<template>
    <Head :title="`Detalhes do Projeto - ${project.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('projects.index')" class="text-gray-600 hover:text-gray-900 transition-colors">
                    <ArrowLeft class="w-6 h-6" />
                </Link>
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ project.name }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">Informações do Projeto</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                        <div class="lg:col-span-2">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Empresa</span>
                            <Link v-if="project.company" :href="route('companies.show', project.company_id)" class="text-sm text-indigo-600 hover:text-indigo-900 mt-1 block font-medium">
                                {{ project.company.name }}
                            </Link>
                            <span v-else class="text-sm text-gray-900 mt-1 block">Não informada</span>
                        </div>
                        
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Data Início</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ formatDate(project.start_date) }}</span>
                        </div>
                        
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Data Fim</span>
                            <span class="text-sm text-gray-900 mt-1 block">{{ formatDate(project.end_date) }}</span>
                        </div>
                        
                        <div>
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</span>
                            <span class="mt-1 inline-flex px-2 py-1 bg-gray-100 text-gray-800 rounded text-xs font-medium">
                                {{ project.status === 1 ? 'Ativo' : 'Inativo' }}
                            </span>
                        </div>

                        <div class="md:col-span-2 lg:col-span-5 mt-2">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Descrição</span>
                            <p class="text-sm text-gray-900 mt-1">{{ project.description || 'Nenhuma descrição fornecida.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                        <h3 class="text-lg font-semibold text-gray-800">Tickets Relacionados</h3>
                        </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Título do Ticket</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <tr v-for="ticket in project.tickets" :key="ticket.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        #{{ ticket.id }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ ticket.title }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center">
                                        <span class="text-gray-600 text-sm">
                                            {{ ticket.status === 1 ? 'Aberto' : 'Fechado' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <Link :href="route('tickets.show', ticket.id)" class="inline-flex text-blue-600 hover:text-blue-900" title="Visualizar Ticket">
                                            <Eye class="w-5 h-5" />
                                        </Link>
                                    </td>
                                </tr>
                                
                                <tr v-if="!project.tickets || project.tickets.length === 0">
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">
                                        Este projeto não possui nenhum ticket cadastrado no momento.
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