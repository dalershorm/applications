<script setup>
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0"
    >
        <div class="fixed top-0 right-0 px-6 py-4">
            <Link
                v-if="$page.props.user"
                :href="route('dashboard')"
                class="text-sm text-gray-700 underline"
                >Dashboard</Link
            >

            <template v-else>
                <Link
                    :href="route('login')"
                    class="text-sm text-gray-700 underline"
                    >Войти</Link
                >

                <Link
                    v-if="canRegister"
                    :href="route('register')"
                    class="ml-4 text-sm text-gray-700 underline"
                    >Регистрация</Link
                >
            </template>
        </div>

        <div class="lg:w-[400px] w-full mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <main class="mx-auto px-4 pt-10 pb-12 lg:pb-16 w-full">
                    <div class="rounded-md bg-green-50 p-4" v-if="success">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <!-- Heroicon name: mini/check-circle -->
                                <svg
                                    class="h-5 w-5 text-green-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">
                                    Ваша заявка принята
                                </p>
                            </div>
                            <div class="ml-auto pl-3">
                                <div class="-mx-1.5 -my-1.5"></div>
                            </div>
                        </div>
                    </div>

                    <form @submit.prevent="save" v-else>
                        <div class="space-y-4">
                            <div>
                                <h1
                                    class="text-xl font-medium leading-6 text-gray-900 text-center"
                                >
                                    Форма заявки
                                </h1>
                            </div>

                            <div>
                                <label
                                    for="project-name"
                                    class="block text-sm font-medium text-gray-700"
                                    >Имя</label
                                >
                                <div class="mt-1">
                                    <input
                                        type="text"
                                        name="project-name"
                                        id="project-name"
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                        v-model="bid.name"
                                        placeholder="Введите имя"
                                    />
                                </div>
                            </div>
                            <div class="space-y-2">
                                <div class="space-y-1">
                                    <label
                                        for="email"
                                        class="block text-sm font-medium text-gray-700"
                                        >E-mail</label
                                    >
                                    <div class="flex">
                                        <div class="flex-grow">
                                            <input
                                                type="email"
                                                required
                                                name="email"
                                                id="email"
                                                v-model="bid.email"
                                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                                placeholder="Email address"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label
                                    for="phone"
                                    class="block text-sm font-medium text-gray-700"
                                    >Телефон</label
                                >
                                <div class="mt-1">
                                    <input
                                        type="tel"
                                        name="phone"
                                        id="phone"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                        v-model="bid.phone"
                                        placeholder="Введите номер телефона"
                                        required
                                    />
                                </div>
                            </div>

                            <div>
                                <label
                                    for="description"
                                    class="block text-sm font-medium text-gray-700"
                                    >Описание</label
                                >
                                <div class="mt-1">
                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="3"
                                        minlength="10"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                                        placeholder="Введите описание"
                                        required
                                        v-model="bid.description"
                                    ></textarea>
                                </div>
                            </div>

                            <div>
                                <label
                                    for="file"
                                    class="block text-sm font-medium text-gray-700"
                                    >Прикрепить файл</label
                                >
                                <div class="mt-1">
                                    <input
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:placeholder-gray-400"
                                        id="file_input"
                                        type="file"
                                        @change="setUploadFIle"
                                    />
                                </div>
                            </div>

                            <div class="relative flex items-start">
                                <div class="flex h-5 items-center">
                                    <input
                                        id="accept"
                                        aria-describedby="accept"
                                        name="accept"
                                        type="checkbox"
                                        class="h-4 w-4 rounded border-gray-300 text-red-600 focus:ring-red-500"
                                        required
                                    />
                                </div>
                                <div class="ml-3 text-sm">
                                    <label
                                        for="comments"
                                        class="font-medium text-gray-700"
                                        >Согласие на обработку</label
                                    >
                                </div>
                            </div>

                            <div class="flex justify-end">
                                <button
                                    type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent bg-red-500 py-2 px-4 text-sm text-white shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                >
                                    Оформить заявку
                                </button>
                            </div>

                            <div
                                class="rounded-md bg-red-50 p-4"
                                v-if="'message' in errors"
                            >
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <!-- Heroicon name: mini/x-circle -->
                                        <svg
                                            class="h-5 w-5 text-red-400"
                                            xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                            aria-hidden="true"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3
                                            class="text-sm font-medium text-red-800"
                                        >
                                            {{ errors.message }}
                                        </h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <ul
                                                v-for="(
                                                    err, index
                                                ) in errors.errors"
                                                :key="index"
                                                role="list"
                                                class="list-disc space-y-1 pl-5"
                                            >
                                                <li
                                                    v-for="(item, index) in err"
                                                    :key="index"
                                                >
                                                    {{ item }}
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            bid: {
                name: "",
                phone: "",
                email: "",
                description: "",
            },
            fd: new FormData(),
            success: false,
            errors: [],
        };
    },
    methods: {
        save() {
            this.errors = [];
            this.success = false;

            this.fd.append("name", this.bid.name);
            this.fd.append("phone", this.bid.phone);
            this.fd.append("email", this.bid.email);
            this.fd.append("description", this.bid.description);

            axios
                .post("/api/applications", this.fd)
                .then((res) => {
                    console.log(res);
                    this.success = true;
                })
                .catch((err) => {
                    this.errors = err.response.data;
                    console.log(err.response.data.errors);
                });
        },

        setUploadFIle(event) {
            console.log(event.target.files[0]);
            this.fd.append("file", event.target.files[0]);
        },
    },
};
</script>
