<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import TextInput from '@/Components/TextInput.vue';
import TextArea from '@/Components/TextArea.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ArrowLeft } from 'lucide-vue-next';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    project: Object,
    companies: Array
});

const form = useForm({
  company_id: props.project.company_id,
  name: props.project.name,
  description: props.project.description || '',
  start_date: props.project.start_date || '',
  end_date: props.project.end_date || '',
  status: props.project.status,
});

const submit = () => {
    form.put(route('projects.update', props.project.id));
};
</script>

<template>
    <Head title="Editar Projeto" />

    <AuthenticatedLayout>
        <template #header>
          <div class="flex items-center space-x-4">
            <Link :href="route('projects.index')" class="text-gray-600 hover:text-gray-900 transition-colors">
              <ArrowLeft class="w-6 h-6" />
            </Link>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Editar Projeto: {{ project.name }}
            </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    
                    <form @submit.prevent="submit" class="space-y-6 max-w-xl">
                      <div>
                            <InputLabel for="company_id" value="Empresa" />
                            <SelectInput id="company_id" v-model="form.company_id" class="mt-1 block w-full" required>
                                <option v-for="company in companies" :key="company.id" :value="company.id">
                                    {{ company.name }}
                                </option>
                            </SelectInput>
                            <InputError :message="form.errors.company_id" class="mt-2" />
                        </div>
                        <div>
                            <InputLabel for="name" value="Nome do Projeto" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required />
                            <InputError :message="form.errors.name" class="mt-2" />
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

                        <div class="flex items-center justify-end">
                            <PrimaryButton :disabled="form.processing">
                                Atualizar Projeto
                            </PrimaryButton>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>