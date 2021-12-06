<template>
    <div class="bg-gray-900 h-screen w-screen">
        <!--Sidebar-->
        <Sidebar />
        <!--Sidebar end-->

        <!--Main wrapper-->
        <div class="w-full pl-80 h-screen w-screen flex flex-col items-center">

            <!--User info-->
            <div class="w-full flex-shrink-0 bg-gray-800 flex items-center gap-4 px-4 py-2">
                <div class="flex-shrink-0">
                    <img
                        class="h-12 w-12 rounded-full object-cover"
                        :src="contact.profile_photo_url"
                        :alt="contact.name"/>
                </div>
                <div class="text-gray-100 font-medium">
                    {{ contact.name }}
                </div>
                <div class="ml-auto cursor-pointer text-gray-300 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                    </svg>
                </div>
            </div>
            <!--User info end-->

            <!--Messages-->
            <div id="messages" class="flex-grow overflow-y-auto w-full flex justify-center">
                <div class="w-full max-w-xl flex flex-col gap-3 pt-4">
                    <div
                        v-for="(message,index) in messages"
                        class="px-4 py-2 rounded-3xl w-max max-w-sm"
                        :class="message.sender_id === $page.props.user.id ? 'bg-indigo-300 self-end' : 'bg-gray-200'"
                    >
                        <p class="text-sm text-gray-800 text-sm">
                            {{ message.body }}
                        </p>
                        <div class="text-xs text-gray-800 text-right">
                            {{ moment(message.created_at).fromNow() }}
                        </div>
                    </div>
                    <div v-if="messages.length == 0" class="pt-10 text-gray-600 text-2xl text-center">
                        No message yet
                    </div>
                </div>
            </div>
            <!--Messages end-->

            <!--Message box-->
            <form @submit.prevent="submit" class="w-full max-w-xl flex-shrink-0 pt-4 pb-4 flex gap-4 items-center">
                <input
                    v-model="form.body"
                    required
                    class="block w-full py-3 px-4 text-gray-200 border border-gray-700 bg-gray-900 rounded-3xl focus:border-indigo-700 focus:outline-none h-12 text-sm"
                    placeholder="Type your message here"
                />
                <button type="submit" class="text-gray-300 hover:text-indigo-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform rotate-90" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                </button>
            </form>
            <!--Message box end-->

        </div>
        <!--Main wrapper end-->
    </div>
</template>

<script>
import Sidebar from "@/Components/Sidebar";
import moment from "moment";
import vClickOutside from 'click-outside-vue3'

export default {
    name: "Show",
    components: {
        Sidebar
    },
    props: {
        messages: Array,
        contact: Object
    },
    data() {
        return {
            moment: moment,
            form: this.$inertia.form({
                body: null,
                receiver_id: this.contact.id
            })
        }
    },
    methods: {
        submit() {
            this.form.post(this.route('Messages.store'), {
                onFinish: () => {
                    this.form.body = null
                    this.gotoBottom()
                },
            })
        },
        gotoBottom() {
            document.querySelector('#messages').scrollTop = document.querySelector('#messages').scrollHeight;
        }
    },
    created() {
        Echo.channel('chat-' + this.contact.id)
            .listen('NewChatMessage', (e) => {
                console.log('triggered')
                this.messages.push(e.message)
                setTimeout(() => {
                    this.gotoBottom()
                }, 200)
            });
    },
    mounted() {
        this.gotoBottom()
    }
}
</script>
