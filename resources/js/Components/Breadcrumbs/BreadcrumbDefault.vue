<script setup lang="ts">
import { useRoute } from "vue-router";
import { computed } from "vue";

const route = useRoute();
const path = computed(() => route.meta);
</script>

<template>
    <div
        class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between"
    >
        <h2 class="text-title-md2 font-semibold text-black dark:text-white">
            {{ path.title }}
        </h2>

        <nav>
            <ol class="flex items-center gap-2">
                <li>
                    <router-link class="font-medium" to="/">
                        Dashboard /
                    </router-link>
                </li>
                <li class="font-medium text-primary">{{ path.title }}</li>
            </ol>
        </nav>
    </div>
</template>
