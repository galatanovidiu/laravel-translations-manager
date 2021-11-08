<template>
    <Head title="Translations manager Dashboard"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-8">
                            <div class="">
<!--                                <label for="language_selector" class="whitespace-nowrap">Language:</label>-->
                                <select id="language_selector" v-model="selected_language" class="block focus:ring-indigo-500 focus:border-indigo-500 w-full shadow-sm sm:max-w-xs sm:text-sm border-gray-300 rounded-md" @change="getTranslations">
                                    <option v-for="l in languages" :value="l.abbr">{{ l.name }} ({{
                                            l.original_name
                                        }})
                                    </option>
                                </select>
                            </div>
                            <form @submit.prevent="submit" enctype="multipart/form-data">
                                <label for="upload_file">
                                    <Button tag="span" bg-color="bg-indigo-500">
                                        Import from CSV or JSON
                                    </Button>
                                    <input type="file" id="upload_file" class="hidden" accept=".csv,.json" @input="form.import_file = $event.target.files[0]" @change="submitFileImport">
                                </label>
                            </form>

                            <Button bg-color="bg-green-500" @click="importFromLaravel">{{importing_from_laravel ? 'Importing from Laravel lang folder ...' : 'Import from Laravel lang folder'}}</Button>
                        </div>

                        <div>
                            <div v-for="t in translations" :key="t.id">
                                <div>{{t.string}}</div>
                                <textarea id="" v-model="t.translation.translation" class="shadow-sm block w-full focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border border-gray-300 rounded-md"></textarea>
                            </div>
                        </div>

                        <div class="pt-8">
                            <Button type="button" bg-color="bg-indigo-500" @click="saveTranslations" :disabled="is_saving">
                                {{ is_saving ? 'Saving...' : 'Save' }}</Button>
                        </div>
                    </div>
                </div>
            </div>

            <notification :show="is_saved" @was_saved="closeNotification">{{ notification }}</notification>

        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head} from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3'
import Button from "@/Components/Button";
import Notification from "@/Components/Notification";
import Cookies from 'js-cookie'


export default {
    components: {
        Notification,
        Button,
        BreezeAuthenticatedLayout,
        Head,
    },
    props: {
        languages: Array,
        initial_selected_language: String,
        initial_translations: Array,
    },
    data() {
        return {
            selected_language: this.initial_selected_language,
            translations: this.initial_translations,
            form: this.$inertia.form({
                import_file: null,
            }),
            is_saving: false,
            is_saved: false,
            importing_from_laravel: false,
            loading_translations: false,
            notification: ''
        }
    },
    mounted() {
    },
    methods: {

        getTranslations(){
            self = this
            self.loading_translations = true;
            axios.get('/api/get_translations?selected_language=' + this.selected_language).then(response => {
                this.translations = response.data
                self.loading_translations = true;
            })
        },

        saveTranslations(){
            self = this
            self.is_saving = true;
            axios.post('/api/save_translations', {
                selected_language: this.selected_language,
                translations: this.translations
            }).then(response => {
                self.is_saving = false;
                self.is_saved = true;
                self.notification = "Translations saved successfully";
            })
        },

        submitFileImport() {

            let formData = new FormData();
            formData.append('file', this.form.import_file);
            formData.append('selected_language', this.selected_language);

            axios.post('/api/import_strings', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                this.translations = response.data
                this.is_saved = true
                this.notification = 'Import done'
            })
        },

        importFromLaravel(){
            this.importing_from_laravel = true;
            axios.post('/api/import_from_laravel', {
                selected_language: this.selected_language
            }).then(response => {
                this.translations = response.data
                this.is_saved = true
                this.importing_from_laravel = false
                this.notification = 'Import from laravel is done'
            })
        },

        closeNotification(){
            this.is_saved = false
            this.notification = 'false'
        }

    },
    watch: {
        selected_language(new_value, old_value){
            Cookies.set('selected_language', new_value)
        }
    }
}
</script>
