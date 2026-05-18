<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ArrowLeft } from 'lucide-vue-next';

const props = defineProps({ ticket: Object, projects: Array, users: Array });

const form = useForm({
    project_id: props.ticket.project_id,
    user_id: props.ticket.user_id,
    title: props.ticket.title,
    description: props.ticket.description || '',
    status: props.ticket.status,
    start_date: props.ticket.detail?.start_date || '',
    end_date: props.ticket.detail?.end_date || '',
});

const submit = () => {
    form.put(route('tickets.update', props.ticket.id));
};
</script>

<template>
    <Head title="Editar Ticket" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
                <Link :href="route('tickets.index', ticket.id)" class="text-gray-600 hover:text-gray-900">
                    <ArrowLeft class="w-6 h-6" />
                </Link>
                <h2 class="text-xl font-semibold text-gray-800">Edição Completa do Ticket #{{ ticket.id }}</h2>
            </div>
        </template>
        
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-100">
                    <form @submit.prevent="submit" class="space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div>
                                <InputLabel value="Projeto" />
                                <SelectInput v-model="form.project_id" class="w-full mt-2" required>
                                    <option v-for="p in projects" :key="p.id" :value="p.id">{{ p.name }}</option>
                                </SelectInput>
                                <InputError :message="form.errors.project_id" class="mt-1" />
                            </div>
                            <div>
                                <InputLabel value="Responsável" />
                                <SelectInput v-model="form.user_id" class="w-full mt-2" required>
                                    <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }}</option>
                                </SelectInput>
                                <InputError :message="form.errors.user_id" class="mt-1" />
                            </div>
                            <div>
                                <InputLabel value="Status do Ticket" />
                                <SelectInput v-model="form.status" class="w-full mt-2" required>
                                    <option value="1">Aberto</option>
                                    <option value="0">Resolvido</option>
                                </SelectInput>
                                <InputError :message="form.errors.status" class="mt-1" />
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <div>
                            <InputLabel value="Título do Problema" />
                            <TextInput type="text" class="w-full mt-2 font-medium" v-model="form.title" required />
                            <InputError :message="form.errors.title" class="mt-1" />
                        </div>
                        
                        <div>
                            <InputLabel value="Descrição Completa" />
                            <TextArea class="w-full mt-2" rows="6" v-model="form.description" />
                            <InputError :message="form.errors.description" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-50 p-6 border border-gray-200 rounded-lg">
                            <div>
                                <InputLabel value="Data de Início" />
                                <TextInput type="date" class="w-full mt-2" v-model="form.start_date" />
                                <InputError :message="form.errors.start_date" class="mt-1" />
                            </div>
                            <div>
                                <InputLabel value="Data Final Estimada" />
                                <TextInput type="date" class="w-full mt-2" v-model="form.end_date" />
                                <InputError :message="form.errors.end_date" class="mt-1" />
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 border rounded-md">
                            <InputLabel value="Anexar JSON/Log (Será lido em 2º plano para extrair dados automáticos)" />
                            <input type="file" @input="form.attachment = $event.target.files[0]" class="mt-2 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-700" accept=".json,.txt" />
                        </div>

                        <div class="flex justify-end pt-4">
                            <PrimaryButton :disabled="form.processing" class="px-8 py-3 text-base">Salvar Alterações do Ticket</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>