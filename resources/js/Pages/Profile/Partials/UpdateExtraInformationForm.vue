<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';

const user = usePage().props.auth.user;
const profile = user.profile || {};

const form = useForm({
    phone: profile.phone || '',
    email: profile.email || '',
    role: profile.role || 'user',
});

const submit = () => {
    form.patch(route('profile.extra.update'), {
        preserveScroll: true,
        onSuccess: () => {
          const updatedProfile = usePage().props.auth.user.profile || {};
            form.defaults({
                phone: updatedProfile.phone || '',
                email: updatedProfile.email || '',
                role: updatedProfile.role || 'user',
            });
        }
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">
                Informações Complementares
            </h2>
            <p class="mt-1 text-sm text-gray-600">
                Atualize os dados de contato secundários e atribuições do seu perfil de usuário.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <InputLabel for="profile_phone" value="Telefone / Celular" />
                    <TextInput
                        id="profile_phone"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone"
                    />
                    <InputError class="mt-2" :message="form.errors.phone" />
                </div>

                <div>
                    <InputLabel for="profile_role" value="Cargo / Função" />
                    <SelectInput id="profile_role" v-model="form.role" class="mt-1 block w-full" required>
                        <option value="user">Usuário</option>
                        <option value="manager">Gerente</option>
                        <option value="admin">Administrador</option>
                    </SelectInput>
                    <InputError class="mt-2" :message="form.errors.role" />
                </div>
            </div>

            <div>
                <InputLabel for="profile_email" value="E-mail Alternativo de Contato" />
                <TextInput
                    id="profile_email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Salvar Perfil</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm font-semibold text-green-600">
                        Informações salvas.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>