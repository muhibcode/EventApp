<template>
    <h1>All Requests</h1>
    <div
        class="flex ml-2"
        v-for="(item, index) in props.reqs.reqsender"
        :key="index"
    >
        <h1 class="pr-5">
            {{ item.user.name }}
        </h1>
        <button @click.prevent="acceptreq(item.user.id)">Accept</button>
    </div>
</template>

<script setup>
import { useForm, usePage } from "@inertiajs/vue3";
import { onMounted } from "vue";

const page = usePage();
const form = useForm({
    follower: "",
    tuser: page.props.auth.user.id,
});
const props = defineProps({
    reqs: Object,
});

// onMounted(() => {});

const acceptreq = (id) => {
    if (form.processing) {
        return false;
    }
    form.follower = id;
    form.post(route("follow.store"));
};
console.log(page.props.auth.user.id);
</script>
