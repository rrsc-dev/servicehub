<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { Edit, Trash2, Eye } from 'lucide-vue-next';

const props = defineProps({
    tickets: Array
});

const page = usePage();
const currentUserId = page.props.auth.user.id;

const canEditOrDelete = (ticket) => {
    return currentUserId === ticket.created_by || currentUserId === ticket.user_id;
};

const deleteTicket = (ticket) => {
    if (confirm(`Deseja realmente excluir o ticket #${ticket.id} permanentemente?`)) {
      router.delete(route('tickets.destroy', ticket.id), { preserveScroll: true });
    }
};
</script>

<template>
    <Head title="Todos os Tickets" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                  Todos os Tickets do Sistema
                </h2>
                <Link :href="route('tickets.create')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Novo Ticket
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                
                <div v-if="$page.props.flash?.message" class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    {{ $page.props.flash.message }}
                </div>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Projeto</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="ticket in tickets" :key="ticket.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    #{{ ticket.id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ ticket.title }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ ticket.project?.name || '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full" :class="ticket.status === 1 ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'">
                                        {{ ticket.status === 1 ? 'Aberto' : 'Resolvido' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-3">
                                    <Link :href="route('tickets.show', ticket.id)" class="inline-flex text-blue-600 hover:text-blue-900" title="Ver Detalhes">
                                        <Eye class="w-5 h-5" />
                                    </Link>
                                    
                                    <template v-if="canEditOrDelete(ticket)">
                                        <Link :href="route('tickets.edit', ticket.id)" class="inline-flex text-indigo-600 hover:text-indigo-900" title="Editar">
                                            <Edit class="w-5 h-5" />
                                        </Link>
                                        <button @click.stop.prevent="deleteTicket(ticket)" class="inline-flex text-red-600 hover:text-red-900" title="Excluir">
                                            <Trash2 class="w-5 h-5" />
                                        </button>
                                    </template>
                                </td>
                            </tr>
                            <tr v-if="tickets.length === 0">
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">Nenhum ticket encontrado no sistema.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>