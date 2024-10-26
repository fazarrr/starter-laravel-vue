<script setup lang="ts">
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue";
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import DefaultCard from "@/Components/Forms/DefaultCard.vue";
import InputGroup from "@/components/Forms/InputGroup.vue";
import SelectGroupTwo from "@/components/Forms/SelectGroup/SelectGroupTwo.vue";
import ButtonDefault from "@/components/Buttons/ButtonDefault.vue";
import { onMounted, reactive, ref } from "vue";
import { useRoute } from "vue-router";
import axios from "axios";
import router from "../../Routers";

const route = useRoute();
const id = route.params.id;

const loading = ref("animate-pulse");

const props = reactive({
    label: "Role",
    customClass: "w-full xl:w-1/2",
    data: [
        { key: "Super Admin", value: "Super Admin" },
        { key: "Admin", value: "Admin" },
        { key: "User", value: "User" },
    ],
    required: true,
});

const status = reactive({
    label: "Status",
    customClass: "w-full xl:w-1/2",
    data: [
        { key: 1, value: "Aktif" },
        { key: 0, value: "Non Aktif" },
    ],
    required: true,
});

const data = reactive({
    namaLengkap: "Loading...",
    email: "Loading...",
    password: "Loading...",
    role: "",
    status: "",
});

const handleRole = (value) => {
    data.role = value; // This will get the selected value from the child
};

const handleStatus = (value) => {
    data.status = value; // This will get the selected value from the child
};

onMounted(async () => {
    const res = await axios({
        method: "get",
        url: `/api/v1/user/${id}`,
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
    })
        .then((response) => {
            data.namaLengkap = response.data.data.name;
            data.email = response.data.data.email;
            data.password = "";

            loading.value = "";

            // Assuming 'roles' is an array with the user's role
            if (
                response.data.data.roles &&
                response.data.data.roles.length > 0
            ) {
                data.role = response.data.data.roles; // Set the first role as selected
            }

            data.status = response.data.data.is_active; // Set the first status as selected
        })
        .catch((e) => {
            console.log(e);
        });
});

const submit = () => {
    axios({
        method: "put",
        url: `/api/v1/user/${id}`,
        headers: {
            "Content-Type": "application/json",
            Authorization: `Bearer ${localStorage.getItem("token")}`,
        },
        data: {
            name: data.namaLengkap,
            email: data.email,
            password: data.password,
            role: data.role,
            status: data.status,
        },
    })
        .then(() => {
            router.push({ name: "user" });
        })
        .catch((e) => {
            alert(e.response.data.message);
        });
};
</script>

<template>
    <DefaultLayout>
        <BreadcrumbDefault />

        <DefaultCard cardTitle="User Form" :class="loading">
            <form>
                <div class="p-6.5">
                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <InputGroup
                            label="Nama Lengkap"
                            type="text"
                            v-model="data.namaLengkap"
                            placeholder="Nama Lengkap ..."
                            customClasses="w-full xl:w-1/2"
                            required
                        />

                        <InputGroup
                            label="Email"
                            type="email"
                            v-model="data.email"
                            placeholder="Email ..."
                            customClasses="w-full xl:w-1/2"
                            required
                        />
                    </div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <InputGroup
                            label="Password"
                            type="text"
                            v-model="data.password"
                            placeholder="Password ..."
                            customClasses="w-full xl:w-1/2"
                            required
                        />

                        <SelectGroupTwo
                            :label="props.label"
                            :customClass="props.customClass"
                            :data="props.data"
                            :required="props.required"
                            v-model="data.role"
                            @update:selectedOption="handleRole"
                        />
                    </div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <SelectGroupTwo
                            :label="status.label"
                            :customClass="status.customClass"
                            :data="status.data"
                            :required="status.required"
                            v-model="data.status"
                            @update:selectedOption="handleStatus"
                        />
                    </div>

                    <ButtonDefault
                        @click.prevent="submit(id)"
                        to="#"
                        type="submit"
                        label="Simpan"
                        customClasses="bg-meta-3 text-white rounded-md w-3 h-3 ml-5"
                    />

                    <ButtonDefault
                        to="/user"
                        label="Batal"
                        customClasses="bg-meta-1 text-white rounded-md w-3 h-3 ml-5"
                    />
                </div>
            </form>
        </DefaultCard>
    </DefaultLayout>
</template>
