<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { reactive } from "vue";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    city: "",
    address: "",
});

const submit = () => {
    form.post(route("userinfo.store"));
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <div class="ml-10 w-48">
                <div class="mt-5">
                    <InputLabel for="city" value="City" />

                    <input
                        id="city"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.city"
                    />
                    <!-- <InputError class="mt-2" :message="form.errors.country" /> -->
                </div>
                <div class="mt-5">
                    <InputLabel for="address" value="Address" />

                    <input
                        id="address"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.address"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.beds" /> -->
                </div>
                <div class="mt-5">
                    <InputLabel for="phone_no" value="Phone" />

                    <input
                        id="phone_no"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.phone_no"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.beds" /> -->
                </div>
            </div>
            <PrimaryButton
                class="mt-10 ml-10 ms-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Register
            </PrimaryButton>
        </form>
    </div>
</template>
