<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import { ArrowLeft, Edit, Trash2 } from 'lucide-vue-next';

const props = defineProps({
    ticket: Object,
    canEdit: Boolean
});

const destroy = () => {
    if(confirm('Deseja excluir este ticket permanentemente?')) {
        router.delete(route('tickets.destroy', props.ticket.id));
    }
};
</script>

<template>
    <Head :title="`Ticket #${ticket.id}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('tickets.index')" class="text-gray-600 hover:text-gray-900">
                    <ArrowLeft class="w-6 h-6" />
                </Link>
                <h2 class="text-xl font-semibold text-gray-800">Ticket #{{ ticket.id }}</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 space-y-6">
                
                <div v-if="$page.props.flash?.message" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
                    <p class="font-bold">Aviso</p>
                    <p>{{ $page.props.flash.message }}</p>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-xl font-bold text-gray-900">{{ ticket.title }}</h3>
                        <p class="text-gray-600 mt-2 whitespace-pre-wrap">{{ ticket.description || 'Sem descrição.' }}</p>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="block text-gray-500 text-xs uppercase">Status</span>
                            <span class="font-semibold">{{ ticket.status === 1 ? 'Aberto' : 'Resolvido' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase">Projeto</span>
                            <span class="font-semibold">{{ ticket.project?.name || 'Não definido' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase">Criado Por</span>
                            <span class="font-semibold">{{ ticket.creator?.name || 'Não definido' }}</span>
                        </div>
                        <div>
                            <span class="block text-gray-500 text-xs uppercase">Responsável</span>
                            <span class="font-semibold">{{ ticket.user?.name || 'Não definido' }}</span>
                        </div>
                    </div>
                </div>

                <div v-if="ticket.detail" class="bg-white shadow-sm sm:rounded-lg p-6 ">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Detalhes do Arquivo (Processamento Assíncrono)</h3>
                    
                    <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                        <div class="bg-gray-50 p-3 rounded border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Data de Início Identificada</span>
                            <span class="font-bold">{{ ticket.detail.start_date ? new Date(ticket.detail.start_date).toLocaleDateString('pt-BR', {timeZone: 'UTC'}) : 'Não identificada' }}</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded border border-gray-100">
                            <span class="block text-gray-500 text-xs uppercase mb-1">Data Final Identificada</span>
                            <span class="font-bold">{{ ticket.detail.end_date ? new Date(ticket.detail.end_date).toLocaleDateString('pt-BR', {timeZone: 'UTC'}) : 'Não identificada' }}</span>
                        </div>
                    </div>

                    <div>
                        <span class="block text-gray-500 text-xs uppercase mb-2">Informações Extraídas do Anexo</span>
                        
                        <div v-if="ticket.detail.more_information && ticket.detail.more_information.raw_text">
                            <div class="bg-gray-50 p-4 rounded border border-gray-200">
                                <p class="text-sm text-gray-700 whitespace-pre-wrap font-mono">{{ ticket.detail.more_information.raw_text }}</p>
                            </div>
                        </div>
                        
                        <div v-else-if="ticket.detail.more_information && Object.keys(ticket.detail.more_information).length > 0">
                            <pre class="bg-gray-900 text-green-400 p-4 rounded text-xs overflow-x-auto whitespace-pre-wrap">{{ JSON.stringify(ticket.detail.more_information, null, 2) }}</pre>
                        </div>
                        
                        <div v-else class="text-amber-600 bg-amber-50 p-3 rounded text-sm italic border border-amber-200">
                            Nenhuma informação de texto extraída. (O arquivo pode estar na fila de processamento ou nenhum anexo válido foi enviado).
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>