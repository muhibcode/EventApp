<template>
    <form @submit.prevent="submit">
        <div>
            <h1>Add city</h1>
            <input type="text" v-model="form.name" />
            <button>Submit</button>
        </div>
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route("city.store"));
};
</script>
