<template>
    <NavBar :message="notMessage" />
    <div>
        <div v-if="props.userinfo.user.id == page.props.auth.user.id">
            <h1>My Profile</h1>
        </div>
        <div v-else>
            {{ props.userinfo.user.name }} Profile
            <div class="flex ml-4">
                <div v-if="!follower && !reqsend">
                    <button
                        class="border bg-gray-300 ml-5"
                        @click.prevent="follow"
                    >
                        Follow
                    </button>
                </div>
                <div v-if="!follower && reqsend">
                    <h1 class="border bg-gray-300 ml-5 font-semibold">
                        Request Sent
                    </h1>
                </div>
                <div v-if="follower && !reqsend">
                    <h1 class="border bg-gray-300 ml-5">Followed</h1>
                </div>
            </div>
        </div>
        <h1>Following:{{ followingCount }}</h1>

        <h1>Followers:{{ followerCount }}</h1>
        <div v-if="props.userinfo.user.id == page.props.auth.user.id">
            <Link :href="route('followreq.index')"> Requests </Link>
        </div>
        <!-- <form @submit.prevent="() => follow()">
            </form> -->
    </div>
</template>

<script setup>
import NavBar from "@/Pages/TopBar/NavBar.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed, onMounted, ref, watch } from "vue";
// import followerCount, followingCount from "@/Composables/Follow";

const follower = ref(false);
const reqsend = ref(false);

const page = usePage();

const props = defineProps({
    userinfo: Object,
});
// const fo = [];
// //  fo.includes()
const notMessage = ref();
const followingCount = ref(0);
const followerCount = ref(0);

followingCount.value = props.userinfo.following.length;
followerCount.value = props.userinfo.follower.length;

follower.value = props.userinfo.follower.some((e) => {
    return e.user === page.props.auth.user.id;
});

reqsend.value = props.userinfo.reqsender.some((e) => {
    return e.user === page.props.auth.user.id;
});

// follower.value = props.userinfo.follower.includes(page.props.auth.user.id);
console.log(props.userinfo);
// onMounted(() => {

// });

onMounted(() => {
    window.Echo.private(`user-follow.${page.props.auth.user.id}`).stopListening(
        ".follow"
    );
    window.Echo.private(`user-follow.${page.props.auth.user.id}`).listen(
        ".follow",
        (e) => {
            console.log("working");

            // if current user is visiting is own page
            if (page.props.auth.user.id == props.userinfo.user.id) {
                //this first scenerio will never happen but we code it here
                if (e.data.target_user == page.props.auth.user.id) {
                    followerCount.value = e.data.target_user_follower;
                }
                //this will happen when a current auth user is follower
                if (e.data.user_id == page.props.auth.user.id) {
                    followingCount.value = e.data.user_following;
                }
            } else {
                console.log(props.userinfo.user.id);
                console.log(e.target_user);
                //here we check if user is not visiting his own page but visiting another page
                if (props.userinfo.user.id == e.data.target_user) {
                    console.log("working");

                    //this will happen when a current user is visiting some target user page
                    follower.value = true;
                    reqsend.value = false;
                    followerCount.value = e.data.target_user_follower;
                }
                //this will happen when a current user is visiting some follower user page
                if (props.userinfo.user.id == e.data.user_id) {
                    followingCount.value = e.data.user_following;
                }
            }
            //         // if (page.props.auth.user.id) {
            //         // }
            //         // page.props.flash.message = e.message;
            //         // props.userinfo.following = e.data.following;
            //         // props.userinfo.following.push(e.data.following.following);
            //         // alert(e.data.message);
            //         // msg.value = e.mess;
            //         console.log(e);
        }
    );
    // window.Echo.private(
    //     `App.Models.User.${page.props.auth.user.id}`
    // ).stopListening(".reqfollow");
    // window.Echo.private(`App.Models.User.${page.props.auth.user.id}`).listen(
    //     ".reqfollow",
    //     (e) => {
    //         // page.props.flash.message = e.message;
    //         // alert(e.message);
    //         // msg.value = e.mess;
    //         // console.log(e);
    //     }
    // );
});

const form = useForm({
    tuser: props.userinfo.user.id,
    follower: page.props.auth.user.id,
    name: page.props.auth.user.name,
});
const follow = () => {
    if (form.processing) {
        return false;
    }
    reqsend.value = true;
    form.post(route("followreq.store"));
};
</script>
