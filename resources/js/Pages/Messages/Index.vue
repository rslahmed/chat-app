<template>
    <div class="bg-gray-900 h-screen w-screen">
        <!--Sidebar-->
        <Sidebar/>
        <!--Sidebar end-->

        <!--Main wrapper-->
        <div class="w-full pl-80 h-screen w-screen flex items-center justify-center">
            <p class="text-gray-600 text-2xl font-medium">
                Select a contact to start conversation
            </p>
        </div>
        <!--Main wrapper end-->
    </div>
</template>

<script>
import Sidebar from "@/Components/Sidebar";

export default {
    name: "Home",
    components: {
        Sidebar
    },
}
</script>
