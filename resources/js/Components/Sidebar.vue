<template>
    <div class="w-80 bg-gray-800 h-full overflow-y-auto px-2 py-4 fixed left-0 top-0 border-r border-gray-700">
        <!--Search-->
        <div class="flex items-center gap-5 px-4">
            <div v-click-outside="hideSetting"
                 class="flex-shrink-0 text-gray-300 hover:text-white cursor-pointer relative">
                <button @click="showSetting=!showSetting">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h8m-8 6h16"/>
                    </svg>
                </button>
                <div v-show="showSetting" class="absolute w-44 left-0 top-full shadow rounded-md bg-white py-1">
                    <inertia-link
                        :href="route('profile.show')"
                        class="block py-1 px-4 text-gray-800 hover:bg-gray-100"
                    >
                        Profile
                    </inertia-link>
                    <inertia-link
                        method="post"
                        :href="route('logout')"
                        class="block py-1 px-4 text-gray-800 hover:bg-gray-100"
                    >
                        Log out
                    </inertia-link>
                </div>
            </div>
            <div class="flex-grow">
                <input
                    type="text"
                    class="block w-full border border-gray-700 px-4 py-1 text-gray-200 bg-gray-900 rounded-3xl"
                    placeholder="Search"
                >
            </div>
        </div>
        <!--Search end-->

        <!--User list-->
        <div class="space-y-1 mt-2">
            <inertia-link
                :href="route('Messages.show',user.id)" v-for="user in $page.props.contacts"
                class="flex gap-4 rounded-md py-2 px-2 cursor-pointer items-center"
                :class="route().current('Messages.show',user.id) ? 'bg-indigo-600' : 'hover:bg-gray-700'"
            >
                <div class="flex-shrink-0">
                    <img
                        class="h-12 w-12 rounded-full object-cover"
                        :src="user.profile_photo_url"
                        :alt="user.name"
                    />
                </div>
                <div class="flex-grow relative">
                    <p class="text-gray-100 font-medium text-gray-100">
                        {{ user.name }}
                    </p>
                    <div v-if="user.unreadMessages" class="absolute right-0 top-0 bottom-0 flex items-center">
                        <div class="w-5 h-5 rounded-full bg-red-500 flex items-center justify-center text-xs text-white">
                           {{ user.unreadMessages > 9 ? '9' : user.unreadMessages }}
                        </div>
                    </div>
                </div>
            </inertia-link>
        </div>
        <!--User list end-->
    </div>
</template>

<script>
import vClickOutside from "click-outside-vue3";

export default {
    name: "Sidebar",
    directives: {
        clickOutside: vClickOutside.directive
    },
    data() {
        return {
            showSetting: false
        }
    },
    methods: {
        hideSetting() {
            this.showSetting = false
        }
    }
}
</script>
