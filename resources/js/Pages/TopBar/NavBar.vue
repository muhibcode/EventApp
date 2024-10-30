<template>
    <div class="flex bg-orange-600 py-2 shadow-lg justify-end items-center">
        <Link
            :href="route('event.create')"
            class="btn btn-warning mr-20 shadow-md"
        >
            Creat Activity
        </Link>
        <div class="flex">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button">
                    <i
                        :class="`fa-solid fa-bell fa-xl ${notcolor}`"
                        @click.prevent="notclick"
                    ></i>
                </div>

                <ul
                    tabindex="0"
                    class="dropdown-content menu bg-base-100 rounded-md z-[1] w-80 p-2 shadow mt-4"
                >
                    <li v-for="(item, index) in notifications" :key="index">
                        <div class="flex">
                            <i class="fa-solid fa-ellipsis-vertical"></i>
                            <a>{{ item.content }}</a>
                        </div>
                    </li>
                    <!-- <li><a>Item 2</a></li> -->
                </ul>
            </div>
        </div>
        <!-- <div class="avatar">
            <div class="w-24 rounded-xl">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                />
            </div>
        </div> -->
        <h1 :class="`${notcolor} flex items-center mr-10 mb-5`">
            {{ unread }}
        </h1>

        <Link
            :href="route('userinfo.show', page.props.auth.user.id)"
            class="flex avatar mr-10 items-center"
        >
            <div class="w-14 rounded-full">
                <img
                    src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp"
                />
            </div>
        </Link>
    </div>
</template>
<script setup>
import { usePage, Link, useForm } from "@inertiajs/vue3";
import { onMounted, ref } from "vue";
import axios from "axios";

const page = usePage();
const unread = ref(0);
const notcolor = ref("text-gray-600");
const form = useForm({});
const follower = ref(false);
const reqsend = ref(false);
const notifications = ref([]);

const notclick = () => {
    unread.value = 0;
    notcolor.value = "text-gray-600";
    localStorage.removeItem("unread");
};

// const props = defineProps({
//     notification: Array,
// });
// console.log(props.notification);

onMounted(async () => {
    const res = await axios.get(route("notification.index"));
    console.log(res.data.notification);
    notifications.value = res.data.notification;
    let unreadlocal = localStorage.getItem("unread");

    // console.log(unread.value);

    if (unreadlocal == null) {
        localStorage.setItem("unread", unread.value);
    } else {
        unread.value = Number(unreadlocal);

        if (unread.value > 0) {
            notcolor.value = "text-white";
        }
    }

    window.Echo.private(
        `App.Models.User.${page.props.auth.user.id}`
    ).stopListening(".notify");

    window.Echo.private(`App.Models.User.${page.props.auth.user.id}`).listen(
        ".notify",
        (e) => {
            // notifications.push(e.message);
            // console.log(e);
            // unreadlocal = localStorage.getItem("unread");
            unread.value += 1;
            unreadlocal = unread.value;
            notcolor.value = "text-white";
            notifications.value.push({ content: e.message });
            localStorage.setItem("unread", unreadlocal);
            // page.props.flash.message = e.message;
            // alert(e.message);
            // msg.value = e.mess;
            // console.log(e);
        }
    );

    // window.Echo.private(`user-follow.${page.props.auth.user.id}`).stopListening(
    //     ".follow"
    // );
    // window.Echo.private(`user-follow.${page.props.auth.user.id}`).listen(
    //     ".follow",
    //     (e) => {
    //         // unread.value += 1;
    //         // unreadlocal = unread.value;
    //         // notcolor.value = "text-red-500";
    //         // notifications.value.push({ content: e.data.message });
    //         // localStorage.setItem("unread", unreadlocal);
    //         // if current user is visiting is own page
    //         // if (page.props.auth.user.id == props.userinfo.user.id) {
    //         //     //this first scenerio will never happen but we code it here
    //         //     if (e.data.target_user == page.props.auth.user.id) {
    //         //         followerCount.value = e.data.target_user_follower;
    //         //     }
    //         //     //this will happen when a current auth user is follower
    //         //     if (e.data.user_id == page.props.auth.user.id) {
    //         //         followingCount.value = e.data.user_following;
    //         //     }
    //         // } else {
    //         //     // console.log(props.userinfo.user.id);
    //         //     // console.log(e.target_user);
    //
    //         //     //here we check if user is not visiting his own page but visiting another page
    //         //     if (props.userinfo.user.id == e.data.target_user) {
    //         //         //this will happen when a current user is visiting some target user page
    //         //         follower.value = true;
    //         //         followerCount.value = e.data.target_user_follower;
    //         //     }
    //         //     //this will happen when a current user is visiting some follower user page
    //
    //         //     if (props.userinfo.user.id == e.data.user_id) {
    //         //         followingCount.value = e.data.user_following;
    //         //     }
    //         // }
    //
    //         // if (page.props.auth.user.id) {
    //         // }
    //         // page.props.flash.message = e.message;
    //
    //         // props.userinfo.following = e.data.following;
    //         // props.userinfo.following.push(e.data.following.following);
    //
    //         // alert(e.data.message);
    //         // msg.value = e.mess;
    //         // console.log(e);
    //     }
    // );
});
</script>
