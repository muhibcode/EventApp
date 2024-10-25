<script setup>
import NavBar from "@/Pages/TopBar/NavBar.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

// const namear = ["muhaib khan", "zohari shaha"];

// const newNames = {
//     name: "umair shah",
//     age: 35,
//     rollno: 5,
// };

// namear.splice(1, 1);

const props = defineProps({
    events: Array,
    notifications: Array,
});

props.events.sort((a, b) => {
    return new Date(a.date) - new Date(b.date);
});

// notifications.value = props.notifications;
console.log(props.events);
window.Echo.channel(`create-activity`).listen(".activity", (e) => {
    props.events.push(e.data);
    // page.props.flash.message = e.message;
    // alert(e.message);
    // msg.value = e.mess;
    console.log(e);
});

let res = ref();
let host = ref();
const page = usePage();

const form = useForm({
    body: "",
    id: "",
});

const postcom = (id) => {
    form.id = id;
    form.post(route("comment.store"));
};
// res.value = props.activities.some((t) => {
//     t.attendees.some((e) => {
//         return e.user.id == page.props.auth.user?.id && e.is_host == false;
//     });
// });

// host.value = props.activities.some((t) => {
//     return t.hosted_by.user.id == page.props.auth.user?.id;
// });
</script>

<template>
    <NavBar />
    <div class="mt-10 pl-5">
        <Link
            :href="route('event.create')"
            class="font-semibold text-xl text-gray-800"
            >Add Activity
        </Link>
    </div>
    <div class="mt-10 pl-5 group">
        <Link
            :href="route('userinfo.create')"
            class="font-semibold text-xl text-gray-800"
            >Add Profile
        </Link>
    </div>
    <div class="mt-10 pl-5">
        <Link
            :href="route('city.create')"
            class="font-semibold text-xl text-gray-800"
            >Add City
        </Link>
    </div>
    <div class="mt-10 pl-5">
        <Link
            :href="route('userinfo.show', page.props.auth.user)"
            class="font-semibold text-xl text-gray-800"
            >Profile
        </Link>
    </div>
    <!-- <h2 v-for="(item, index) in act" :key="index">
        {{ item }}
    </h2> -->

    <!-- <h2>{{ newNames.name }}</h2> -->

    <div v-for="(item, index) in events" :key="index" class="ml-5">
        <div v-if="item">
            <Link :href="route('event.show', item.id)">
                <h1>
                    {{ item.title }}
                    {{ item.venue }}
                    {{ item.date }}
                </h1>
                <span
                    v-if="
                        item.hosted_by?.userinfo.user?.id ===
                        $page.props.auth.user?.id
                    "
                >
                    you are hosting this event..!!
                </span>

                <h5 v-else>
                    Hosted by {{ item.hosted_by.userinfo?.user.name }}

                    <div v-for="(i, index) in item.attendees" :key="index">
                        <h3
                            v-if="
                                i.userinfo.user.id === $page.props.auth.user?.id
                            "
                        >
                            you are going to this event..!!
                        </h3>
                    </div>
                </h5>
            </Link>
        </div>

        <br />
        <h1>Add Comment</h1>
        <form @submit.prevent="postcom(item.id)">
            <input type="text" v-model="form.body" />
            <button>Post</button>
        </form>
    </div>
</template>
