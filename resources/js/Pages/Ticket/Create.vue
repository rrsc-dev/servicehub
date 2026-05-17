<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({ projects: Array, users: Array });

const form = useForm({
    project_id: '',
    user_id: '',
    title: '',
    description: '',
    attachment: null,
    start_date: '', 
    end_date: '',
});

const submit = () => {
    form.post(route('tickets.store'));
};
</script>

<template>
    <Head title="Criar Ticket" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Abrir Novo Ticket</h2>
        </template>
        <div class="py-12">
            <div class="mx-auto max-w-3xl sm:px-6 lg:px-8 bg-white p-6 rounded-lg shadow-sm">
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel value="Projeto" />
                            <SelectInput v-model="form.project_id" class="w-full mt-1" required>
                                <option value="" disabled>Selecione...</option>
                                <option v-for="p in projects" :key="p.id" :value="p.id">{{ p.name }}</option>
                            </SelectInput>
                            <InputError :message="form.errors.project_id" />
                        </div>
                        <div>
                            <InputLabel value="Responsável" />
                            <SelectInput v-model="form.user_id" class="w-full mt-1" required>
                                <option value="" disabled>Atribuir a...</option>
                                <option v-for="u in users" :key="u.id" :value="u.id">{{ u.name }}</option>
                            </SelectInput>
                            <InputError :message="form.errors.user_id" />
                        </div>
                    </div>
                    <div>
                        <InputLabel value="Título" />
                        <TextInput type="text" class="w-full mt-1" v-model="form.title" required />
                    </div>
                    <div>
                        <InputLabel value="Descrição do Problema" />
                        <TextArea class="w-full mt-1" v-model="form.description" />
                    </div>

                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 border rounded-md">
                        <div>
                            <InputLabel value="Data de Início (Opcional)" />
                            <TextInput type="date" class="w-full mt-1" v-model="form.start_date" />
                            <InputError :message="form.errors.start_date" />
                        </div>
                        <div>
                            <InputLabel value="Data Final (Opcional)" />
                            <TextInput type="date" class="w-full mt-1" v-model="form.end_date" />
                            <InputError :message="form.errors.end_date" />
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 border rounded-md">
                        <InputLabel value="Anexar JSON/Log (Será lido em 2º plano para extrair dados automáticos)" />
                        <input type="file" @input="form.attachment = $event.target.files[0]" class="mt-2 block w-full text-sm file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:bg-indigo-50 file:text-indigo-700" accept=".json,.txt" />
                    </div>
                    <div class="flex justify-end">
                        <PrimaryButton :disabled="form.processing">Abrir Ticket</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>