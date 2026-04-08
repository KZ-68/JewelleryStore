<script setup lang="ts">
import { Message } from '@/types/message';

interface MessagesSendedProps {
    messagesSended: Message[] 
}

const props = defineProps<MessagesSendedProps>();

</script>

<template>
    <main>
        <div id="message-box-wrapper" class="bg-white rounded-lg py-4 px-6">
            <section id="message-container">
                <div id="message-resume">
                    <div id="message-resume-header">
                        <h2 id="message-resume-heading" class="text-xl my-4">Sent Box</h2>
                        <hr>
                    </div>
                    <div id="message-resume-body">
                        <h2>Messages Resume :</h2>
                        <p>You have received : {{ props.messagesSended.length > 0 ? props.messagesSended.length : 0 }} messages</p>
                    </div>

                    <div id="messages-list-wrapper">
                        <ul v-if="props.messagesSended.length > 0" class="flex flex-col gap-2">
                            <li v-for="message in props.messagesSended" :key="message.id" class="flex flex-col gap-2">
                                <div id="messages-column-header" class="flex flex-row">
                                    <h3>Message From :</h3>
                                    <p>{{ message.from_email }}</p>
                                </div>
                                <div id="messages-column-center" class="flex flex-row gap-2">
                                    <h4>Subject :</h4>
                                    <a v-if="message.isReaded === false" class="font-bold" href="#">{{ message.subject }}</a>
                                    <a v-else href="#">{{ message.subject }}</a>
                                    <button id="btn btn-danger" href="#" aria-label="Delete">Delete</button>
                                </div>
                                <div id="messages-column-footer" class="flex flex-row">
                                    <h4>Date</h4>
                                    <time id="{{bold}}">{{ message.created_at }}</time>
                                </div>
                            </li>
                        </ul>
                        <ul v-else class="flex flex-col gap-2">
                            <p class="my-8 bg-gray-200 py-3 px-4 rounded-md">No messages has been sended</p>
                        </ul>
                    </div>
                </div>
            </section> 
        </div>
    </main>
</template>