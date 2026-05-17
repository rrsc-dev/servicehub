<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
    company: Object
});

const form = useForm({
    name: props.company.name,
    document: props.company.document || '',
    email: props.company.email || '',
    phone: props.company.phone || '',
    address: props.company.address || '',
});

const submit = () => {
    form.put(route('companies.update', props.company.id));
};
</script>

<template>
    <Head title="Editar Empresa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar Empresa: {{ company.name }}
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

                        <div class="flex items-center justify-end mt-4 space-x-3">
                            <Link :href="route('companies.index')" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                Cancelar
                            </Link>

                            <PrimaryButton
                              class="ms-4"
                              :class="{ 'opacity-25': form.processing }"
                              :disabled="form.processing"
                            >
                              Salvar Alterações
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>