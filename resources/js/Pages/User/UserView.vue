<script setup lang="ts">
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue";
// import ModalForm from '@/Components/Modal/ModalForm.vue'
import TableUser from "@/components/Tables/TableUser.vue";
import DefaultLayout from "@/layouts/DefaultLayout.vue";
import ButtonDefault from "@/components/Buttons/ButtonDefault.vue";

import { reactive, ref } from "vue";

const header = reactive({
    headerSatu: "Nama Lengkap",
    headerDua: "Email",
    headerTiga: "Role",
    headerEmpat: "Actions",
});
</script>

<template>
    <DefaultLayout>
        <!-- Breadcrumb Start -->
        <BreadcrumbDefault />
        <!-- Breadcrumb End -->

        <div class="flex flex-col gap-10">
            <TableUser
                :headerSatu="header.headerSatu"
                :headerDua="header.headerDua"
                :headerTiga="header.headerTiga"
                :headerEmpat="header.headerEmpat"
            >
                <!-- SLOT START-->
                <ButtonDefault
                    to="/user/create"
                    label="Create"
                    customClasses="bg-meta-3 text-white rounded-md w-3 h-3 mb-3"
                />
                <!-- SLOT END -->
            </TableUser>
        </div>

        <!-- <ModalForm /> -->
    </DefaultLayout>
</template>
