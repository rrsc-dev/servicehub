<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextArea from '@/Components/TextArea.vue';
import { ArrowLeft } from 'lucide-vue-next';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    companies: Array
});

const form = useForm({
    company_id: '',
    name: '',
    description: '',
    start_date: '',
    end_date: '',
    status: 1,
});

const submit = () => {
    form.post(route('projects.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Cadastrar Projeto" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center space-x-4">
            <Link :href="route('projects.index')" class="text-gray-600 hover:text-gray-900 transition-colors">
              <ArrowLeft class="w-6 h-6" />
            </Link>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Cadastrar Novo Projeto
            </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit" class="space-y-4 max-w-xl">
                        <div>
                            <InputLabel for="company_id" value="Empresa" />
                            <SelectInput id="company_id" v-model="form.company_id" class="mt-1 block w-full" required autofocus>
                                <option value="" disabled selected>Selecione uma empresa...</option>
                                <option v-for="company in companies" :key="company.id" :value="company.id">
                                    {{ company.name }}
                                </option>
                            </SelectInput>
                            <InputError class="text-red-600 text-sm mt-2" :message="form.errors.company_id" />
                        </div>

                        <div>
                          <InputLabel for="name" value="Nome" class="mt-2"/>

                          <TextInput 
                            id="name"
                            type="text"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            required
                            v-model="form.name"
                            autofocus
                          />

                          <InputError class="text-red-600 text-sm mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="description" value="Descrição" />
                            <TextArea id="description" class="mt-1 block w-full" v-model="form.description" />
                            <InputError :message="form.errors.description" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <InputLabel for="start_date" value="Data de Início" />
                                <TextInput id="start_date" type="date" class="mt-1 block w-full" v-model="form.start_date" />
                                <InputError :message="form.errors.start_date" class="mt-2" />
                            </div>

                            <div>
                                <InputLabel for="end_date" value="Data de Término" />
                                <TextInput id="end_date" type="date" class="mt-1 block w-full" v-model="form.end_date" />
                                <InputError :message="form.errors.end_date" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"    :disabled="form.processing">
                                Salvar Empresa
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>