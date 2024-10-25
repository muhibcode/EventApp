<template>
    <NavBar />
    <form @submit.prevent="submit">
        <div class="ml-10 w-48">
            <div>
                <InputLabel for="title" value="Title" />

                <input
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.title"
                    autofocus
                />

                <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
            </div>
            <div class="mt-5">
                <InputLabel for="city" value="City" />

                <input
                    id="city"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.city"
                />
                <!-- <h4>{{ form.errors.city }}</h4> -->
                <!-- <InputError class="mt-2" :message="form.errors.country" /> -->
            </div>
            <div class="mt-5">
                <InputLabel for="venue" value="Venue" />

                <input
                    id="venue"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.venue"
                />

                <!-- <InputError class="mt-2" :message="form.errors.beds" /> -->
            </div>

            <div class="mt-5">
                <InputLabel for="heldAt" value="Held At" />

                <input
                    id="heldAt"
                    type="date"
                    class="mt-1 block w-full"
                    v-model="form.heldAt"
                />

                <!-- <InputError class="mt-2" :message="form.errors.address" /> -->
            </div>
            <div class="mt-5">
                <InputLabel for="desc" value="Description" />

                <input
                    id="desc"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                />

                <!-- <InputError class="mt-2" :message="form.errors.address" /> -->
            </div>
            <!-- <div class="mt-5">
                <InputLabel for="desc" value="Address" />

                <input
                    id="desc"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.address"
                />

            </div> -->
            <div class="mt-5">
                <InputLabel for="time" value="Time" />

                <input
                    id="time"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.time"
                />

                <!-- <InputError class="mt-2" :message="form.errors.address" /> -->
            </div>

            <div class="mt-5">
                <InputLabel for="category" value="Category" />
                <select name="category" v-model="form.type">
                    <option
                        v-for="(item, index) in type"
                        :key="index"
                        :value="item"
                    >
                        {{ item }}
                    </option>
                </select>

                <!-- <InputError class="mt-2" :message="form.errors.code" /> -->
            </div>

            <!-- <div class="mt-5">
                <InputLabel for="comment" value="Open Comments" />
                <input type="checkbox" v-model="form.open_comment" />

            </div> -->

            <!-- <div class="mt-5">
                <InputLabel for="active" value="Active" />
                <input type="checkbox" v-model="form.active" />

            </div> -->
        </div>

        <PrimaryButton
            class="mt-10 ml-10 ms-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
        >
            Register
        </PrimaryButton>
    </form>
    <!-- <h1>{{ $page.props.flash.message }}</h1> -->
</template>
<script setup>
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavBar from "@/Pages/TopBar/NavBar.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    city: "",
    venue: "",
    heldAt: "",
    time: "",
    description: "",
    type: "",
});
const type = ["Cultural", "Sports", "Music", "Dance", "Science", "Arts"];
const submit = () => {
    // localStorage.setItem()
    form.post(route("event.store"));
    // console.log(form.data);
};
// {date:
//     activity[]
// }
// defineProps({ listing: String })
</script>
