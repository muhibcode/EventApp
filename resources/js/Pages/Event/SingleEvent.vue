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
    <div class="grid grid-cols-2 ml-28 mt-10">
        <div class="flex">
            <div
                class="border w-full h-full ml-20 mr-0.5 rounded-bl-lg rounded-tl-lg"
            >
                <img
                    :src="props.event.images[1]?.src"
                    alt=""
                    class="w-full h-full rounded-bl-md rounded-tl-md"
                />
            </div>

            <!-- <h1>{{ event.name }}</h1>
            <h1>{{ event.address }}</h1>
            <h1>{{ event.tariff }}</h1>
            <h1>{{ event.city }}</h1> -->
        </div>
        <div>
            <div class="flex">
                <div class="w-60 h-60 mr-0.5">
                    <img
                        :src="props.event.images[0]?.src"
                        alt=""
                        class="w-full h-full"
                    />
                </div>
                <div class="w-60 h-60 rounded-tr-lg">
                    <img
                        :src="props.event.images[0]?.src"
                        alt=""
                        class="w-full h-full rounded-tr-md"
                    />
                </div>
            </div>
            <div class="flex">
                <div class="w-60 h-60 mr-0.5 mt-0.5">
                    <img
                        :src="props.event.images[0]?.src"
                        alt=""
                        class="w-full h-full"
                    />
                </div>
                <div class="w-60 h-60 mt-0.5 rounded-br-lg">
                    <img
                        :src="props.event.images[0]?.src"
                        alt=""
                        class="w-full h-full rounded-br-md"
                    />
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-2 ml-48 mt-10">
        <div>
            <div v-if="!host && !res">
                Hosted by
                <Link
                    :href="
                        route(
                            'userinfo.show',
                            event?.hosted_by.userinfo?.user.id
                        )
                    "
                    class="font-semibold text-xl text-gray-800 underline"
                    >{{ event?.hosted_by.userinfo?.user.name }}
                </Link>

                <!-- <h1>Hosted By {{ event?.hosted_by.userinfo?.user.name }}</h1> -->
                <button @click.prevent="attend" class="flex">Attend</button>
            </div>
            <h3 v-else-if="host">
                <!-- you are hosting this event..!! -->
                <button class="btn btn-warning" :onclick="cancelEvent">
                    Cancel Event
                </button>
            </h3>

            <div v-else-if="res">
                Hosted by
                <Link
                    :href="
                        route(
                            'userinfo.show',
                            event?.hosted_by.userinfo?.user.id
                        )
                    "
                    class="font-bold text-xl text-blue-600"
                    >{{ event?.hosted_by.userinfo?.user.name }}
                </Link>

                <!-- <h1>you are going to this event..!!</h1> -->
            </div>
            <button class="btn btn-accent" :onclick="cancelAttend">
                Cancel Attendance
            </button>
            <div class="mt-10">
                <h1>{{ event?.title }}</h1>
                <div class="flex items-center">
                    <i class="fa-solid fa-location-dot mr-1"></i>
                    <h1>{{ event?.venue }}</h1>
                    <h1>{{ event?.city }}</h1>
                </div>

                <div v-if="event?.attendees.length > 1">
                    {{ event?.attendees.length }} are going
                </div>
                <div v-else>{{ event?.attendees.length }} is going</div>
            </div>
            <h2 class="mt-5">Chat About This Event</h2>

            <h5 v-for="(item, index) in props.event.comments" :key="index">
                {{ item.userinfo.user.name }}:
                {{ item.body }}
            </h5>
            <div v-if="$page.props.auth.user?.id">
                <form @submit.prevent="sendComment">
                    <div>
                        <input name="comment" type="text" v-model="form.body" />
                        <button
                            class="fa-solid fa-paper-plane fa-xl ml-2"
                        ></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
