<script setup>
import NavBar from "@/Pages/TopBar/NavBar.vue";
import { useForm, usePage, Link, useRemember } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    event: Object,
});

const res = ref();
const host = ref();
const page = usePage();

res.value = props.event?.attendees.some((e) => {
    return e.userinfo.user.id == page.props.auth.user?.id && e.is_host == false;
});
host.value = props.event?.attendees.some((e) => {
    return e.userinfo.user.id == page.props.auth.user?.id && e.is_host == true;
});

// console.log(res);
console.log(props.event);

const form = useForm({
    eventID: props.event?.id,
    body: "",
});

const attend = () => {
    res.value = true;
    form.post(route("attendee.store"));
};
const cancelAttend = () => {
    res.value = false;
    // form.post(route('activityattendee.delete'))
};
const cancelEvent = () => {
    // form.post(route('activityattendee.delete'))
};

const sendComment = () => {
    form.post(route("comment.store"));
    form.body = "";
};
</script>

<template>
    <NavBar />
    <div class="mt-10 pl-5"></div>
    <h1>{{ event?.title }}</h1>
    <h1>{{ event?.city }}</h1>
    <h1>{{ event?.venue }}</h1>
    <h3>{{ event?.attendees.length }} is attending</h3>

    <div v-if="!host && !res">
        Hosted by
        <Link
            :href="route('userinfo.show', event?.hosted_by.userinfo?.user.id)"
            class="font-semibold text-xl text-gray-800 underline"
            >{{ event?.hosted_by.userinfo?.user.name }}
        </Link>
        ..!!
        <!-- <h1>Hosted By {{ event?.hosted_by.userinfo?.user.name }}</h1> -->
        <button @click.prevent="attend" class="flex">Attend</button>
    </div>
    <h3 v-else-if="host">
        you are hosting this event..!!
        <button :onclick="cancelEvent">Cancel Event</button>
    </h3>

    <h3 v-else-if="res">
        Hosted by
        <Link
            :href="route('userinfo.show', event?.hosted_by.userinfo?.user.id)"
            class="font-semibold text-xl text-gray-800 underline"
            >{{ event?.hosted_by.userinfo?.user.name }}
        </Link>
        ..!!
        <h1>you are going to this event..!!</h1>
        <button :onclick="cancelAttend">Cancel Attendance</button>
    </h3>
    <br />
    <h2>Comments</h2>

    <h5 v-for="(item, index) in props.event.comments" :key="index">
        {{ item.userinfo.user.name }}:
        {{ item.body }}
    </h5>
    <div v-if="$page.props.auth.user?.id">
        <form @submit.prevent="sendComment">
            <div>
                <input name="comment" type="text" v-model="form.body" />
            </div>
            <button>send</button>
        </form>
    </div>
</template>
