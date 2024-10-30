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

let rEvent = props.events.reduce((accumulator, item) => {
    const date = item.date;
    if (!accumulator[date]) {
        accumulator[date] = [];
    }
    accumulator[date].push(item);
    return accumulator;
}, {});

// notifications.value = props.notifications;
console.log(rEvent);
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
    <div class="bg-gray-200 pt-10">
        <!-- <div class="mt-10 pl-5">
            <Link
                :href="route('event.create')"
                class="font-semibold text-xl text-gray-800"
                >Add Activity
            </Link>
        </div> -->
        <!-- <div class="mt-10 pl-5 group">
            <Link
                :href="route('userinfo.create')"
                class="font-semibold text-xl text-gray-800"
                >Add Profile
            </Link>
        </div> -->
        <!-- <div class="mt-10 pl-5">
            <Link
                :href="route('city.create')"
                class="font-semibold text-xl text-gray-800"
                >Add City
            </Link>
        </div> -->
        <!-- <div class="mt-10 pl-5">
            <Link
                :href="route('userinfo.show', page.props.auth.user)"
                class="font-semibold text-xl text-gray-800"
                >Profile
            </Link>
        </div> -->
        <!-- <h2 v-for="(item, index) in act" :key="index">
        {{ item }}
    </h2> -->

        <!-- <h2>{{ newNames.name }}</h2> -->
        <div
            v-for="(item, index) in events"
            :key="index"
            class="grid grid-cols-2 ml-40 mt-5"
        >
            <div v-if="item" class="rounded-md h-72 pt-5 px-10 bg-white">
                <div class="flex">
                    <Link
                        :href="
                            route(
                                'userinfo.show',
                                item?.hosted_by.userinfo?.user.id
                            )
                        "
                        class="flex avatar mr-10 items-center"
                    >
                        <div class="w-14 rounded-full">
                            <img
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                            />
                        </div>
                    </Link>
                    <div>
                        <span class="font-black text-lg">
                            {{ item.title }}
                        </span>
                        <span
                            v-if="
                                item.hosted_by?.userinfo.user?.id ===
                                $page.props.auth.user?.id
                            "
                        >
                            <h1 class="mb-1">
                                Hosted by
                                <span class="font-black text-blue-500">
                                    {{ page.props.auth.user.name }}
                                </span>
                            </h1>
                            <div class="border border-rose-500 rounded-sm mb-1">
                                <h1 class="text-rose-500 px-2 font-semibold">
                                    you are hosting this event..!!
                                </h1>
                            </div>
                        </span>

                        <h1 v-else>
                            Hosted by
                            <Link
                                :href="
                                    route(
                                        'userinfo.show',
                                        item?.hosted_by.userinfo?.user.id
                                    )
                                "
                                class="text-blue-500 font-black"
                            >
                                {{ item.hosted_by.userinfo?.user.name }}
                            </Link>

                            <div
                                v-for="(i, index) in item.attendees"
                                :key="index"
                            >
                                <h1
                                    class="mt-1 mb-1 border border-green-600 rounded-sm text-green-600 px-2 font-semibold"
                                    v-if="
                                        i.userinfo.user.id ===
                                        $page.props.auth.user?.id
                                    "
                                >
                                    you are going to this event..!!
                                </h1>
                            </div>
                        </h1>
                    </div>
                </div>
                <div class="divider divider-default mt-1 mb-1"></div>
                <div class="flex items-center justify-around">
                    <div class="mr-1">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ item.venue }}
                    </div>
                    <div class="mr-1">
                        <i class="fa-solid fa-calendar-days"></i>
                        {{ new Date(item.date).toDateString() }}
                    </div>
                    <div class="mr-1">
                        <i class="fa-solid fa-clock ml-2"></i>
                        5:00 PM
                    </div>
                </div>
                <div class="divider divider-default mt-1 mb-3"></div>
                <div class="flex">
                    <div class="flex avatar mr-2 items-center">
                        <div class="w-10 rounded-full">
                            <img
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                            />
                        </div>
                    </div>
                    <div class="flex avatar mr-2 items-center">
                        <div class="w-10 rounded-full">
                            <img
                                src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                            />
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <Link
                        :href="route('event.show', item.id)"
                        class="btn shadow-lg btn-outline text-orange-700 btn-sm hover:border-orange-700 hover:bg-orange-700 hover:text-white"
                        >View</Link
                    >
                </div>
            </div>
        </div>

        <br />
        <!-- <h1>Add Comment</h1>
        <form @submit.prevent="postcom(item.id)">
            <input type="text" v-model="form.body" />
            <button>Post</button>
        </form> -->
    </div>
</template>
