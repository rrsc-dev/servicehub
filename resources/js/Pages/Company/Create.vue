<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    name: '',
    document: '',
    email: '',
    phone: '',
    address: '',
    is_active: true,
});

const submit = () => {
    form.post(route('companies.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Cadastrar Empresa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Cadastrar Nova Empresa
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit" class="space-y-4 max-w-xl">
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
                          <InputLabel for="document" value="CNPJ" class="mt-2"/>
                          <TextInput 
                             id="document" v-model="form.document" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                          <InputError class="text-red-600 text-sm mt-2" :message="form.errors.document" />
                        </div>

                        <div>
                          <InputLabel for="email" value="Email" class="mt-2"/>
                          <TextInput 
                             id="email" v-model="form.email" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                          <InputError class="text-red-600 text-sm mt-2" :message="form.errors.email" />
                        </div>

                        <div>
                          <InputLabel for="phone" value="Telefone" class="mt-2"/>
                          <TextInput 
                             id="phone" v-model="form.phone" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                          <InputError class="text-red-600 text-sm mt-2" :message="form.errors.phone" />
                        </div>

                        <div>
                          <InputLabel for="address" value="Endereço" class="mt-2"/>
                          <TextInput 
                             id="address" v-model="form.address" type="text" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                          <InputError class="text-red-600 text-sm mt-2" :message="form.errors.address" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                          <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                          >
                          Salvar Empresa
                          </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>