<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { Edit, Trash2, Info } from 'lucide-vue-next';

const props = defineProps({
    companies: Array
});

const deleteCompany = (id) => {
    if (confirm('Tem certeza que deseja excluir esta empresa?')) {
        router.delete(route('companies.destroy', id));
    }
};

</script>

<template>
    <Head title="Empresas" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Empresas Cadastradas
                </h2>
                <Link :href="route('companies.create')" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Nova Empresa
                </Link>
            </div>
        </template>

        <div class="py-12">
          <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
              <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                  <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Documento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Ações</th>
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                          <tr v-for="company in companies" :key="company.id">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 ">
                              {{ company.name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                              {{ company.document }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                              {{ company.is_active }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-4 text-center">
                              <Link :href="route('companies.show', company.id)" class="inline-flex text-blue-600 hover:text-blue-900" title="Ver detalhes">
                                <Info class="w-5 h-5" />
                              </Link>
                              <Link :href="route('companies.edit', company.id)" class="inline-flex text-indigo-600 hover:text-indigo-900" title="Editar empresa">
                                <Edit class="w-5 h-5" />
                              </Link>
                              <button @click="deleteCompany(company.id)" class="inline-flex text-red-600 hover:text-red-900" title="Excluir empresa">
                                <Trash2 class="w-5 h-5" />
                              </button>
                            </td>
                          </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>