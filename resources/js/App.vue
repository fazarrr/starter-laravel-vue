<template>
    <!-- <router-view></router-view> -->
    <router-view v-slot="{ Component, route }">
        <div :key="route.name">
            <Component :is="Component" />
        </div>
    </router-view>
</template>

<script>
export default {
    name: "App",
};
</script>
